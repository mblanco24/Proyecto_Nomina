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
        max-height: 400px; /* o la altura que prefieras */
        overflow-y: auto;
    }

    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>
<div class="card border-0 shadow-lg">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-laptop-code me-2"></i> Reporte de Tecnología
            </h5>
            
        </div>
    </div>

    <div class="card-body">
        <h6 class="card-subtitle mb-3 text-muted">
            <i class="fas fa-history me-1"></i> Histórico de Acceso al Sistema Nómina
        </h6>

        <!-- Filtros rápidos -->
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <label class="form-label">Rango de fechas:</label>
                <input type="date" id="filtro-fecha" class="form-control date-range-picker" placeholder="Seleccionar rango">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tipo de acceso:</label>
                <select class="form-select" id="filtro-tipo">
                    <option selected value='todos'>Todos</option>
                    <option value='entrada' >Entrada</option>
                    <option value='salida' >Salida</option>
                </select>
            </div>

        </div>

        <!-- Tabla de resultados -->
        <div class="scrollable-table">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="15%">Fecha/Hora</th>
                        <th width="20%">Usuario</th>
                        <th width="15%">Cédula</th>
                        <th width="15%">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <!--RESULTADO DE LA API -->
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-between mt-4">
            <div class="text-muted small">
                Mostrando 1 a 3 de 15 registros
            </div>
            
        </div>
    </div>
</div>

<!-- Modal de Filtros Avanzados -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Filtros Avanzados</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenido del modal de filtros -->
                <p>Aquí irían filtros adicionales avanzados...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Aplicar Filtros</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/reporteTecnologia.js') }}"></script>
@endsection
