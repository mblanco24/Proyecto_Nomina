<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Para simular fechas

class PermisoController extends Controller
{
    public function index()
    {
        // Simulación de datos de permisos para la vista.
        // En un entorno real, esto vendría de la base de datos (e.g., tabla 'permisos')
        $permisos = [
            [
                'id' => 1,
                'employee_name' => 'Ana Torres',
                'type' => 'Día Personal',
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-01',
                'days' => 1,
                'status' => 'Aprobado',
                'requested_at' => '2025-06-20 10:00:00',
                'approved_by' => 'Carla Mendoza',
                'notes' => 'Cita médica.'
            ],
            [
                'id' => 2,
                'employee_name' => 'Luis Méndez',
                'type' => 'Vacaciones',
                'start_date' => '2025-08-05',
                'end_date' => '2025-08-15',
                'days' => 10,
                'status' => 'Pendiente',
                'requested_at' => '2025-06-25 15:30:00',
                'approved_by' => null,
                'notes' => 'Vacaciones anuales.'
            ],
            [
                'id' => 3,
                'employee_name' => 'María López',
                'type' => 'Luto',
                'start_date' => '2025-06-10',
                'end_date' => '2025-06-12',
                'days' => 3,
                'status' => 'Aprobado',
                'requested_at' => '2025-06-09 09:00:00',
                'approved_by' => 'Roberto Sánchez',
                'notes' => 'Fallecimiento familiar.'
            ],
        ];

        // Formatear fechas para la vista
        foreach ($permisos as &$permiso) {
            $permiso['requested_at_formatted'] = Carbon::parse($permiso['requested_at'])->format('d/m/Y H:i');
        }

        return view('permisos.index', compact('permisos'));
    }

    public function show($id)
    {
        // Simular la búsqueda de un permiso específico
        $permisos_simulados = [
            1 => [
                'id' => 1,
                'employee_name' => 'Ana Torres',
                'type' => 'Día Personal',
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-01',
                'days' => 1,
                'status' => 'Aprobado',
                'requested_at' => '2025-06-20 10:00:00',
                'approved_by' => 'Carla Mendoza',
                'notes' => 'Cita médica.'
            ],
            2 => [
                'id' => 2,
                'employee_name' => 'Luis Méndez',
                'type' => 'Vacaciones',
                'start_date' => '2025-08-05',
                'end_date' => '2025-08-15',
                'days' => 10,
                'status' => 'Pendiente',
                'requested_at' => '2025-06-25 15:30:00',
                'approved_by' => null,
                'notes' => 'Vacaciones anuales.'
            ],
            3 => [
                'id' => 3,
                'employee_name' => 'María López',
                'type' => 'Luto',
                'start_date' => '2025-06-10',
                'end_date' => '2025-06-12',
                'days' => 3,
                'status' => 'Aprobado',
                'requested_at' => '2025-06-09 09:00:00',
                'approved_by' => 'Roberto Sánchez',
                'notes' => 'Fallecimiento familiar.'
            ],
        ];

        $permiso = $permisos_simulados[$id] ?? null;

        if (!$permiso) {
            abort(404);
        }

        $permiso['requested_at_formatted'] = Carbon::parse($permiso['requested_at'])->format('d/m/Y H:i');

        return view('permisos.show', compact('permiso'));
    }

    // Método para simular la aprobación/rechazo de un permiso
    public function updateStatus(Request $request, $id)
    {
        // Lógica de simulación: en un entorno real, actualizaría la BD
        $newStatus = $request->input('status');
        return back()->with('success', "Permiso ID $id actualizado a $newStatus (Simulado).");
    }

    // Método para simular la solicitud de un nuevo permiso
    public function store(Request $request)
    {
        // Lógica de simulación: en un entorno real, guardar en la BD
        $employeeName = $request->input('employee_name');
        $type = $request->input('type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        return back()->with('success', "Solicitud de permiso para $employeeName ($type del $startDate al $endDate) enviada (Simulado).");
    }
}
