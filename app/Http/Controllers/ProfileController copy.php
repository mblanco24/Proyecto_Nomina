<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
// use Auth; // Si ya tienes autenticación de Laravel, lo usarías aquí
// use App\Models\User; // Para obtener el usuario autenticado

class ProfileController extends Controller
{
    public function show()
    {
        // Simular datos del usuario autenticado
        // En un entorno real: $user = Auth::user();
        $user = [
            'id' => 1,
            'username' => 'carla.mendoza',
            'full_name' => 'Carla Mendoza',
            'photo_url' => 'https://i.pravatar.cc/150?img=1',
            'email' => 'carla.mendoza@empresa.com',
            'position' => 'Jefe de Nómina',
            'department' => 'Recursos Humanos',
            'role' => 'Admin Nómina',
            'hire_date' => '2010-01-01',
            'last_login' => Carbon::now()->subHours(5)->subMinutes(30)->toDateTimeString(),
            'is_active' => true,
            'remaining_vacation_days' => 20,
            'assigned_equipment' => [
                ['id' => 'PC-001', 'type' => 'Computadora de Escritorio', 'model' => 'Dell Optiplex 7000', 'serial' => 'SN-PC7000-001', 'assigned_date' => '2023-01-15'],
            ]
        ];

        // Calcular antigüedad (si aplica a tu modelo de usuario o si usas el Employee asociado)
        $hireDate = Carbon::parse($user['hire_date']);
        $now = Carbon::now();
        $diff = $hireDate->diff($now);
        $user['antiquity'] = "{$diff->y} años, {$diff->m} meses, {$diff->d} días";

        return view('profile.show', compact('user'));
    }
}
