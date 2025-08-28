<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Para simular fechas

class HonorarioController extends Controller
{
    public function index()
    {
        // Simulación de datos de pagos por honorarios
        $honorarios = [
            [
                'id' => 28322083,
                'employee_name' => 'NORIEGA LUIGI',
                'description' => 'DOCENCIA E INVESTIGACION',
                'payment_date' => '2025-04-14 07:33',
                'payment_date2' => '2025-04-14 11:32',
            ],

                        [
                'id' => 28322083,
                'employee_name' => 'ARANGUREN WILLY',
                'description' => 'DOCENCIA',
                'payment_date' => '2025-04-15 06:52',
                'payment_date2' => '2025-04-15 17:00',
            ],
        ];

        return view('honorarios.index', compact('honorarios'));
    }

    // Métodos para simular creación/edición si fueran necesarios
}
