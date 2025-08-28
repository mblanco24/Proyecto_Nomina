@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">RELACIÓN METAS - BIOMÉTRICO </h5>
            <div>
                <button class="btn btn-sm btn-light">
                    <i class="fas fa-download"></i> Exportar
                </button>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card-body border-bottom">
        <div class="row">
<div class="col-md-4 mb-3">
    <label class="form-label">Semana:</label>
    <input type="week"
           class="form-control"
           name="semana"
           value="{{ date('Y-\WW') }}"
           min="2025-W01"
           max="2025-W52">
</div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Empleado:</label>
                <select class="form-select">
                    <option selected>Todos</option>
                    <option>NORIEGA LUIGI</option>
                    <!-- Agrega más empleados aquí -->
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Meta:</label>
                <select class="form-select">
                    <option selected>Todas</option>
                    <option>Cumple Meta</option>
                    <option>No Cumple Meta</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla principal -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light" id="table-head">
                    <tr>
                        <th rowspan="2" width="10%">CEDULA</th>
                        <th rowspan="2" width="15%">APELLIDOS Y NOMBRES</th>

                        <!-- Columnas para cada día -->
                        @php
                            $dias = [
                                'LUNES' => '07/07/2025',
                                'MARTES' => '08/07/2025',
                                'MIÉRCOLES' => '09/07/2025',
                                'JUEVES' => '10/07/2025',
                                'VIERNES' => '11/07/2025',
                                'SÁBADO' => '12/07/2025',
                                'DOMINGO' => '13/07/2025'
                            ];
                        @endphp

                        @foreach($dias as $dia => $fecha)
                        <th colspan="2">{{ $dia }} {{ $fecha }}</th>
                        @endforeach

                        <th rowspan="2" width="20%">DESCRIPCIÓN DE META</th>
                        <th rowspan="2" width="15%">ESTATUS DE META</th>
                    </tr>
                    <tr>
                        @foreach($dias as $dia => $fecha)
                        <th>ENTRADA</th>
                        <th>SALIDA</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="table-body" >
                    <tr>
                        <td>28322083</td>
                        <td>NORIEGA LUIGI</td>

                        <!-- Datos para Lunes -->
                        <td>07:33 AM</td>
                        <td>11:32 AM</td>

                        <!-- Datos para Martes -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Miércoles -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Jueves -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Viernes -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Sábado -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Domingo -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Metas -->
                        <td>
                            <div class="mb-1"><strong>Meta ventas Q3:</strong> 85% completada</div>
                        </td>
                        <td>
                            <select class="form-select form-select-sm">
                                <option value="">Seleccionar</option>
                                <option value="procede">Cumple Meta</option>
                                <option value="no_procede">No Cumple Meta</option>
                            </select>
                        </td>
                    </tr>

                        <tr>
                        <td>20183577</td>
                        <td>ARANGUREN WILLY</td>

                        <!-- Datos para Lunes -->
                        <td>07:33 AM</td>
                        <td>11:32 PM</td>

                        <!-- Datos para Martes -->
                        <td>06:48 AM</td>
                        <td>05:00 PM</td>

                        <!-- Datos para Miércoles -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Jueves -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Viernes -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Sábado -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Datos para Domingo -->
                        <td>No registrado</td>
                        <td>No registrado</td>

                        <!-- Metas -->
                        <td>
                            <div class="mb-1"><strong>Limpieza de tu corazón	</strong> 30% completada</div>
                        </td>
                        <td>
                            <select class="form-select form-select-sm">
                                <option value="">Seleccionar</option>
                                <option value="procede">Cumple Meta</option>
                                <option value="no_procede">No Cumple Meta</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Puedes agregar más filas para otros empleados -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="card-footer bg-white">
        <div class="text-end text-muted small">
            Reporte generado el: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</div>

    <div class="card-footer bg-white d-flex justify-content-between py-3">
        <!-- Botón para volver a Relación de biometrico -->
        <a href="/relacionbiometrico" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Volver a Relación de Biometrico
        </a>

        <!-- Botón para Relación de Metas (a implementar luego) -->
        <a href="/resumen-pago" class="btn btn-outline-secondary">
            Resumen de Pago<i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/relacionBiometricoMetas.js') }}"></script>

@endsection

