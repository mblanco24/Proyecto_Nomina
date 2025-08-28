<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Para simular fechas

class MetaController extends Controller
{
    public function index()
    {
        // Simulación de datos de pagos por metas
        $metas = [
            [
                'id' => 1,
                'employee_name' => 'NORIEGA LUIGI',
                'goal_description' => 'Logro de ventas Q2 2025 (+15%)',
                'bonus_amount' => 500.00,
                'achievement_date' => '2025-04-14',
                'status' => 'Pendiente',
                'notes' => 'Alcanzó el objetivo de ventas establecido.'
            ],

            [
                'id' => 1,
                'employee_name' => 'ARAGUREN WILLY',
                'goal_description' => 'Limpieza de tu corazón',
                'bonus_amount' => 500.00,
                'achievement_date' => '2025-04-15',
                'status' => 'Pendiente',
                'notes' => 'Alcanzó el objetivo de ventas establecido.'
            ],
        ];

        return view('metas.index', compact('metas'));
    }

    // Métodos para simular creación/edición si fueran necesarios
}
