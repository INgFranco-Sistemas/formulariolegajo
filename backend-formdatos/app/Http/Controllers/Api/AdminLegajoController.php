<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeForm;
use App\Models\Legajo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLegajoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Legajo::query()
            ->with([
                'employeeForm:id,full_name,dni,cellphone,personal_email,current_position',
                'dependency:id,name,code',
                'laborRegime:id,name,code',
            ])
            ->latest('id');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('legajo_number', 'ilike', "%{$search}%")
                    ->orWhereHas('employeeForm', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('full_name', 'ilike', "%{$search}%")
                            ->orWhere('dni', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('dependency', function ($dependencyQuery) use ($search) {
                        $dependencyQuery->where('name', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', strtoupper($request->status));
        }

        $perPage = (int) $request->get('per_page', 10);

        if ($perPage < 1) {
            $perPage = 10;
        }

        if ($perPage > 100) {
            $perPage = 100;
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate($perPage),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_form_id' => ['required', 'integer', 'exists:employee_forms,id'],
            'physical_location' => ['nullable', 'string', 'max:255'],
            'digital_location' => ['nullable', 'string', 'max:255'],
            'observations' => ['nullable', 'string'],
        ], [
            'employee_form_id.required' => 'Debe seleccionar un trabajador.',
            'employee_form_id.exists' => 'El trabajador seleccionado no existe.',
        ]);

        $employee = EmployeeForm::findOrFail($validated['employee_form_id']);

        $existingLegajo = Legajo::where('employee_form_id', $employee->id)->first();

        if ($existingLegajo) {
            return response()->json([
                'success' => false,
                'message' => 'Este trabajador ya cuenta con un legajo aperturado.',
            ], 422);
        }

        $legajo = DB::transaction(function () use ($employee, $validated) {
            $legajoNumber = $this->generateLegajoNumber($employee);

            return Legajo::create([
                'employee_form_id' => $employee->id,
                'legajo_number' => $legajoNumber,
                'status' => 'ACTIVO',
                'opening_date' => now()->toDateString(),
                'physical_location' => $validated['physical_location'] ?? null,
                'digital_location' => $validated['digital_location'] ?? null,
                'dependency_id' => $employee->dependency_id,
                'labor_regime_id' => $employee->labor_regime_id,
                'position_name' => $employee->current_position,
                'folios_total' => 0,
                'observations' => $validated['observations'] ?? null,
            ]);
        });

        $legajo->load([
            'employeeForm:id,full_name,dni,cellphone,personal_email,current_position',
            'dependency:id,name,code',
            'laborRegime:id,name,code',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Legajo aperturado correctamente.',
            'data' => $legajo,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $legajo = Legajo::with([
            'employeeForm.sex:id,name,code',
            'employeeForm.maritalStatus:id,name,code',
            'employeeForm.dependency:id,name,code',
            'employeeForm.laborRegime:id,name,code',
            'employeeForm.pensionRegime:id,name,code',
            'employeeForm.familyMembers.sex:id,name,code',
            'employeeForm.familyMembers.relationship:id,name,code',
            'dependency:id,name,code',
            'laborRegime:id,name,code',
        ])->findOrFail($id);

        $sections = \App\Models\LegajoSection::where('is_active', true)
        ->where('number', '<=', 10)
        ->orderBy('number')
        ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'legajo' => $legajo,
                'sections' => $sections,
            ],
        ]);
    }

    private function generateLegajoNumber(EmployeeForm $employee): string
    {
        $year = now()->format('Y');

        $nextNumber = Legajo::whereYear('created_at', $year)->count() + 1;

        return 'LEG-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT) . '-' . $employee->dni;
    }
}