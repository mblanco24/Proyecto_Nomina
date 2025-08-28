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
                @foreach($empleados as $empleado)
                <div class="accordion-item mb-3 border-0 shadow-sm">
                    <h2 class="accordion-header" id="heading{{ $empleado['id'] }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $empleado['id'] }}" aria-expanded="false"
                                aria-controls="collapse{{ $empleado['id'] }}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold">{{ $empleado['nombre'] }}</span>
                                    <span class="text-muted ms-3">{{ $empleado['cedula'] }}</span>
                                </div>
                                <div>
                                    <span class="badge bg-secondary">{{ $empleado['unidad'] }}</span>
                                    <span class="badge bg-info ms-2">{{ $empleado['cargo'] }}</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{ $empleado['id'] }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $empleado['id'] }}" data-bs-parent="#metasAccordion">
                        <div class="accordion-body pt-4">
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="mb-0">Metas asignadas</h6>
                                <button class="btn btn-sm btn-success"
                                        onclick="asignarMetaModal({{ $empleado['id'] }}, '{{ $empleado['nombre'] }}')">
                                    <i class="fas fa-plus me-1"></i> Asignar Meta
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30%">Meta</th>
                                            <th width="15%">Asignación</th>
                                            <th width="15%">Límite</th>
                                            <th width="15%">Estado</th>
                                            <th width="15%">Progreso</th>
                                            <th width="10%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($empleado['metas_asignadas'] as $meta)
                                        <tr>
                                            <td>{{ $meta['meta'] }}</td>
                                            <td>{{ $meta['fecha_asignacion'] }}</td>
                                            <td class="{{ Carbon\Carbon::createFromFormat('d/m/Y', $meta['fecha_limite'])->isPast() ? 'text-danger' : '' }}">
                                                {{ $meta['fecha_limite'] }}
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = [
                                                        'En progreso' => 'bg-primary',
                                                        'Completada' => 'bg-success',
                                                        'Atrasada' => 'bg-danger',
                                                        'No iniciada' => 'bg-secondary'
                                                    ][$meta['estado']] ?? 'bg-warning';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $meta['estado'] }}</span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar {{ $meta['avance'] == 100 ? 'bg-success' : 'bg-info' }}"
                                                        role="progressbar" style="width: {{ $meta['avance'] }}%;"
                                                        aria-valuenow="{{ $meta['avance'] }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $meta['avance'] }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary"
                                                        onclick="editarProgresoModal({{ $meta['id'] }}, '{{ $meta['meta'] }}', {{ $meta['avance'] }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Mostrando {{ count($empleados) }} empleados con metas asignadas
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
                                    @foreach($empleados as $empleado)
                                    <option value="{{ $empleado['id'] }}">{{ $empleado['nombre'] }} ({{ $empleado['cedula'] }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Meta:</label>
                                <select class="form-select" name="meta_id" required>
                                    <option value="">Seleccionar meta...</option>
                                    @foreach($metasDisponibles as $meta)
                                    <option value="{{ $meta['id'] }}">{{ $meta['nombre'] }}</option>
                                    @endforeach
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

    <script>

