<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RelacionBiometricoController extends Controller
{
    public function index()
    {
        // Configuración de la semana específica (07/07/2025)
        $fechaInicio = Carbon::createFromFormat('d/m/Y', '14/04/2025')->startOfWeek();

        $datos = [
            [
                'cedula' => '28322083',
                'nombre' => 'NORIEGA LUIGI',
                'dias' => [
                    'lunes' => [
                        'fecha' => $fechaInicio->copy()->format('d/m/Y'),
                        'entrada' => '07:33 AM',
                        'salida' => '11:32 AM'
                    ],
                    'martes' => [
                        'fecha' => $fechaInicio->copy()->addDay()->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'miercoles' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'jueves' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'viernes' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'sabado' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'domingo' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    // ... otros días igual que antes
                ],
                'ruta' => 'No registrado'
            ],
            [
                'cedula' => '20183577',
                'nombre' => 'ARANGUREN WILLY',
                'dias' => [
                    'lunes' => [
                        'fecha' => $fechaInicio->copy()->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'martes' => [
                        'fecha' => $fechaInicio->copy()->addDay()->format('d/m/Y'),
                        'entrada' => '06:48 AM',
                        'salida' => '05:00 PM'
                    ],
                    'miercoles' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                        'jueves' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'viernes' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'sabado' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],
                    'domingo' => [
                        'fecha' => $fechaInicio->copy()->addDays(2)->format('d/m/Y'),
                        'entrada' => 'No registrado',
                        'salida' => 'No registrado'
                    ],

                ],
                'ruta' => 'Bus Ruta 1'
            ]
        ];

        return view('relacionbiometrico', [
            'datos' => $datos,
            'fechaInicio' => $fechaInicio
        ]);
    }
}
