<?php

namespace App\Http\Controllers;

// app/Http/Controllers/ReportesGeneralesController.php

use Illuminate\Http\Request;

class ReportesGeneralesController extends Controller
{
    public function index()
    {
        // Simulación de opciones de reportes generales
        $report_options = [
            // Asegúrate de que el 'route' tenga el slug que tu showReport espera
            ['name' => 'Reporte de Antigüedad de Empleados', 'description' => 'Lista de empleados y su tiempo en la empresa.', 'type_slug' => 'antiguedad'],
            ['name' => 'Reporte de Vacaciones Consumidas', 'description' => 'Detalle de días de vacaciones tomados por empleado.', 'type_slug' => 'vacaciones'],
            ['name' => 'Reporte de Estructura Organizacional', 'description' => 'Organigrama y distribución por departamentos.', 'type_slug' => 'organizacion'],
            ['name' => 'Reporte de Movimientos de Personal', 'description' => 'Contrataciones, egresos, cambios de cargo.', 'type_slug' => 'movimientos'],
        ];

        return view('reportesgenerales.index', compact('report_options'));
    }

    public function showReport($type) // $type es el slug que viene de la URL
    {
        // ... (el resto de tu lógica de showReport) ...
        // Aquí el switch ($type) usará 'antiguedad', 'vacaciones', etc.
    }
}
