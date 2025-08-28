@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Gestión de Pagos por Metas</h1>

    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Listado de Pagos por Metas</span>
            
        </div>
        <div class="card-body">
            @if (count($metas) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>CEDULA</th>
                                <th>Empleado</th>
                                <th>Descripción de Meta</th>
                                <th>Fecha de Meta</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                            <tbody id="registros_metas">
                                
                            </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    No hay pagos por metas registrados.
                </div>
            @endif
        </div>
    </div>

<div class="card-footer bg-transparent border-top-0">
    <div class="d-flex justify-content-center">
        <a href="/relacionbiometrico" class="btn btn-outline-secondary">
            Relación de Biometrico<i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/pagosPorMetas.js') }}"></script>
@endsection
