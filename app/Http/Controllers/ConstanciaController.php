<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon; // Para manejar fechas
use App\Models\Constancia;

class ConstanciaController extends Controller
{
    // Datos simulados de empleados para el formulario de solicitud
 

    /**
     * Muestra la lista de solicitudes de constancias y el formulario de solicitud.
     */




    public function index()
    {
        // Pasar las solicitudes simuladas y los empleados para el formulario
        $requests = $this->simulated_requests;
        $employees = $this->simulated_employees;

        // Formatear fechas para la vista
        foreach ($requests as &$req) {
            $req['requested_date_formatted'] = Carbon::parse($req['requested_date'])->format('d/m/Y');
        }

        return view('constancias.index', compact('requests', 'employees'));
    }

    /**
     * Simula la solicitud de una nueva constancia.
     */
    public function store(Request $request)
    {
        // Lógica de validación básica simulada
        $request->validate([
            'employee_id' => 'required|integer',
            'type' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $employee = collect($this->simulated_employees)->firstWhere('id', $request->employee_id);

        if (!$employee) {
            return back()->with('error', 'Empleado no encontrado.')->withInput();
        }

        // Simular el registro de la solicitud
        $new_request_id = count($this->simulated_requests) + 1;
        $this->simulated_requests[] = [
            'id' => $new_request_id,
            'employee_id' => $employee['id'],
            'employee_name' => $employee['name'],
            'type' => $request->type,
            'requested_date' => Carbon::now()->format('Y-m-d'),
            'status' => 'Pendiente', // Nueva solicitud siempre pendiente
            'notes' => $request->notes,
            'generated_file' => null
        ];

        return redirect()->route('constancias.index')->with('success', 'Solicitud de constancia enviada con éxito.');
    }

    /**
     * Simula la generación y descarga de una constancia PDF.
     * En un entorno real, usarías una librería como Dompdf o Snappy.
     */

public function mostrarConstancia($id)
{
    // Obtener el registro desde la tabla (sin modelo Eloquent)
    $constancia = DB::table('constancias')->where('id_constancia', $id)->first();

    if (!$constancia) {
        return abort(404, "Constancia no encontrada");
    }

    // Pasar a la vista
    return view('pdfs.constancia_pdf', compact('constancia'));
}

}
