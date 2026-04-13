<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeeFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'digits:8', 'unique:employee_forms,dni'],
            'ruc' => ['nullable', 'digits:11'],

            'sex_id' => ['required', 'integer', 'exists:sexes,id'],
            'marital_status_id' => ['required', 'integer', 'exists:marital_statuses,id'],

            'birth_date' => ['required', 'date'],
            'birth_place' => ['required', 'string', 'max:255'],

            'has_disability' => ['required', 'boolean'],
            'conadis_rui' => ['nullable', 'string', 'max:50', Rule::requiredIf(fn() => $this->boolean('has_disability'))],

            'address' => ['required', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:150'],
            'province' => ['required', 'string', 'max:150'],
            'department' => ['required', 'string', 'max:150'],

            'cellphone' => ['required', 'string', 'max:20'],
            'personal_email' => ['required', 'email', 'max:150'],

            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:20'],

            'profession' => ['required', 'string', 'max:255'],
            'current_position' => ['required', 'string', 'max:255'],
            'current_dependency' => ['required', 'string', 'max:255'],
            'contract_resolution_number' => ['required', 'string', 'max:100'],
            'employment_start_date' => ['required', 'date'],

            'labor_regime_id' => ['required', 'integer', 'exists:labor_regimes,id'],
            'labor_condition' => ['nullable', 'string', 'max:150'],
            'pension_regime_id' => ['required', 'integer', 'exists:pension_regimes,id'],

            'airshsp_code' => ['nullable', 'string', 'max:50'],
            'institutional_email' => ['nullable', 'email', 'max:150'],

            'has_labor_link' => ['required', 'boolean'],
            'labor_end_date' => [
                'nullable',
                'date',
                Rule::requiredIf(fn() => !$this->boolean('has_labor_link')),
            ],

            'is_parent' => ['required', 'boolean'],

            'family_members' => [
                'nullable',
                'array',
                Rule::requiredIf(fn() => $this->boolean('is_parent')),
            ],
            'family_members.*.full_name' => ['required_with:family_members', 'string', 'max:255'],
            'family_members.*.dni' => ['nullable', 'digits:8'],
            'family_members.*.age' => ['required_with:family_members', 'integer', 'min:0', 'max:120'],
            'family_members.*.sex_id' => ['required_with:family_members', 'integer', 'exists:sexes,id'],
            'family_members.*.relationship_id' => ['required_with:family_members', 'integer', 'exists:family_relationships,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'El campo apellidos y nombres es obligatorio.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique' => 'Ya existe una ficha registrada con este DNI.',

            'ruc.digits' => 'El RUC debe tener exactamente 11 dígitos.',

            'sex_id.required' => 'Debe seleccionar el sexo.',
            'sex_id.exists' => 'El sexo seleccionado no es válido.',

            'marital_status_id.required' => 'Debe seleccionar el estado civil.',
            'marital_status_id.exists' => 'El estado civil seleccionado no es válido.',

            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'birth_place.required' => 'El lugar de nacimiento es obligatorio.',

            'has_disability.required' => 'Debe indicar si tiene discapacidad.',
            'conadis_rui.required' => 'El CONADIS RUI es obligatorio cuando indica que sí tiene discapacidad.',

            'address.required' => 'La dirección actual es obligatoria.',
            'district.required' => 'El distrito es obligatorio.',
            'province.required' => 'La provincia es obligatoria.',
            'department.required' => 'El departamento es obligatorio.',

            'cellphone.required' => 'El celular es obligatorio.',
            'personal_email.required' => 'El correo personal es obligatorio.',
            'personal_email.email' => 'El correo personal no tiene un formato válido.',

            'emergency_contact_name.required' => 'El contacto de emergencia es obligatorio.',
            'emergency_contact_phone.required' => 'El celular del contacto de emergencia es obligatorio.',

            'profession.required' => 'La profesión es obligatoria.',
            'current_position.required' => 'El cargo actual es obligatorio.',
            'current_dependency.required' => 'La dependencia actual es obligatoria.',
            'contract_resolution_number.required' => 'El contrato o resolución es obligatorio.',
            'employment_start_date.required' => 'La fecha de vínculo es obligatoria.',

            'labor_regime_id.required' => 'Debe seleccionar el régimen laboral.',
            'labor_regime_id.exists' => 'El régimen laboral seleccionado no es válido.',

            'pension_regime_id.required' => 'Debe seleccionar el régimen pensionario.',
            'pension_regime_id.exists' => 'El régimen pensionario seleccionado no es válido.',

            'institutional_email.email' => 'El correo institucional no tiene un formato válido.',

            'has_labor_link.required' => 'Debe indicar si tiene vínculo laboral.',
            'labor_end_date.required' => 'La fecha de fin de vínculo es obligatoria cuando indica que no tiene vínculo laboral.',

            'is_parent.required' => 'Debe indicar si es padre o madre de familia.',

            'family_members.required' => 'Debe registrar al menos un familiar cuando indica que es padre o madre de familia.',

            'family_members.array' => 'El bloque de familiares debe enviarse como una lista válida.',

            'family_members.*.full_name.required_with' => 'El nombre completo del familiar es obligatorio.',
            'family_members.*.dni.digits' => 'El DNI del familiar debe tener exactamente 8 dígitos.',
            'family_members.*.age.required_with' => 'La edad del familiar es obligatoria.',
            'family_members.*.age.integer' => 'La edad del familiar debe ser un número entero.',
            'family_members.*.age.min' => 'La edad del familiar no puede ser negativa.',
            'family_members.*.age.max' => 'La edad del familiar no puede ser mayor a 120.',
            'family_members.*.sex_id.required_with' => 'Debe seleccionar el sexo del familiar.',
            'family_members.*.sex_id.exists' => 'El sexo del familiar no es válido.',
            'family_members.*.relationship_id.required_with' => 'Debe seleccionar el parentesco del familiar.',
            'family_members.*.relationship_id.exists' => 'El parentesco del familiar no es válido.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->boolean('is_parent')) {
                $familyMembers = $this->input('family_members', []);

                if (!is_array($familyMembers) || count($familyMembers) < 1) {
                    $validator->errors()->add(
                        'family_members',
                        'Debe registrar al menos un familiar cuando indica que es padre o madre de familia.'
                    );
                }
            }
        });
    }
}
