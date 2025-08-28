<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistroTransporteController extends Controller
{
    public function index()
    {
        // Datos de ejemplo - en producción vendrían de la base de datos
        $registros = [
            [
                'id' => 1,
                'cedula' => '28322083',
                'nombre_apellido' => 'NORIEGA LUIGI',
                'fecha' => '2025-07-15',
                'hora_entrada' => '07:30',
                'hora_salida' => '17:45',
                'ruta' => 'Ruta 2 - Zona Este'
            ],
            [
                'id' => 2,
                'cedula' => '20183577',
                'nombre_apellido' => 'ARANGUREN WILLY',
                'fecha' => '2025-07-15',
                'hora_entrada' => '08:15',
                'hora_salida' => '16:30',
                'ruta' => 'Ruta 1 - Zona Oeste'
            ]
        ];

        $rutasDisponibles = [
            'Ruta 1 - Zona Oeste',
            'Ruta 2 - Zona Este',
            'Ruta 3 - Centro',
            'Ruta 4 - Norte'
        ];

return view('registrotransporte');    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|string|max:20',
            'nombre_apellido' => 'required|string|max:100',
            'fecha' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
            'ruta' => 'required|string'
        ]);

        // Aquí iría la lógica para guardar en la base de datos
        // ...

        return redirect()->route('registrotransporte.index')->with('success', 'Registro de transporte guardado exitosamente');
    }
}
