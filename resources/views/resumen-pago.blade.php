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

    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">RESUMEN DE PAGO</h5>
    </div>

    <div class="card-body">
        <!-- Filtros mejorados -->
        <div class="row mb-4 g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Período:</label>
                <select class="form-select">
                    <option selected>julio de 2025</option>
                    <option>agosto de 2025</option>
                    <option>septiembre de 2025</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Direcciones:</label>
                <select class="form-select">
                    <option selected>DOCENCIA</option>
                    <option>Otra Unidad</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Nivel/Cargo:</label>
                <select class="form-select">
                    <option selected>TECNICO</option>
                    <option>Todos</option>
                </select>
            </div>
        </div>

        <!-- Tabla principal con todos los campos -->
        <div id="tablaReportesContainer" class="scrollable-table"></div>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2">CÉDULA</th>
                        <th rowspan="2">NOMBRE Y APELLIDO</th>
                        <th rowspan="2">NIVEL/CARGO</th>
                        <th rowspan="2">DIRECCION</th>
                        <th rowspan="2">DIAS PENDIENTES</th>
                        <th rowspan="2">TOTAL DIA PEND.</th>
                        <th colspan="4" class="text-center">TOTAL METAS</th>
                    </tr>
                    <tr>
                        <th>L-V</th>
                        <th>S-D-F</th>
                        <th>DÍA PEND.</th>
                        <th>TOTAL</th>
                        <th>MONTO</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fila 1 -->
                    <tr>
                        <td>28322083</td>
                        <td>ARANGUREN WILLY</td>
                        <td>TECNICO</td>
                        <td>DOCENCIA</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">1</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">1</td>
                        <td class="text-end">258,75</td>
                    </tr>

                </tbody>
                <tfoot>
                    <tr class="table-active fw-bold">
                        <td colspan="4" class="text-end">TOTALES:</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">1</td>
                        <td class="text-end">258,75</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Pie de página con botones -->
    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between">
        <a href="/relacion-biometrico-metas" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Volver a Relación de Biometrico
        </a>
            <div>
                <button class="btn btn-success me-2">
                    <i class="fas fa-file-alt me-2"></i> Exportar TXT
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
