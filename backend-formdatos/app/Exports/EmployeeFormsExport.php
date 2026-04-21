<?php

namespace App\Exports;

use App\Models\EmployeeForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeFormsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return EmployeeForm::with([
            'sex:id,name,code',
            'maritalStatus:id,name,code',
            'laborRegime:id,name,code',
            'pensionRegime:id,name,code',
            'dependency:id,name,code',
        ])
        ->orderBy('id', 'desc')
        ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'APELLIDOS Y NOMBRES',
            'DNI',
            'RUC',
            'SEXO',
            'ESTADO CIVIL',
            'FECHA DE NACIMIENTO',
            'LUGAR DE NACIMIENTO',
            'TIENE DISCAPACIDAD',
            'CONADIS RUI',
            'DIRECCIÓN',
            'REFERENCIA',
            'DISTRITO',
            'PROVINCIA',
            'DEPARTAMENTO',
            'CELULAR',
            'CORREO PERSONAL',
            'CONTACTO EMERGENCIA',
            'CELULAR EMERGENCIA',
            'PROFESIÓN',
            'CARGO ACTUAL',
            'DEPENDENCIA ACTUAL',
            'CONTRATO O RESOLUCIÓN',
            'FECHA DE VÍNCULO',
            'RÉGIMEN LABORAL',
            'CONDICIÓN LABORAL',
            'RÉGIMEN PENSIONARIO',
            'CÓDIGO AIRSHSP',
            'CORREO INSTITUCIONAL',
            'TIENE VÍNCULO LABORAL',
            'FECHA FIN DE VÍNCULO',
            'ES PADRE/MADRE',
            'FECHA DE REGISTRO',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->full_name,
            $row->dni,
            $row->ruc,
            $row->sex?->name,
            $row->maritalStatus?->name,
            $row->birth_date,
            $row->birth_place,
            $row->has_disability ? 'SÍ' : 'NO',
            $row->conadis_rui,
            $row->address,
            $row->reference,
            $row->district,
            $row->province,
            $row->department,
            $row->cellphone,
            $row->personal_email,
            $row->emergency_contact_name,
            $row->emergency_contact_phone,
            $row->profession,
            $row->current_position,
            $row->dependency?->name,
            $row->contract_resolution_number,
            $row->employment_start_date,
            $row->laborRegime?->name,
            $row->labor_condition,
            $row->pensionRegime?->name,
            $row->airshsp_code,
            $row->institutional_email,
            $row->has_labor_link ? 'SÍ' : 'NO',
            $row->labor_end_date,
            $row->is_parent ? 'SÍ' : 'NO',
            $row->created_at,
        ];
    }
}