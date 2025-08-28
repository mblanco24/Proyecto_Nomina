<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener tu modelo User
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        // Simular datos de usuarios. En un entorno real, usarías User::all() o con paginación
        $users = [
            [
                'id' => 1,
                'username' => 'carla.mendoza',
                'full_name' => 'Carla Mendoza',
                'photo_url' => 'https://i.pravatar.cc/150?img=1',
                'email' => 'carla.mendoza@empresa.com',
                'position' => 'Jefe de Nómina',
                'department' => 'Recursos Humanos',
                'role' => 'Admin Nómina',
                'last_login' => Carbon::now()->subHours(5)->subMinutes(30)->toDateTimeString(),
                'is_active' => true,
                'assigned_equipment' => [
                    ['id' => 'PC-001', 'type' => 'Computadora de Escritorio', 'model' => 'Dell Optiplex 7000'],
                ]
            ],
            [
                'id' => 2,
                'username' => 'roberto.sanchez',
                'full_name' => 'Roberto Sánchez',
                'photo_url' => 'https://i.pravatar.cc/150?img=2',
                'email' => 'roberto.sanchez@empresa.com',
                'position' => 'Especialista de Soporte Técnico',
                'department' => 'Tecnología',
                'role' => 'Administrador',
                'last_login' => Carbon::now()->subMinutes(15)->toDateTimeString(),
                'is_active' => true,
                'assigned_equipment' => [
                    ['id' => 'LT-005', 'type' => 'Laptop', 'model' => 'HP EliteBook 840 G8'],
                    ['id' => 'P-010', 'type' => 'Teléfono IP', 'model' => 'Cisco CP-8841'],
                ]
            ],
            [
                'id' => 3,
                'username' => 'daniela.rojas',
                'full_name' => 'Daniela Rojas',
                'photo_url' => 'https://i.pravatar.cc/150?img=3',
                'email' => 'daniela.rojas@empresa.com',
                'position' => 'Asistente de Contabilidad',
                'department' => 'Finanzas',
                'role' => 'Empleado',
                'last_login' => Carbon::now()->subDays(2)->subHours(8)->toDateTimeString(),
                'is_active' => true,
                'assigned_equipment' => [
                    ['id' => 'PC-015', 'type' => 'Computadora de Escritorio', 'model' => 'Lenovo ThinkCentre'],
                ]
            ],
            [
                'id' => 4,
                'username' => 'sofia.gallardo',
                'full_name' => 'Sofía Gallardo',
                'photo_url' => 'https://i.pravatar.cc/150?img=4',
                'email' => 'sofia.gallardo@empresa.com',
                'position' => 'Gerente de RRHH',
                'department' => 'Recursos Humanos',
                'role' => 'Gerente RRHH',
                'last_login' => Carbon::now()->subHours(1)->subMinutes(5)->toDateTimeString(),
                'is_active' => false,
                'assigned_equipment' => []
            ],
        ];

        // Formatear la fecha de última conexión
        foreach ($users as &$user) {
            $user['last_login_formatted'] = Carbon::parse($user['last_login'])->locale('es')->diffForHumans();
        }

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        // Simular la búsqueda de un usuario específico
        $all_users_simulated = [
            1 => [
                'id' => 1, 'username' => 'carla.mendoza', 'full_name' => 'Carla Mendoza',
                'photo_url' => 'https://i.pravatar.cc/150?img=1', 'email' => 'carla.mendoza@empresa.com',
                'position' => 'Jefe de Nómina', 'department' => 'Recursos Humanos', 'role' => 'Admin Nómina',
                'last_login' => Carbon::now()->subHours(5)->subMinutes(30)->toDateTimeString(), 'is_active' => true,
                'assigned_equipment' => [
                    ['id' => 'PC-001', 'type' => 'Computadora de Escritorio', 'model' => 'Dell Optiplex 7000', 'serial' => 'SN-PC7000-001', 'assigned_date' => '2023-01-15'],
                ]
            ],
            2 => [
                'id' => 2, 'username' => 'roberto.sanchez', 'full_name' => 'Roberto Sánchez',
                'photo_url' => 'https://i.pravatar.cc/150?img=2', 'email' => 'roberto.sanchez@empresa.com',
                'position' => 'Especialista de Soporte Técnico', 'department' => 'Tecnología', 'role' => 'Administrador',
                'last_login' => Carbon::now()->subMinutes(15)->toDateTimeString(), 'is_active' => true,
                'assigned_equipment' => [
                    ['id' => 'LT-005', 'type' => 'Laptop', 'model' => 'HP EliteBook 840 G8', 'serial' => 'SN-HP840-005', 'assigned_date' => '2024-03-20'],
                    ['id' => 'P-010', 'type' => 'Teléfono IP', 'model' => 'Cisco CP-8841', 'serial' => 'SN-CISCO-010', 'assigned_date' => '2024-03-20'],
                ]
            ],
            3 => [
                'id' => 3, 'username' => 'daniela.rojas', 'full_name' => 'Daniela Rojas',
                'photo_url' => 'https://i.pravatar.cc/150?img=3', 'email' => 'daniela.rojas@empresa.com',
                'position' => 'Asistente de Contabilidad', 'department' => 'Finanzas', 'role' => 'Empleado',
                'last_login' => Carbon::now()->subDays(2)->subHours(8)->toDateTimeString(), 'is_active' => true,
                'assigned_equipment' => [
                    ['id' => 'PC-015', 'type' => 'Computadora de Escritorio', 'model' => 'Lenovo ThinkCentre', 'serial' => 'SN-LT-015', 'assigned_date' => '2022-10-01'],
                ]
            ],
            4 => [
                'id' => 4, 'username' => 'sofia.gallardo', 'full_name' => 'Sofía Gallardo',
                'photo_url' => 'https://i.pravatar.cc/150?img=4', 'email' => 'sofia.gallardo@empresa.com',
                'position' => 'Gerente de RRHH', 'department' => 'Recursos Humanos', 'role' => 'Gerente RRHH',
                'last_login' => Carbon::now()->subHours(1)->subMinutes(5)->toDateTimeString(), 'is_active' => false,
                'assigned_equipment' => []
            ],
        ];

        $user = $all_users_simulated[$id] ?? null;

        if (!$user) {
            abort(404);
        }

        $user['last_login_formatted'] = Carbon::parse($user['last_login'])->locale('es')->diffForHumans();

        return view('users.show', compact('user'));
    }
}
