<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeFormRequest;
use App\Models\EmployeeForm;
use App\Models\FamilyRelationship;
use App\Models\LaborRegime;
use App\Models\MaritalStatus;
use App\Models\PensionRegime;
use App\Models\Sex;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Throwable;

class EmployeeFormController extends Controller
{
    public function checkDni(Request $request): JsonResponse
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
        ]);

        $exists = EmployeeForm::where('dni', $request->dni)->exists();

        return response()->json([
            'success' => true,
            'data' => [
                'exists' => $exists,
            ],
            'message' => $exists
                ? 'Ya existe una ficha registrada con este DNI.'
                : 'El DNI está disponible.',
        ]);
    }

    public function catalogs(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'sexes' => Sex::select('id', 'name', 'code')->orderBy('id')->get(),
                'marital_statuses' => MaritalStatus::select('id', 'name', 'code')->orderBy('id')->get(),
                'labor_regimes' => LaborRegime::select('id', 'name', 'code')->orderBy('id')->get(),
                'pension_regimes' => PensionRegime::select('id', 'name', 'code')->orderBy('id')->get(),
                'family_relationships' => FamilyRelationship::select('id', 'name', 'code')->orderBy('id')->get(),
            ],
        ]);
    }

    public function store(StoreEmployeeFormRequest $request): JsonResponse
    {
        try {
            $employeeForm = DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $familyMembers = $validated['family_members'] ?? [];
                unset($validated['family_members']);

                $validated['submitted_at'] = now();
                $validated['ip_address'] = $request->ip();
                $validated['user_agent'] = $request->userAgent();
                $validated['status'] = 'submitted';

                $employeeForm = EmployeeForm::create($validated);

                foreach ($familyMembers as $familyMember) {
                    $employeeForm->familyMembers()->create($familyMember);
                }

                return $employeeForm->load([
                    'sex:id,name,code',
                    'maritalStatus:id,name,code',
                    'laborRegime:id,name,code',
                    'pensionRegime:id,name,code',
                    'familyMembers.sex:id,name,code',
                    'familyMembers.relationship:id,name,code',
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'La ficha fue registrada correctamente.',
                'data' => $employeeForm,
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al registrar la ficha.',
                'error' => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
