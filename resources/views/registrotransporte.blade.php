@extends('layouts.app')

@section('content')

<style>
.swal-wide {
    width: 700px !important;
}
    .scrollable-table {
            max-height: 300px; /* o la altura que prefieras */
            overflow-y: auto;
        }



    .scrollable-table table {
        margin-bottom: 0; /* evita separación si hay scroll */
    }
</style>


<div class="container">
    <h2 class="mt-4 mb-4">Gestión de Transporte</h2>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Registro de Transporte</h3>
            <div>
                <button id='btn_registro'  class="btn btn-light btn-sm mr-2">
                    <i class="fas fa-plus"></i> Agregar
                </button>
                
               
            </div>
        </div>

        <!-- Filtros -->
        <div class="card-body border-bottom">
            <form id="filtros-form">
                <div class="row">
   
                        
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
            <div class="scrollable-table    ">
                <table class="table table-bordered table-hover" id="tabla-transporte">
                    <thead class="thead-light">
                        <tr>
                            <th width="100">Cédula</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                            <th>Ruta</th>
                         
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de datos -->
                        
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/transporte.js') }}"></script>
@endsection


