@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Reporte de Transporte (Entrada/Salida)</h1>

    <div class="card">
        <div class="card-header bg-dark text-white">
            Registros de Transporte
        </div>
        <div class="card-body">
            @if (count($registros) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                <th>Fecha</th>
                                <th>Hora Entrada</th>
                                <th>Hora Salida</th>
                                <th>Vehículo</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                </div>
            
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/transporte.js') }}"></script>

@endsection
