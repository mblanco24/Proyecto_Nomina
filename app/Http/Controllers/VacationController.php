<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; // Para obtener empleados
use App\Models\VacationRecord; // Para obtener registros de vacaciones
use Carbon\Carbon; // Para manejar fechas

class VacationController extends Controller
{
    public function index()
    {
        // Simular datos de empleados con campos adicionales para la vista de vacaciones
        $employees = [
            // Estos datos deberían venir de la BD real con las relaciones
            [
                'id' => 1,
                'full_name' => 'Ana Torres',
                'antiquity' => ['years' => 10, 'months' => 2, 'days' => 5],
                'hire_date' => '2015-03-10', // Necesario para calcular próxima asignación
                'remaining_vacation_days' => 20,
                'last_vacation_taken' => [ // Simulación para la vista de detalle
                    'start_date' => '2024-07-01',
                    'end_date' => '2024-07-15',
                    'days_taken' => 15,
                    'approved_by_user_name' => 'Carla Mendoza',
                    'created_at' => '2024-06-01 10:00:00'
                ],
                'vacation_records' => [ // Historial para la vista de detalle
                    [
                        'start_date' => '2024-07-01', 'end_date' => '2024-07-15', 'days_taken' => 15,
                        'approved_by_user_name' => 'Carla Mendoza', 'created_at' => '2024-06-01 10:00:00', 'notes' => 'Vacaciones anuales.',
                    ],
                    [
                        'start_date' => '2023-06-01', 'end_date' => '2023-06-10', 'days_taken' => 10,
                        'approved_by_user_name' => 'Carla Mendoza', 'created_at' => '2023-05-01 10:00:00', 'notes' => 'Vacaciones pendientes.',
                    ],
                ]
            ],
            [
                'id' => 2,
                'full_name' => 'Luis Méndez',
                'antiquity' => ['years' => 6, 'months' => 11, 'days' => 10],
                'hire_date' => '2018-07-01',
                'remaining_vacation_days' => 5,
                'last_vacation_taken' => null, // No ha tomado vacaciones
                'vacation_records' => []
            ],
            [
                'id' => 3,
                'full_name' => 'María López',
                'antiquity' => ['years' => 5, 'months' => 4, 'days' => 22],
                'hire_date' => '2020-01-20',
                'remaining_vacation_days' => 0, // Días en cero
                'last_vacation_taken' => [
                    'start_date' => '2025-01-10',
                    'end_date' => '2025-01-20',
                    'days_taken' => 10,
                    'approved_by_user_name' => 'Carla Mendoza',
                    'created_at' => '2024-12-01 09:00:00'
                ],
                'vacation_records' => [
                    [
                        'start_date' => '2025-01-10', 'end_date' => '2025-01-20', 'days_taken' => 10,
                        'approved_by_user_name' => 'Carla Mendoza', 'created_at' => '2024-12-01 09:00:00', 'notes' => 'Vacaciones anuales.',
                    ],
                ]
            ],
        ];

        // Calcular 'next_vacation_assignment_date' basado en hire_date para la simulación
        foreach ($employees as &$employee) {
            if ($employee['hire_date']) {
                $hireDate = Carbon::parse($employee['hire_date']);
                $antiquityYears = $employee['antiquity']['years'];

                // Asignación en el aniversario de contratación
                $nextAssignment = $hireDate->copy()->addYears(floor($antiquityYears) + 1);

                // Si la fecha de asignación ya pasó en el año actual, calcula la del próximo año
                if ($nextAssignment->isPast()) {
                    $nextAssignment = $hireDate->copy()->addYears(floor($antiquityYears) + 2);
                }
                $employee['next_vacation_assignment_date'] = $nextAssignment->format('Y-m-d');
            } else {
                $employee['next_vacation_assignment_date'] = null;
            }
        }


        return view('vacations.index', compact('employees'));
    }

    public function show($id)
    {
        // Simular datos de empleados con campos adicionales para la vista de vacaciones
        $all_employees_simulated = [
            1 => [
                'id' => 1,
                'full_name' => 'Ana Torres',
                'antiquity' => ['years' => 10, 'months' => 2, 'days' => 5],
                'hire_date' => '2015-03-10', // Necesario para calcular próxima asignación
                'remaining_vacation_days' => 20,
                'last_vacation_taken' => [ // Simulación para la vista de detalle
                    'start_date' => '2024-07-01',
                    'end_date' => '2024-07-15',
                    'days_taken' => 15,
                    'approved_by_user_name' => 'Carla Mendoza',
                    'created_at' => '2024-06-01 10:00:00'
                ],
                'vacation_records' => [ // Historial para la vista de detalle
                    [
                        'start_date' => '2024-07-01', 'end_date' => '2024-07-15', 'days_taken' => 15,
                        'approved_by_user_name' => 'Carla Mendoza', 'created_at' => '2024-06-01 10:00:00', 'notes' => 'Vacaciones anuales.',
                    ],
                    [
                        'start_date' => '2023-06-01', 'end_date' => '2023-06-10', 'days_taken' => 10,
                        'approved_by_user_name' => 'Carla Mendoza', 'created_at' => '2023-05-01 10:00:00', 'notes' => 'Vacaciones pendientes.',
                    ],
                ]
            ],
            2 => [
                'id' => 2,
                'full_name' => 'Luis Méndez',
                'antiquity' => ['years' => 6, 'months' => 11, 'days' => 10],
                'hire_date' => '2018-07-01',
                'remaining_vacation_days' => 5,
                'last_vacation_taken' => null, // No ha tomado vacaciones
                'vacation_records' => []
            ],
            3 => [
                'id' => 3,
                'full_name' => 'María López',
                'antiquity' => ['years' => 5, 'months' => 4, 'days' => 22],
                'hire_date' => '2020-01-20',
                'remaining_vacation_days' => 0, // Días en cero
                'last_vacation_taken' => [
                    'start_date' => '2025-01-10',
                    'end_date' => '2025-01-20',
                    'days_taken' => 10,
                    'approved_by_user_name' => 'Carla Mendoza',
                    'created_at' => '2024-12-01 09:00:00'
                ],
                'vacation_records' => [
                    [
                        'start_date' => '2025-01-10', 'end_date' => '2025-01-20', 'days_taken' => 10,
                        'approved_by_user_name' => 'Carla Mendoza', 'created_at' => '2024-12-01 09:00:00', 'notes' => 'Vacaciones anuales.',
                    ],
                ]
            ],
        ];

        $employee = $all_employees_simulated[$id] ?? null;

        if (!$employee) {
            abort(404);
        }

        // Calcular la próxima fecha de asignación para la vista de detalle
        $nextVacationAssignmentDate = null;
        if ($employee['hire_date']) {
            $hireDate = Carbon::parse($employee['hire_date']);
            $antiquityYears = $employee['antiquity']['years'];

            $nextAssignment = $hireDate->copy()->addYears(floor($antiquityYears) + 1);
            if ($nextAssignment->isPast()) {
                $nextAssignment = $hireDate->copy()->addYears(floor($antiquityYears) + 2);
            }
            $nextVacationAssignmentDate = $nextAssignment;
        }

        $lastVacation = $employee['last_vacation_taken'];
        $vacationRecords = $employee['vacation_records'];

        return view('vacations.show', compact('employee', 'lastVacation', 'nextVacationAssignmentDate', 'vacationRecords'));
    }
}
