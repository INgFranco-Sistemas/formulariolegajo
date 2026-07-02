<?php

namespace Database\Seeders;

use App\Models\LegajoSection;
use Illuminate\Database\Seeder;

class LegajoSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'number' => 1,
                'name' => 'Información personal y familiar',
                'description' => 'Documentos sobre datos personales y familiares del servidor civil.',
            ],
            [
                'number' => 2,
                'name' => 'Proceso de selección, vínculo e inducción',
                'description' => 'Documentos del proceso de selección, formalización del vínculo, inducción y periodo de prueba.',
            ],
            [
                'number' => 3,
                'name' => 'Formación académica y capacitación',
                'description' => 'Certificados, constancias, grados, títulos, colegiatura, habilitación profesional y capacitaciones.',
            ],
            [
                'number' => 4,
                'name' => 'Experiencia laboral',
                'description' => 'Documentación que acredita experiencia laboral presentada durante el proceso de selección.',
            ],
            [
                'number' => 5,
                'name' => 'Asistencia y permanencia',
                'description' => 'Permisos, suspensiones, vacaciones, descansos médicos, licencias y otros similares.',
            ],
            [
                'number' => 6,
                'name' => 'Compensaciones',
                'description' => 'Documentación sobre compensaciones económicas, no económicas, aportes y beneficios.',
            ],
            [
                'number' => 7,
                'name' => 'Rendimiento, carrera y desplazamientos',
                'description' => 'Gestión del rendimiento, progresión, rotación, destaque, encargos y desplazamientos.',
            ],
            [
                'number' => 8,
                'name' => 'Méritos, deméritos y sanciones',
                'description' => 'Reconocimientos, felicitaciones, sanciones y documentos relacionados.',
            ],
            [
                'number' => 9,
                'name' => 'Controversias y afiliación sindical',
                'description' => 'Documentación sobre controversias individuales, colectivas y afiliación sindical.',
            ],
            [
                'number' => 10,
                'name' => 'Seguridad, salud, seguros y subsidios',
                'description' => 'Accidentes de trabajo, salud ocupacional, seguros, subsidios, EPS y descansos médicos.',
            ],
            [
                'number' => 11,
                'name' => 'Finalización del vínculo laboral',
                'description' => 'Documentos relacionados al término del vínculo laboral del servidor.',
            ],
            [
                'number' => 12,
                'name' => 'Diversos',
                'description' => 'Documentos que no encajan en las secciones anteriores y forman parte del legajo.',
            ],
        ];

        foreach ($sections as $section) {
            LegajoSection::updateOrCreate(
                ['number' => $section['number']],
                [
                    'name' => $section['name'],
                    'description' => $section['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}