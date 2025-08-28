<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RelacionBiometricoMetasController extends Controller
{
    public function index()  // ← Este método debe existir
    {
        // Obtener la semana actual
        $inicioSemana = now()->startOfWeek();

        // Datos de ejemplo (deberás reemplazar con tu lógica real)
        $empleados = [
            [
                'id' => 1,
                'cedula' => '28322083',
                'nombre' => 'NORIEGA LUIGI',
                'metas' => [
                    'Meta ventas Q3' => '85% completada',
                    'Certificación' => 'Pendiente'
                ],
                'asistencias' => [
                    'lunes' => ['entrada' => '07:33 AM', 'salida' => '11:32 AM'],
                    'martes' => ['entrada' => 'No registrado', 'salida' => 'No registrado'],
                ]
            ]
        ];

        return view('relacion-biometrico-metas', [
            'empleados' => $empleados,
            'fechaInicio' => $inicioSemana->format('d/m/Y'),
            'fechaFin' => $inicioSemana->copy()->endOfWeek()->format('d/m/Y')
        ]);
    }
}
