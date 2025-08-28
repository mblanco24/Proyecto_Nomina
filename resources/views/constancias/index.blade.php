@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Gestión de Constancias de Trabajo</h1>

    <div class="card">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <span>Historial de Solicitudes de Constancias</span>
            <button id="btn_modal" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#requestConstanciaModal">
                <i class="fas fa-plus" id= "btn-asignacion"></i> Solicitar Nueva Constancia
            </button>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif



            <div class="table-responsive">
                <div class="d-flex justify-content-end mb-2">
                <input type="text" id="filtroCedula" placeholder="Filtrar por cédula" class="form-control form-control-sm" style="max-width: 200px;">
            </div>
                <table class="table table-hover table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Empleado</th>
                            <th>Tipo de Constancia</th>
                            <th>Fecha Solicitud</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="employeeSelect" >
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal para Solicitar Nueva Constancia --}}
    <div class="modal fade" id="requestConstanciaModal" tabindex="-1" aria-labelledby="requestConstanciaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="requestConstanciaModalLabel">Solicitar Nueva Constancia de Trabajo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="constanciaForm">
                    <div class="modal-body">
                         <div class="col">
                            <label class="form-label">Empleado:</label>
                            <select class="form-select" name="empleado_id" id="cedula_empleado" required>
                                         <!--AQUI VAN LOS EMPLEADOS DESDE LA API-->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_constancia" class="form-label">Tipo de Constancia:</label>
                            <select class="form-select" id="tipo_constancia" name="tipo_constancia" required>
                                <option value="">Seleccione el tipo...</option>
                                <option value="Trabajo" selected>Trabajo</option>
                                <option value="Sueldo">Sueldo</option>
                                <option value="Antigüedad">Antigüedad</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_solicitud" class="form-label">Fecha de Solicitud:</label>
                            <input type="date" class="form-control" id="fecha_generacion" name="fecha_solicitud"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Registrar Constancia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="{{ asset('js/constancias.js') }}"></script>
@endsection
