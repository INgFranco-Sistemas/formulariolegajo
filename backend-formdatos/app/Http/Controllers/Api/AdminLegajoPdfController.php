<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Legajo;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminLegajoPdfController extends Controller
{
    public function fichaDatosGenerales(int $id)
    {
        $legajo = Legajo::with([
            'employeeForm.sex',
            'employeeForm.maritalStatus',
            'employeeForm.dependency',
            'employeeForm.laborRegime',
            'employeeForm.pensionRegime',
            'employeeForm.familyMembers.sex',
            'employeeForm.familyMembers.relationship',
            'dependency',
            'laborRegime',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.ficha-datos-generales', [
            'legajo' => $legajo,
            'employee' => $legajo->employeeForm,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('ficha_datos_generales_' . $legajo->employeeForm->dni . '.pdf');
    }
}