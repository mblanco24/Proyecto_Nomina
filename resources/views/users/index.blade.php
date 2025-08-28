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
    <h1 class="mb-4">Gestión de Usuarios</h1>

    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>Listado de Usuarios</span>

        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <input type="text" id="filtroCedula" placeholder="Filtrar por cédula" class="form-control form-control-sm" style="max-width: 200px;">
            </div>

                <div class="scrollable-table">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cedula</th>
                                <th>Nombre Completo</th>
                                <th>Correo</th>
                                <th>Departamento</th>
                                <th>Cargo</th>
                                 <th>Rol</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaEmpleados">
                        </tbody>
                    </table>
                </div>
           
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/usuarios.js') }}"></script>
@endsection
