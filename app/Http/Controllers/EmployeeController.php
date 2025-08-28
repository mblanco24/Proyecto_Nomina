<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Para simular fechas

class EmployeeController extends Controller
{
    public function index()
    {
        // Simulación de datos de empleados
        $employees = [
            [
                'id' => 1,
                'name' => 'Ana Torres',
                'email' => 'ana.torres@empresa.com',
                'position' => 'Desarrollador Senior',
                'department' => 'Tecnología',
                'hire_date' => '2015-03-10',
                'status' => 'Activo'
            ],
            [
                'id' => 2,
                'name' => 'Luis Méndez',
                'email' => 'luis.mendez@empresa.com',
                'position' => 'Gerente de Proyectos',
                'department' => 'Operaciones',
                'hire_date' => '2018-07-01',
                'status' => 'Activo'
            ],
            // ... más empleados simulados ...
        ];
        return view('employees.index', compact('employees'));
    }

    public function show($id)
    {
        // Simulación de un empleado específico
        $employee = collect([
            [
                'id' => 1,
                'name' => 'Ana Torres',
                'email' => 'ana.torres@empresa.com',
                'position' => 'Desarrollador Senior',
                'department' => 'Tecnología',
                'hire_date' => '2015-03-10',
                'status' => 'Activo',
                'phone' => '123-456-7890',
                'address' => 'Calle Falsa 123',
                'salary' => '1200.00',
                'benefits' => 'Seguro Médico, Vale de Comida',
                'emergency_contact' => 'Pedro Torres (Hermano) - 987-654-3210'
            ],
            // ... más detalles de empleados simulados ...
        ])->firstWhere('id', $id);

        if (!$employee) {
            abort(404);
        }
        return view('employees.show', compact('employee'));
    }

    // Datos simulados de empleados para el listado general (employees.index)
    private $simulated_employees_general = [
        [
            'id' => 1,
            'name' => 'Ana Torres',
            'email' => 'ana.torres@empresa.com',
            'position' => 'Desarrollador Senior',
            'department' => 'Tecnología',
            'hire_date' => '2015-03-10',
            'status' => 'Activo'
        ],
        [
            'id' => 2,
            'name' => 'Luis Méndez',
            'email' => 'luis.mendez@empresa.com',
            'position' => 'Gerente de Proyectos',
            'department' => 'Operaciones',
            'hire_date' => '2018-07-01',
            'status' => 'Activo'
        ],
        [
            'id' => 3,
            'name' => 'María López',
            'email' => 'maria.lopez@empresa.com',
            'position' => 'Diseñadora UX/UI',
            'department' => 'Diseño',
            'hire_date' => '2020-01-20',
            'status' => 'Activo'
        ],
        [
            'id' => 4,
            'name' => 'Carlos Pérez',
            'email' => 'carlos.perez@empresa.com',
            'position' => 'Analista Financiero',
            'department' => 'Finanzas',
            'hire_date' => '2019-05-15',
            'status' => 'Activo'
        ],
        [
            'id' => 5,
            'name' => 'Laura Gómez',
            'email' => 'laura.gomez@empresa.com',
            'position' => 'Especialista en RRHH',
            'department' => 'Recursos Humanos',
            'hire_date' => '2017-11-22',
            'status' => 'Activo'
        ],
    ];

    // Datos simulados de empleados con experiencias para la vista de experiencias
    private $simulated_employee_experiences = [
        [
            'id' => 1,
            'name' => 'Ana Torres',
            'position' => 'Desarrollador Senior',
            'department' => 'Tecnología',
            'hire_date' => '2015-03-10',
            'photo' => 'https://via.placeholder.com/150/007bff/ffffff?text=Ana', // URL de una imagen de placeholder
            'experience' => 'Desde que llegué, me he sentido parte de una familia. La evolución profesional es constante.',
            'long_experience' => 'Llegué a la empresa hace más de 10 años como desarrolladora junior y, gracias al apoyo y las oportunidades, he crecido hasta ser senior. La cultura de aprendizaje y la colaboración son inigualables. Cada día es un nuevo reto y una nueva oportunidad para innovar. Me siento muy orgullosa de ser parte de este equipo.'
        ],
        [
            'id' => 2,
            'name' => 'Luis Méndez',
            'position' => 'Gerente de Proyectos',
            'department' => 'Operaciones',
            'hire_date' => '2018-07-01',
            'photo' => 'https://via.placeholder.com/150/28a745/ffffff?text=Luis',
            'experience' => 'Un ambiente dinámico que impulsa la creatividad y el trabajo en equipo.',
            'long_experience' => 'Como gerente de proyectos, he encontrado un equipo increíblemente talentoso y comprometido. La empresa fomenta la autonomía y la innovación, lo que nos permite abordar proyectos desafiantes con confianza. La comunicación abierta y la retroalimentación constante son clave para nuestro éxito y mi desarrollo personal.'
        ],
        [
            'id' => 3,
            'name' => 'María López',
            'position' => 'Diseñadora UX/UI',
            'department' => 'Diseño',
            'hire_date' => '2020-01-20',
            'photo' => 'https://via.placeholder.com/150/ffc107/ffffff?text=Maria',
            'experience' => 'Amo cómo se valora la visión creativa y el impacto del diseño en el producto final.',
            'long_experience' => 'Mi experiencia como diseñadora UX/UI ha sido sumamente gratificante. Aquí, el diseño no es solo estética, sino una pieza fundamental en la estrategia del producto. Se nos da la libertad de experimentar y proponer ideas, y ver cómo nuestras creaciones mejoran la experiencia del usuario es muy motivador. El equipo es muy colaborativo y siempre estamos aprendiendo los unos de los otros.'
        ],
        [
            'id' => 4,
            'name' => 'Carlos Pérez',
            'position' => 'Analista Financiero',
            'department' => 'Finanzas',
            'hire_date' => '2019-05-15',
            'photo' => 'https://via.placeholder.com/150/dc3545/ffffff?text=Carlos',
            'experience' => 'El rigor y la ética profesional son los pilares de este gran lugar de trabajo.',
            'long_experience' => 'En el área de finanzas, la precisión y la atención al detalle son cruciales, y la empresa realmente lo valora. Me siento seguro y apoyado por un equipo de profesionales experimentados. Las oportunidades para crecer y asumir nuevas responsabilidades son claras, lo que me ha permitido consolidar mis conocimientos y habilidades en el ámbito financiero.'
        ],
        [
            'id' => 5,
            'name' => 'Laura Gómez',
            'position' => 'Especialista en RRHH',
            'department' => 'Recursos Humanos',
            'hire_date' => '2017-11-22',
            'photo' => 'https://via.placeholder.com/150/17a2b8/ffffff?text=Laura',
            'experience' => 'Trabajar en RRHH aquí es gratificante; realmente se preocupan por el bienestar de todos.',
            'long_experience' => 'Como especialista en Recursos Humanos, mi misión es asegurar un ambiente de trabajo positivo y productivo. Me encanta que la empresa priorice el bienestar de sus empleados y ofrezca programas de desarrollo y apoyo. Es muy satisfactorio ver cómo las iniciativas de RRHH tienen un impacto directo en la satisfacción y el rendimiento de la gente.'
        ],
    ];

    public function experiences()
    {
        $employees_experiences = $this->simulated_employee_experiences;
        return view('employees.experiences', compact('employees_experiences'));
    }

}
