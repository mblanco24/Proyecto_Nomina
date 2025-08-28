@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mt-4 mb-4">Reporte Biométrico</h2>

    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: #3a7ca5;"> <!-- Color específico -->
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Registro de Asistencia</h3>
                <div>
                    <!-- Botón para subir CSV -->
                    <button class="btn btn-light btn-sm mr-2" data-toggle="modal" data-target="#modalCsv">
                        <i class="fas fa-file-upload"></i> Subir CSV
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card-body border-bottom">
            <form id="filtros-form">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="filtro-empleado">Empleado</label>
                            <input type="text" id="filtro-empleado" class="form-control form-control-sm" placeholder="Buscar empleado...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filtro-direccion">Dirección</label>
                            <select id="filtro-direccion" class="form-control form-control-sm">
                                <option value="">Todas</option>
                                <option>DOCENCIA E INVESTIGACION</option>
                                <option>DOCENCIA</option>
                                <option>ADMINISTRACIÓN</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filtro-fecha">Fecha</label>
                            <input type="date" id="filtro-fecha" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm mr-2" style="background-color: #3a7ca5; color: white;" onclick="aplicarFiltros()">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFiltros()">
                            <i class="fas fa-broom"></i> Limpiar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tabla-biometrico">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Empleado</th>
                            <th>Dirección</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de datos -->
                        <tr>
                            <td>1</td>
                            <td>NORIEGA LUIGI</td>
                            <td>DOCENCIA E INVESTIGACION</td>
                            <td>1.004/005 0533</td>
                            <td>1.004/005 1532</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>ABANGUREN WILLY</td>
                            <td>DOCENCIA</td>
                            <td>1.004/005 0657</td>
                            <td>1.004/005 1700</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-muted text-center">
            © {{ date('Y') }} Sistema de Nómina. Todos los derechos reservados.
        </div>
    </div>
</div>

<!-- Modal para subir CSV -->
<div class="modal fade" id="modalCsv" tabindex="-1" role="dialog" aria-labelledby="modalCsvLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3a7ca5; color: white;">
                <h5 class="modal-title" id="modalCsvLabel">Cargar archivo CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-csv" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="archivo-csv">Seleccione archivo CSV</label>
                        <input type="file" class="form-control-file" id="archivo-csv" name="archivo_csv" accept=".csv">
                        <small class="form-text text-muted">El archivo debe tener las columnas: Empleado, Dirección, Entrada, Salida</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn" style="background-color: #3a7ca5; color: white;" onclick="subirCSV()">Subir</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Función para aplicar filtros
    function aplicarFiltros() {
        const empleado = document.getElementById('filtro-empleado').value.toLowerCase();
        const direccion = document.getElementById('filtro-direccion').value;
        const fecha = document.getElementById('filtro-fecha').value;

        const filas = document.querySelectorAll('#tabla-biometrico tbody tr');

        filas.forEach(fila => {
            const celdaEmpleado = fila.cells[1].textContent.toLowerCase();
            const celdaDireccion = fila.cells[2].textContent;
            const celdaFecha = fila.cells[3].textContent.split(' ')[0];

            const coincideEmpleado = empleado === '' || celdaEmpleado.includes(empleado);
            const coincideDireccion = direccion === '' || celdaDireccion === direccion;
            const coincideFecha = fecha === '' || celdaFecha.includes(fecha.replace(/-/g, '/'));

            if (coincideEmpleado && coincideDireccion && coincideFecha) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }

    // Función para limpiar filtros
    function limpiarFiltros() {
        document.getElementById('filtro-empleado').value = '';
        document.getElementById('filtro-direccion').value = '';
        document.getElementById('filtro-fecha').value = '';
        aplicarFiltros();
    }

    // Función para subir CSV
    function subirCSV() {
        const formData = new FormData(document.getElementById('form-csv'));

        if (!document.getElementById('archivo-csv').files[0]) {
            alert('Por favor seleccione un archivo CSV');
            return;
        }

        // Mostrar carga
        const btnSubir = document.querySelector('#modalCsv .modal-footer button:last-child');
        btnSubir.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        btnSubir.disabled = true;

        // Simulación de envío (reemplazar con AJAX real)
        setTimeout(() => {
            alert('Archivo procesado correctamente (simulación)');
            $('#modalCsv').modal('hide');
            btnSubir.innerHTML = 'Subir';
            btnSubir.disabled = false;

            // Aquí iría la actualización de la tabla con los nuevos datos
        }, 2000);

        /*
        // Implementación real con AJAX:
        fetch('/subir-csv-biometrico', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            $('#modalCsv').modal('hide');
            // Actualizar la tabla con data.registros
        })
        .catch(error => {
            console.error('Error:', error);
        });
        */
    }
</script>
@endsection

@section('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .card-header {
        font-weight: bold;
        background-color: #3a7ca5 !important; /* Color azul específico */
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .form-control-sm {
        height: calc(1.5em + 0.5rem + 2px);
        padding: 0.25rem 0.5rem;
    }
    .card-footer {
        background-color: rgba(0, 0, 0, 0.03);
    }
    /* Color para botones principales */
    .btn-primary-custom {
        background-color: #3a7ca5;
        color: white;
    }
    .btn-primary-custom:hover {
        background-color: #2f6690;
        color: white;
    }
</style>
@endsection
