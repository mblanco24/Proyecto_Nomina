<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteTecnologiaController extends Controller
{
    public function index()
    {
        // Simulación de datos para un reporte de tecnología
        $equipment_summary = [

        ];

        $recent_incidents = [

        ];

        return view('reportestecnologia.index', compact('equipment_summary', 'recent_incidents'));
    }
}
