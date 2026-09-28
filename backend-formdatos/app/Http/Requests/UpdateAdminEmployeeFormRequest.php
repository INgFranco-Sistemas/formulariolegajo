<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminEmployeeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeFormId = $this->route('id');

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'dni' => [
                'required',
                'digits:8',
                Rule::unique('employee_forms', 'dni')->ignore($employeeFormId),
            ],
            'ruc' => ['nullable', 'digits:11'],

            'sex_id' => ['required', 'integer', 'exists:sexes,id'],
            'marital_status_id' => ['required', 'integer', 'exists:marital_statuses,id'],

            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:255'],

            'has_disability' => ['required', 'boolean'],
            'conadis_rui' => ['nullable', 'string', 'max:50', Rule::requiredIf(fn () => $this->boolean('has_disability'))],

            'address' => ['required', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:150'],
            'province' => ['required', 'string', 'max:150'],
            'department' => ['required', 'string', 'max:150'],

            'cellphone' => ['required', 'string', 'max:20'],
            'personal_email' => ['required', 'email', 'max:150'],

            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:20'],

            'academic_education' => [
                'required',
                'string',
                Rule::in([
                    'TITULO UNIVERSITARIO',
                    'BACHILLER',
                    'EGRESADO UNIVERSITARIO',
                    'TITULADO TECNICO',
                    'EGRESADO TECNICO',
                    'ESTUDIANTE',
                    'INCONCLUSO',
                ]),
            ],

            'profession' => ['required', 'string', 'max:255'],
            'current_position' => ['required', 'string', 'max:255'],
            'dependency_id' => ['required', 'integer', 'exists:dependencies,id'],
            'current_dependency' => ['nullable', 'string', 'max:255'],
            'contract_resolution_number' => ['required', 'string', 'max:100'],
            'employment_start_date' => ['required', 'date'],

            'labor_regime_id' => ['required', 'integer', 'exists:labor_regimes,id'],
            'labor_condition' => [
                'required',
                'string',
                Rule::in([
                    'CAS CONFIANZA',
                    'CAS INDETERMINADO',
                    'CAS TEMPORAL',
                    'CAS SUPLENCIA',
                    'CAS MEDIDA CAUTELAR',
                    'NOMBRADO',
                    'TEMPORAL',
                    'SUPLENCIA',
                    'CONFIANZA',
                    'MANDATO JUDICIAL',
                    'CARGO PROYECTO DE INVERSION',
                    'SERVIR',
                    'GOBERNADOR',
                    'VICE GOBERNADOR',
                    'CONSEJERO DELEGADO',
                    'CONSEJERO REGIONAL',
                    'PRACTICANTE',
                    'TITULAR',
                ]),
            ],
            'pension_regime_id' => ['required', 'integer', 'exists:pension_regimes,id'],

            'has_professional_license' => [
                'required',
                'boolean',
            ],

            'professional_license_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::requiredIf(fn () => $this->boolean('has_professional_license')),
            ],

            'professional_license_valid_until' => [
                'nullable',
                'date',
                Rule::requiredIf(fn () => $this->boolean('has_professional_license')),
            ],

            'institutional_email' => ['nullable', 'email', 'max:150'],

            'has_labor_link' => ['required', 'boolean'],
            'labor_end_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn () => !$this->boolean('has_labor_link')),
            ],

            'is_parent' => ['required', 'boolean'],

            'family_members' => ['nullable', 'array'],
            'family_members.*.full_name' => ['required_with:family_members', 'string', 'max:255'],
            'family_members.*.dni' => ['nullable', 'digits:8'],
            'family_members.*.age' => ['required_with:family_members', 'integer', 'min:0', 'max:120'],
            'family_members.*.sex_id' => ['required_with:family_members', 'integer', 'exists:sexes,id'],
            'family_members.*.relationship_id' => ['required_with:family_members', 'integer', 'exists:family_relationships,id'],
        ];
    }
}