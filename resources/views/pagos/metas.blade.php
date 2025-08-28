@extends('layouts.app')

@section('content')
<div class="card border-0 shadow-lg">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-bullseye me-2"></i> Asignación de Metas
            </h5>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#nuevaMetaModal">
                <i class="fas fa-plus me-1"></i> Nueva Meta
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Filtros -->
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <label class="form-label">Unidad Administrativa:</label>
                <select class="form-select">
                    <option selected>Todas</option>
                    <option>INHRR_ADMINISTRACION</option>
                    <option>INHRR_TECNOLOGIA</option>
                    <option>INHRR_RRHH</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Estado:</label>
                <select class="form-select">
                    <option selected>Todos</option>
                    <option>En progreso</option>
                    <option>Completada</option>
                    <option>Atrasada</option>
                    <option>No iniciada</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filtrar
                </button>
            </div>
        </div>

        <!-- Listado de empleados con metas -->
        <div class="accordion" id="metasAccordion">


    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
               
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Anterior</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal para asignar nueva meta -->
<div class="modal fade" id="nuevaMetaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Asignar Nueva Meta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAsignarMeta">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Empleado:</label>
                            <select class="form-select" name="empleado_id" required>
                                <option value="">Seleccionar empleado...</option>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta:</label>
                            <select class="form-select" name="meta_id" required>
                                <option value="">Seleccionar meta...</option>

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha Límite:</label>
                            <input type="date" class="form-control" name="fecha_limite" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prioridad:</label>
                            <select class="form-select" name="prioridad">
                                <option value="normal">Normal</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Comentarios/Instrucciones:</label>
                            <textarea class="form-control" name="comentarios" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Asignar Meta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar progreso -->
<div class="modal fade" id="editarProgresoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Actualizar Progreso de Meta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarProgreso">
                <input type="hidden" name="asignacion_id" id="asignacion_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Meta:</label>
                        <input type="text" class="form-control" id="meta_nombre" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nuevo Progreso (%):</label>
                        <input type="range" class="form-range" min="0" max="100" step="5"
                               id="rangoProgreso" name="nuevo_avance" oninput="actualizarValor(this.value)">
                        <div class="text-center mt-2">
                            <span id="valorProgreso" class="fw-bold fs-4">0%</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comentarios:</label>
                        <textarea class="form-control" name="comentarios" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Función para abrir modal de asignación con empleado específico
function asignarMetaModal(empleadoId, empleadoNombre) {
    $('#nuevaMetaModal select[name="empleado_id"]').val(empleadoId);
    $('#nuevaMetaModal').modal('show');
}

// Función para abrir modal de edición de progreso
function editarProgresoModal(asignacionId, metaNombre, progresoActual) {
    $('#asignacion_id').val(asignacionId);
    $('#meta_nombre').val(metaNombre);
    $('#rangoProgreso').val(progresoActual);
    $('#valorProgreso').text(progresoActual + '%');
    $('#editarProgresoModal').modal('show');
}

// Función para actualizar el valor del rango
function actualizarValor(valor) {
    $('#valorProgreso').text(valor + '%');
}

// Manejar envío del formulario de asignación
$('#formAsignarMeta').on('submit', function(e) {
    e.preventDefault();

    // Aquí iría la llamada AJAX para guardar
    console.log('Datos a enviar:', $(this).serialize());

    // Simulación de respuesta exitosa
    alert('Meta asignada correctamente');
    $('#nuevaMetaModal').modal('hide');
    $(this).trigger('reset');
});

// Manejar envío del formulario de progreso
$('#formEditarProgreso').on('submit', function(e) {
    e.preventDefault();

    // Aquí iría la llamada AJAX para actualizar
    console.log('Datos a enviar:', $(this).serialize());

    // Simulación de respuesta exitosa
    alert('Progreso actualizado correctamente');
    $('#editarProgresoModal').modal('hide');
    $(this).trigger('reset');
});

$(document).ready(function() {
    // Inicializar tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endsection
@endsection
