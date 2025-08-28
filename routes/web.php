<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\HomeController;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
require __DIR__.'/auth.php';

// Ruta de login personalizada (si necesitas mantenerla)
Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],  // Asegúrate que coincide con tu formulario
        'password' => ['required'],
    ]);

     $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'Estas credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

     if (!$user->super_user) {
        return back()->withErrors([
            'email' => 'No tiene permisos para acceder (no es super usuario).',
        ])->onlyInput('email');
    }

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }


    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas no son correctas.',
    ])->onlyInput('email');
})->name('login.post');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestión de empleados
    Route::prefix('empleados')->group(function () {
        Route::get('/', function () {
            $employees = [
                ['id' => 1, 'name' => 'Ana Torres', 'position' => 'Gerente de RRHH', 'department' => 'Recursos Humanos', 'hire_date' => '2015-03-10', 'remaining_vacation_days' => 15],
                ['id' => 2, 'name' => 'Luis Méndez', 'position' => 'Analista de Nómina', 'department' => 'Nómina', 'hire_date' => '2018-07-01', 'remaining_vacation_days' => 10],
                ['id' => 3, 'name' => 'María López', 'position' => 'Asistente Administrativo', 'department' => 'Administración', 'hire_date' => '2020-01-20', 'remaining_vacation_days' => 8],
            ];
            return view('employees.index', compact('employees'));
        })->name('employees.index');

        Route::get('/experiencias', function () {
            return view('employees.experiences', [
                'experiences' => [
                    ['company' => 'Empresa A', 'position' => 'Desarrollador', 'start_date' => '2019-01-01', 'end_date' => '2020-12-31'],
                    ['company' => 'Empresa B', 'position' => 'Analista de Datos', 'start_date' => '2021-01-01', 'end_date' => null],
                ]
            ]);
        })->name('employees.experiences');
    });

    // Módulos del sistema
    Route::view('/vacaciones', 'vacaciones.index')->name('vacaciones.index');
    Route::view('/constancias', 'constancias.index')->name('constancias.index');
    Route::view('/permisos', 'permisos.index')->name('permisos.index');
    Route::view('/honorarios', 'honorarios.index')->name('honorarios.index');
    //Route::view('/asignacion_metas', 'pagos.metas')->name('pagos.metas');
    Route::view('/biometricos', 'pagos.biometrico')->name('pagos.biometrico');
    Route::view('/pagos', 'pagos.index')->name('pagos.index');
    //Route::view('/metas', 'meta.index')->name('metas.index');
    //Route::view('/transporte', 'transporte.index')->name('transporte.index');

    // Reportes
    Route::prefix('reportes')->group(function () {
        Route::view('/tecnologia', 'reportestecnologia.index')->name('reportestecnologia.index');
        Route::view('/generales', 'reportesgenerales.index')->name('reportesgenerales.index');
        Route::get('/generales/{type}', function ($type) {return view('reportesgenerales.report_detail', compact('type'));
        })->name('reportesgenerales.report_detail');
    });

    // Usuarios
    //Route::view('/users', 'users.index')->name('users.index');

    // Perfil de usuario
    Route::prefix('profile')->group(function () {
        Route::get('/', function () {
            return view('profile.show', [
                'user' => Auth::user(),
                'last_login' => Auth::user()->last_login_at ? Carbon::parse(Auth::user()->last_login_at)->format('d/m/Y H:i') : 'Nunca'
            ]);
        })->name('profile.show');

        Route::get('/edit', function () {
            return view('profile.edit', ['user' => Auth::user()]);
        })->name('profile.edit');

        Route::get('/destroy', function () {
            return view('profile.destroy', ['user' => Auth::user()]);
        })->name('profile.destroy');




        Route::patch('/', function (Illuminate\Http\Request $request) {
            // Lógica para actualizar el perfil del usuario
            return redirect()->route('profile.edit')->with('status', 'Perfil actualizado correctamente.');
        })->name('profile.update');
    });



    // Home alternativo
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});



Route::get('/relacionbiometrico', function () {
    // Aquí deberías obtener los datos de tu base de datos
    $datos = [
        // Ejemplo de estructura de datos
        [
            'cedula' => '2.8E-07',
            'nombre' => 'NEMBEGALLL03',
            'dias' => [
                'lunes' => ['entrada' => '', 'salida' => '1:32 a.m.'],
                'martes' => ['entrada' => 'No registrado', 'salida' => 'No registrado'],
                // ... otros días
            ],
            'ruta' => ''
        ]
    ];

    return view('relacionbiometrico', compact('datos'));
})->name('relacionbiometrico');



use App\Http\Controllers\RelacionBiometricoController;
use App\Http\Controllers\RelacionBiometricoMetasController;
use App\Http\Controllers\ResumenPagoController;
use App\Http\Controllers\AsignacionMetasController;
use App\Http\Controllers\RegistroTransporteController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\UserController;


Route::get('/relacionbiometrico', [RelacionBiometricoController::class, 'index'])->name('relacionbiometrico');

Route::get('/relacion-biometrico-metas', [RelacionBiometricoMetasController::class, 'index'])->name('relacion.biometrico.metas');

Route::get('/resumen-pago', [ResumenPagoController::class, 'index'])->name('resumen.pago');
// Gestión de Pagos por Metas
    Route::get('/metas', [MetaController::class, 'index'])->name('metas.index');

// Opción 1: Ruta individual (nombre: asignacion.metas)
Route::get('/asignacion-metas', [AsignacionMetasController::class, 'index'])->name('asignacion.metas');

// Opción 2: Ruta Resource (nombres: asignacion-metas.index, asignacion-metas.create, etc.)
Route::resource('asignacion-metas', AsignacionMetasController::class);


Route::get('/registrotransporte', [RegistroTransporteController::class, 'index'])->name('registrotransporte.index');
Route::post('/registrotransporte', [RegistroTransporteController::class, 'store'])->name('registrotransporte.store');


use App\Http\Controllers\TransporteController;
Route::get('/transporte/create', [TransporteController::class, 'create'])->name('transporte.create');
Route::get('/transporte', [TransporteController::class, 'index'])->name('transporte.index');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

