<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MetaController extends Controller
{
    public function index()
    {
        // Datos de ejemplo para empleados con metas
        $empleados = [
            [
                'id' => 1,
                'nombre' => 'NORIEGA LUIGI',
                'cedula' => '28322083',
                'unidad' => 'INHIRR ADMINISTRACION',
                'cargo' => 'Analista de Nómina',
                'metas_asignadas' => [
                    [
                        'id' => 1,
                        'meta' => 'Certificación en Normativa Laboral',
                        'fecha_asignacion' => '01/07/2025',
                        'fecha_limite' => '30/09/2025',
                        'estado' => 'En progreso',
                        'avance' => 35
                    ]
                ]
            ],
            // Puedes agregar más empleados aquí
        ];

        $metasDisponibles = [
            ['id' => 1, 'nombre' => 'Certificación en Normativa Laboral'],
            ['id' => 2, 'nombre' => 'Capacitación en Seguridad Informática'],
            ['id' => 3, 'nombre' => 'Curso de Gestión de Proyectos']
        ];

        return view('metas.index', compact('empleados', 'metasDisponibles'));
    }

    // Otros métodos del controlador...
}
