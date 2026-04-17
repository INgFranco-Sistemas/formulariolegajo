<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminEmployeeFormRequest;
use App\Models\EmployeeForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminEmployeeFormController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = EmployeeForm::query()
            ->with([
                'sex:id,name,code',
                'maritalStatus:id,name,code',
                'laborRegime:id,name,code',
                'pensionRegime:id,name,code',
            ])
            ->latest('id');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'ilike', "%{$search}%")
                    ->orWhere('dni', 'ilike', "%{$search}%")
                    ->orWhere('personal_email', 'ilike', "%{$search}%")
                    ->orWhere('institutional_email', 'ilike', "%{$search}%");
            });
        }

        $perPage = (int) $request->get('per_page', 10);

        if ($perPage < 1) {
            $perPage = 10;
        }

        if ($perPage > 100) {
            $perPage = 100;
        }

        $forms = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $forms,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $form = EmployeeForm::with([
            'sex:id,name,code',
            'maritalStatus:id,name,code',
            'laborRegime:id,name,code',
            'pensionRegime:id,name,code',
            'familyMembers.sex:id,name,code',
            'familyMembers.relationship:id,name,code',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $form,
        ]);
    }

    public function update(UpdateAdminEmployeeFormRequest $request, int $id): JsonResponse
    {
        $employeeForm = EmployeeForm::with('familyMembers')->findOrFail($id);

        $updated = DB::transaction(function () use ($request, $employeeForm) {
            $validated = $request->validated();

            $familyMembers = $validated['family_members'] ?? [];
            unset($validated['family_members']);

            $employeeForm->update($validated);

            $employeeForm->familyMembers()->delete();

            foreach ($familyMembers as $member) {
                $employeeForm->familyMembers()->create($member);
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
            'message' => 'La ficha fue actualizada correctamente.',
            'data' => $updated,
        ]);
    }
}