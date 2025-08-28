<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResumenPagoController extends Controller
{
    public function index()
    {
        $empleados = [
            [
                'cedula' => '7928721',
                'nombre' => 'SANCHEZ DORIS',
                'nivel_cargo' => 'PROFESIONAL',
                'unidad' => 'INHRR_ADMINISTRACION',
                'dias_falta' => 0,
                'monto1' => 258.75,
                'monto2' => 258.75,
                'total_metas_lv' => 0,
                'total_metas_sdf' => 0,
                'dia_pendiente' => 1,
                'total_metas' => 0
            ],
            [
                'cedula' => '3759325',
                'nombre' => 'LINARES JOSE',
                'nivel_cargo' => 'OBRERO',
                'unidad' => 'INHRR_ADMINISTRACION',
                'dias_falta' => 0,
                'monto1' => 0.00,
                'monto2' => 401.26,
                'total_metas_lv' => 0,
                'total_metas_sdf' => 1,
                'dia_pendiente' => 0,
                'total_metas' => 1
            ],
            [
                'cedula' => '7948797',
                'nombre' => 'OLIVARES MARIA',
                'nivel_cargo' => 'OBRERO',
                'unidad' => 'INHRR_ADMINISTRACION',
                'dias_falta' => 0,
                'monto1' => 0.00,
                'monto2' => 401.26,
                'total_metas_lv' => 0,
                'total_metas_sdf' => 1,
                'dia_pendiente' => 0,
                'total_metas' => 1
            ]
        ];

        return view('resumen-pago', compact('empleados'));
    }
}
