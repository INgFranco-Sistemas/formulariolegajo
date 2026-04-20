<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dependency;

class DependencySeeder extends Seeder
{
    public function run(): void
    {
        $dependencies = [
            ['name' => 'ALDEA INFANTIL SAN JUAN BOSCO', 'code' => 'AISJB'],
            ['name' => 'CONSEJO REGIONAL', 'code' => 'CR'],
            ['name' => 'DIRECCIÓN DE ARCHIVO REGIONAL', 'code' => 'DAR'],
            ['name' => 'DIRECCIÓN DE COMERCIO EXTERIOR Y TURISMO', 'code' => 'DIRCETUR'],
            ['name' => 'DIRECCIÓN REGIONAL DE ENERGÍA Y MINAS', 'code' => 'DIREM'],
            ['name' => 'DIRECCIÓN REGIONAL DE LA PRODUCCIÓN', 'code' => 'DIREPRO'],
            ['name' => 'DIRECCIÓN REGIONAL DE TRABAJO Y PROMOCIÓN DEL EMPLEO', 'code' => 'DIRETRPRE'],
            ['name' => 'DIRECCIÓN REGIONAL DE VIVIENDA, CONSTRUCCIÓN Y SANEAMIENTO', 'code' => 'DIREVICONSA'],
            ['name' => 'GERENCIA GENERAL REGIONAL', 'code' => 'GGR'],
            ['name' => 'GERENCIA REGIONAL DE ADMINISTRACIÓN', 'code' => 'GRA'],
            ['name' => 'GERENCIA REGIONAL DE ASESORÍA JURÍDICA', 'code' => 'GRAJ'],
            ['name' => 'GERENCIA REGIONAL DE DESARROLLO ECONÓMICO', 'code' => 'GRDE'],
            ['name' => 'GERENCIA REGIONAL DE DESARROLLO SOCIAL', 'code' => 'GRDS'],
            ['name' => 'GERENCIA REGIONAL DE INFRAESTRUCTURA', 'code' => 'GRI'],
            ['name' => 'GERENCIA REGIONAL DE PLANEAMIENTO, PRESUPUESTO Y ACONDICIONAMIENTO TERRITORIAL', 'code' => 'GRPPAT'],
            ['name' => 'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTIÓN AMBIENTAL', 'code' => 'DIRERNGA'],
            ['name' => 'GOBERNACIÓN REGIONAL', 'code' => 'GR'],
            ['name' => 'OFICINA DE ATENCIÓN AL CIUDADANO Y GESTIÓN DOCUMENTAL', 'code' => 'OACGD'],
            ['name' => 'OFICINA DE COORDINACIÓN LIMA', 'code' => 'OCL'],
            ['name' => 'OFICINA REGIONAL DE COMUNICACIONES, IMAGEN Y PROTOCOLO', 'code' => 'ORCIP'],
            ['name' => 'OFICINA REGIONAL DE COOPERACIÓN INTERNACIONAL', 'code' => 'ORCI'],
            ['name' => 'OFICINA REGIONAL DE GESTIÓN DE RIESGO DE DESASTRES, DEFENSA NACIONAL Y SEGURIDAD CIUDADANA', 'code' => 'ORGDDNSC'],
            ['name' => 'OFICINA REGIONAL DE GESTIÓN EN CONFLICTOS Y DE DIALOGO', 'code' => 'ORGCD'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE AMBO', 'code' => 'ORDA'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE DOS DE MAYO', 'code' => 'ORDDM'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE HUACAYBAMBA', 'code' => 'ORDH'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE HUAMALIES', 'code' => 'ORDHU'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE LAURICOCHA', 'code' => 'ORDL'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE LEONCIO PRADO', 'code' => 'ORDLP'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE MARAÑON', 'code' => 'ORDM'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE PACHITEA', 'code' => 'ORDP'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE PUERTO INCA', 'code' => 'ORDPI'],
            ['name' => 'OFICINA SUB REGIONAL DE DESARROLLO DE YAROWILCA', 'code' => 'ORDY'],
            ['name' => 'ÓRGANO DE CONTROL INSTITUCIONAL', 'code' => 'OCI'],
            ['name' => 'PROCURADURÍA PÚBLICA REGIONAL', 'code' => 'PPR'],
            ['name' => 'SECRETARIA DEL CONSEJO REGIONAL', 'code' => 'SCR'],
            ['name' => 'SUB GERENCIA DE ABASTECIMIENTO', 'code' => 'SGA'],
            ['name' => 'SUB GERENCIA DE ACONDICIONAMIENTO TERRITORIAL', 'code' => 'SGAT'],
            ['name' => 'SUB GERENCIA DE CONTABILIDAD', 'code' => 'SBC'],
            ['name' => 'SUB GERENCIA DE DESARROLLO POBLACIONAL', 'code' => 'SGDP'],
            ['name' => 'SUB GERENCIA DE ESTUDIOS', 'code' => 'SGE'],
            ['name' => 'SUB GERENCIA DE FORMULACIÓN Y EVALUACIÓN DE ESTUDIOS DE PRE INVERSIÓN', 'code' => 'SGFEEPI'],
            ['name' => 'SUB GERENCIA DE GESTIÓN AMBIENTAL', 'code' => 'SGGA'],
            ['name' => 'SUB GERENCIA DE GESTIÓN DE OBRAS Y SUPERVISIÓN', 'code' => 'SGOS'],
            ['name' => 'SUB GERENCIA DE GESTION DE RECURSOS HUMANOS', 'code' => 'SGGRH'],
            ['name' => 'SUB GERENCIA DE INCLUSIÓN SOCIAL E IDENTIDAD CULTURAL', 'code' => 'SGISIC'],
            ['name' => 'SUB GERENCIA DE LIQUIDACIÓN', 'code' => 'SGL'],
            ['name' => 'SUB GERENCIA DE MODERNIZACIÓN Y TRANSFORMACIÓN DIGITAL', 'code' => 'SGMTD'],
            ['name' => 'SUB GERENCIA DE PATRIMONIO', 'code' => 'SGP'],
            ['name' => 'SUB GERENCIA DE PLANEAMIENTO ESTRATÉGICO', 'code' => 'SGPE'],
            ['name' => 'SUB GERENCIA DE PRESUPUESTO PÚBLICO', 'code' => 'SGPP'],
            ['name' => 'SUB GERENCIA DE PROGRAMACIÓN MULTIANUAL DE INVERSIONES - OPMI', 'code' => 'OPMI'],
            ['name' => 'SUB GERENCIA DE PROMOCIÓN DE LA INVERSIÓN PRIVADA SOSTENIBLE', 'code' => 'SGPPIPS'],
            ['name' => 'SUB GERENCIA DE RECURSOS NATURALES', 'code' => 'SGRN'],
            ['name' => 'SUB GERENCIA DE TESORERIA', 'code' => 'SGT'],
            ['name' => 'VICE GOBERNACIÓN', 'code' => 'VG'],
        ];

        foreach ($dependencies as $dependency) {
            Dependency::updateOrCreate(
                ['name' => $dependency['name']],
                [
                    'code' => $dependency['code'],
                    'is_active' => true,
                ]
            );
        }
    }
}