@extends('layouts.app')

@section('content')
<style>


    .scrollable-table {
        max-height: 600px; /* o la altura que prefieras */
        overflow-y: auto;
    }

    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>
<h1 class="mb-4">Gestión de Vacaciones</h1>

<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <span>Estado de Vacaciones por Empleado</span>
        <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#assignVacationModal">
            <i class="fas fa-plus"></i> Asignar Días
        </button>
    </div>
    <div class="card-body">
       <div class="scrollable-table">
            <table class="table table-hover table-striped align-middle">
                    <div class="d-flex justify-content-end mb-2">
                        <input type="text" id="filtroCedula" placeholder="Filtrar por cédula" class="form-control form-control-sm" style="max-width: 200px;">
                     </div>
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Empleado</th>
                        <th>Cedula</th>
                        <th>Días Disponibles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="employeeResponse">
                </tbody>
                <tbody id="vacationsResponse">
                </tbody>
            </table>
        </div>

        <div class="alert alert-info d-none" role="alert" id="no-employees-alert">
            No hay empleados registrados aún.
        </div>
    </div>
</div>

<!-- Modal para Asignar Vacaciones -->
<div class="modal fade" id="assignVacationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Asignar Días de Vacaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="vacationForm">
                    <div class="mb-3">
                        <label for="cedula_empleado" class="form-label">Cédula del Empleado</label>
                        <input type="text" class="form-control" id="cedula_empleado" name="cedula_empleado" required>
                    </div>

                    <div class="mb-3">
                        <label for="dias" class="form-label">Días de Vacaciones</label>
                        <input type="number" class="form-control" id="dias" name="dias" min="1" max="30" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                        <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="Rechazado">Rechazado</option>
                        </select>
                    </div>

                    <div class="mb-3" id="aprobacionContainer">
                        <label for="aprobado_por" class="form-label">Aprobado por</label>
                        <input type="text" class="form-control" id="aprobado_por" name="aprobado_por">

                        <label for="fecha_aprobacion" class="form-label mt-2">Fecha de Aprobación</label>
                        <input type="date" class="form-control" id="fecha_aprobacion" name="fecha_aprobacion">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmAssignVacation">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Historial de Vacaciones -->
<div class="modal fade" id="vacationHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Historial de Vacaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="employeeHistoryTitle"></h6>
                <div class="table-responsive">
                    
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha Solicitud</th>
                                <th>Días</th>
                                <th>Periodo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="rendervacaciones">
                            <!-- Datos se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalles del Empleado -->
<div class="modal fade" id="employeeDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detalles del Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Información Personal</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nombre:</strong> <span id="detail-nombre"></span></li>
                            <li class="list-group-item"><strong>Cédula:</strong> <span id="detail-cedula"></span></li>
                            <li class="list-group-item"><strong>Email:</strong> <span id="detail-email"></span></li>
                            <li class="list-group-item"><strong>Fecha de Ingreso:</strong> <span id="detail-fecha-ingreso"></span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Vacaciones</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Días Disponibles:</strong> <span id="detail-dias-disponibles" class="badge bg-success"></span></li>
                            <li class="list-group-item"><strong>Últimas Vacaciones:</strong> <span id="detail-ultimas-vacaciones"></span></li>
                            <li class="list-group-item"><strong>Próximas Vacaciones:</strong> <span id="detail-proximas-vacaciones"></span></li>
                            <li class="list-group-item"><strong>Total Días Tomados:</strong> <span id="detail-total-tomados"></span></li>
                            <li class="list-group-item"><strong>Estado:</strong> <span id="detail-estado" class="badge"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
     </div>
</div>

<script src="{{ asset('js/vacaciones.js') }}"></script>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.85em;
        min-width: 70px;
    }

    .table-responsive {
        min-height: 300px;
    }

    .modal-error {
        display: none;
    }
</style>
@endpush
