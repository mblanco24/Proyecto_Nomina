@extends('layouts.app')

@section('content')
<style>
    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        
    }

    .scrollable-table {
        max-height: 300px; /* o la altura que prefieras */
        overflow-y: auto;
    }

    .scrollable-table-large {
        max-height: 700px; /* o la altura que prefieras */
        overflow-y: auto;
    }

    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>
<div class="card border-0 shadow-lg scrollable-table-large">
    <div class="card-header bg-primary text-white py-3 ">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-bullseye me-2"></i> Asignación de Metas
            </h5>
            <button id="btn-asignacion" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#nuevaMetaModal">
                <i class="fas fa-plus me-1"></i> Nueva Meta
            </button>

            <button id="btn-reporte" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalReportePagos">
                <i class="fas fa-plus me-1"></i> Ver reporte
            </button>
        </div>
    </div>

    <div class="card-body">
        <!-- Filtros -->
        <div class="row mb-4 g-3">

            <div class="col-md-4 d-flex align-items-end">
            <div class="d-flex justify-content-end mb-2">
                 <input type="text" id="filtroCedula" placeholder="Filtrar por cédula" class="form-control form-control-sm" style="max-width: 200px;">
            </div>

        </div>

        <!-- Listado de empleados con metas -->
        <div class="accordion" id="metasAccordion">
    </div>

    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                                
                <nav>
                    <ul id="paginacion" class="pagination pagination-sm mb-0"></ul>
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
                                         <!--AQUI VAN LOS EMPLEADOS DESDE LA API-->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta:</label>
                            <select class="form-select" name="meta_id" required>
                                  <!--AQUI VAN LAS METAS DESDE LA API-->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha Asignacion:</label>
                            <input type="date" class="form-control" name="fecha_limite" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Feriado:</label>
                            <input type="checkbox" class="form-control" name="Feriado" value='False'>
                        </div>



                        <div class="col-12">
                            <label class="form-label">Comentarios/Instrucciones:</label>
                            <textarea class="form-control" name="comentarios" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="asignar" type="submit" class="btn btn-primary">Asignar Meta</button>
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

<div class="modal fade" id="modalReportePagos" tabindex="-1" aria-labelledby="modalReportePagosLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen"> <!-- Pantalla completa -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalReportePagosLabel">Reporte de Pagos por Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div id="tablaReportesContainer" class="table-responsive"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="btn-exportar" >Exportar txt</button>
      </div>
      
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/asignacionesMetas.js') }}"></script>


@endsection
