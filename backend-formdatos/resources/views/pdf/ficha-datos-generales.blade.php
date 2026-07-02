<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111827; }
        .title { text-align: center; font-weight: bold; font-size: 16px; margin-bottom: 10px; }
        .section { background: #e5e7eb; font-weight: bold; padding: 6px; border: 1px solid #111; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #111; padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 30%; background: #f9fafb; }
        .center { text-align: center; }
        .signature { margin-top: 50px; text-align: center; }
    </style>
</head>
<body>

<div class="title">ANEXO N° 03<br>FICHA DE DATOS GENERALES</div>

<div class="section">I. DATOS PERSONALES</div>
<table>
    <tr>
        <td class="label">APELLIDOS Y NOMBRES</td>
        <td>{{ $employee->full_name }}</td>
    </tr>
    <tr>
        <td class="label">DNI N°</td>
        <td>{{ $employee->dni }}</td>
    </tr>
    <tr>
        <td class="label">RUC N°</td>
        <td>{{ $employee->ruc }}</td>
    </tr>
    <tr>
        <td class="label">SEXO</td>
        <td>{{ $employee->sex?->name }}</td>
    </tr>
    <tr>
        <td class="label">ESTADO CIVIL</td>
        <td>{{ $employee->maritalStatus?->name }}</td>
    </tr>
    <tr>
        <td class="label">FECHA DE NACIMIENTO</td>
        <td>{{ optional($employee->birth_date)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">LUGAR DE NACIMIENTO</td>
        <td>{{ $employee->birth_place }}</td>
    </tr>
    <tr>
        <td class="label">¿TIENE ALGUNA DISCAPACIDAD?</td>
        <td>{{ $employee->has_disability ? 'SÍ' : 'NO' }}</td>
    </tr>
    <tr>
        <td class="label">CONADIS RUI N°</td>
        <td>{{ $employee->conadis_rui ?: '-' }}</td>
    </tr>
</table>

<div class="section">II. DOMICILIO Y CONTACTO</div>
<table>
    <tr>
        <td class="label">DOMICILIO O DIRECCIÓN ACTUAL</td>
        <td>{{ $employee->address }}</td>
    </tr>
    <tr>
        <td class="label">REFERENCIA</td>
        <td>{{ $employee->reference }}</td>
    </tr>
    <tr>
        <td class="label">DISTRITO</td>
        <td>{{ $employee->district }}</td>
    </tr>
    <tr>
        <td class="label">PROVINCIA</td>
        <td>{{ $employee->province }}</td>
    </tr>
    <tr>
        <td class="label">DEPARTAMENTO</td>
        <td>{{ $employee->department }}</td>
    </tr>
    <tr>
        <td class="label">CELULAR</td>
        <td>{{ $employee->cellphone }}</td>
    </tr>
    <tr>
        <td class="label">CORREO</td>
        <td>{{ $employee->personal_email }}</td>
    </tr>
    <tr>
        <td class="label">CONTACTO EN CASO DE EMERGENCIA</td>
        <td>{{ $employee->emergency_contact_name }}</td>
    </tr>
    <tr>
        <td class="label">N° CEL DEL CONTACTO</td>
        <td>{{ $employee->emergency_contact_phone }}</td>
    </tr>
</table>

<div class="section">III. DATOS LABORALES</div>
<table>
    <tr>
        <td class="label">PROFESIÓN</td>
        <td>{{ $employee->profession }}</td>
    </tr>
    <tr>
        <td class="label">CARGO ACTUAL</td>
        <td>{{ $employee->current_position }}</td>
    </tr>
    <tr>
        <td class="label">DEPENDENCIA ACTUAL</td>
        <td>{{ $employee->dependency?->name }}</td>
    </tr>
    <tr>
        <td class="label">CONTRATO O RESOL. N°</td>
        <td>{{ $employee->contract_resolution_number }}</td>
    </tr>
    <tr>
        <td class="label">FECHA DE VÍNCULO</td>
        <td>{{ optional($employee->employment_start_date)->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td class="label">RÉGIMEN LABORAL</td>
        <td>{{ $employee->laborRegime?->name }}</td>
    </tr>
    <tr>
        <td class="label">CONDICIÓN LABORAL</td>
        <td>{{ $employee->labor_condition }}</td>
    </tr>
    <tr>
        <td class="label">RÉGIMEN PENSIONARIO</td>
        <td>{{ $employee->pensionRegime?->name }}</td>
    </tr>
    <tr>
        <td class="label">CÓD. AIRSHSP</td>
        <td>{{ $employee->airshsp_code ?: '-' }}</td>
    </tr>
    <tr>
        <td class="label">CORREO INSTITUCIONAL</td>
        <td>{{ $employee->institutional_email }}</td>
    </tr>
    <tr>
        <td class="label">VÍNCULO LABORAL</td>
        <td>{{ $employee->has_labor_link ? 'SÍ TIENE' : 'NO TIENE' }}</td>
    </tr>
    <tr>
        <td class="label">FECHA DE FIN DE VÍNCULO</td>
        <td>{{ $employee->labor_end_date ? optional($employee->labor_end_date)->format('d/m/Y') : '-' }}</td>
    </tr>
</table>

<div class="section">IV. DATOS FAMILIARES</div>
<p><strong>¿ES PADRE O MADRE DE FAMILIA?</strong> {{ $employee->is_parent ? 'SÍ' : 'NO' }}</p>

<table>
    <thead>
        <tr>
            <th>Nombres y Apellidos</th>
            <th>DNI</th>
            <th>Edad</th>
            <th>Sexo</th>
            <th>Parentesco</th>
        </tr>
    </thead>
    <tbody>
        @forelse($employee->familyMembers as $member)
            <tr>
                <td>{{ $member->full_name }}</td>
                <td>{{ $member->dni }}</td>
                <td>{{ $member->age }}</td>
                <td>{{ $member->sex?->name }}</td>
                <td>{{ $member->relationship?->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="center">No se registraron familiares.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p style="margin-top: 20px;">
    Declaro bajo juramento que los datos consignados son veraces. De lo contrario seré pasible de la sanción administrativa correspondiente.
</p>

<div class="signature">
    ______________________________<br>
    FIRMA DEL SERVIDOR<br>
    DNI N° {{ $employee->dni }}
</div>

</body>
</html>