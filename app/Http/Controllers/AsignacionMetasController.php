<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsignacionMetasController extends Controller
{
    public function index()
    {
        // Datos de ejemplo - reemplaza esto con tu lógica real
        $empleados = [
            [
                'id' => 1,
                'cedula' => '28322083',
                'nombre' => 'NORIEGA LUIGI',
                'cargo' => 'Analista de Nómina',
                'unidad' => 'INHRR_ADMINISTRACION',
                'metas_asignadas' => [
                    [
                        'id' => 101,
                        'meta' => 'Certificación en Normativa Laboral',
                        'fecha_asignacion' => '01/07/2025',
                        'fecha_limite' => '30/09/2025',
                        'estado' => 'En progreso',
                        'avance' => 35
                    ]
                ]
            ],
            [
                'id' => 2,
                'cedula' => '20183577',
                'nombre' => 'ARANGUREN WILLY',
                'cargo' => 'Especialista en Tecnología',
                'unidad' => 'INHRR_TECNOLOGIA',
                'metas_asignadas' => [
                    [
                        'id' => 103,
                        'meta' => 'Migración a nueva plataforma',
                        'fecha_asignacion' => '01/05/2025',
                        'fecha_limite' => '30/11/2025',
                        'estado' => 'En progreso',
                        'avance' => 60
                    ]
                ]
            ]
        ];

        $metasDisponibles = [
            ['id' => 1, 'nombre' => 'Certificación en Normativa Laboral'],
            ['id' => 2, 'nombre' => 'Optimización proceso de pagos'],
            ['id' => 3, 'nombre' => 'Migración a nueva plataforma']
        ];

        return view('asignacion-metas', [
            'empleados' => $empleados,
            'metasDisponibles' => $metasDisponibles
        ]);
    }
}
