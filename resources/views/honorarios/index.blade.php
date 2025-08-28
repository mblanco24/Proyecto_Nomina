@extends('layouts.app')

@section('content')
<style>

    

    .scrollable-table {
        max-height: 300px; /* o la altura que prefieras */
        overflow-y: auto;
    }


    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>
<div class="container">
    <h2 class="mt-4 mb-4">Reporte Biométrico</h2>

    <div class="card shadow-sm">
        <div class="card-header text-white" style="background-color: #3a7ca5;"> <!-- Color específico -->
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Registro de Asistencia</h3>
                <div>
                    <button id="subir-CSV" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalSubirArchivo">
                        <i class="fas fa-upload me-1"></i> Subir CSV
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
                            <label for="filtroEvento">Evento</label>
                            <select id="filtroEvento" class="form-control form-control-sm">
                                <option value="">Todas</option>
                                <option value="ENTRADA" >ENTRADA</option>
                                <option value="SALIDA" >SALIDA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filtro-fecha">Fecha</label>
                            <input type="date" id="filtro-fecha" class="form-control form-control-sm">
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="card-body">
            <div class="scrollable-table">
                <table class="table table-bordered table-hover" id="tabla-biometrico">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="ps-3">#</th>
                            <th width="25%">Empleado</th>
                            <th width="30%">Dirección</th>
                            <th >Fecha</th>
                            <th >Hora</th>
                            <th width="20%" class="text-center">Evento</th>
                     
                    </thead>
                    <tbody id=tabla-registros>
                        <!-- Ejemplo de datos -->
                        <!-- AQUI VA LOS RESULTADO DE LA API-->
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
<div class="modal fade" id="modalSubirArchivo" tabindex="-1" aria-labelledby="modalSubirArchivoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="form-subir-archivo" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSubirArchivoLabel">Subir archivo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="archivo" class="form-label">Selecciona un archivo:</label>
            <input class="form-control" type="file" id="archivo" name="archivo" accept=".xlsx,.xls,.csv" required>
            <div class="form-text">Formatos permitidos: .xlsx, .xls, .csv</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Subir</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/reporteBiometrico.js') }}"></script>

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
