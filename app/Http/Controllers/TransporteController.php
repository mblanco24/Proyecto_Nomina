<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TransporteController extends Controller
{
    public function index(Request $request)
    {
        // Simulación de datos de transporte
        $registros = [
            [
                'id' => 1,
                'employee_name' => 'ARANGUREN WILLY',
                'date' => '2025-04-15',
                'entry_time' => '06:49',
                'exit_time' => '17:05',
                'vehicle' => 'Bus de ruta 1'
            ],
        ];

        // Simular filtrado por fecha si se envía
        $filterDate = $request->input('date');
        if ($filterDate) {
            $registros = array_filter($registros, function($registro) use ($filterDate) {
                return $registro['date'] === $filterDate;
            });
        }

        return view('transporte.index', compact('registros', 'filterDate'));
    }
}
