@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center py-2">
        <span class="fw-semibold fs-5">Validación de Biométrico</span>
        <div>
            <button class="btn btn-outline-light btn-sm me-2">
                <i class="fas fa-download me-1"></i> Exportar
            </button>
            <button class="btn btn-outline-light btn-sm">
                <i class="fas fa-sync-alt me-1"></i> Actualizar
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light" id="table-head">
                    
                <tbody id="table-body">
                  
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white">
        <div class="d-flex justify-content-between">
        <a href="/metas" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Volver a Gestión de Metas
        </a>
        <!-- Botón para Relación de Metas (a implementar luego) -->
        <a href="/relacion-biometrico-metas" class="btn btn-outline-secondary">
            Relación Metas<i class="fas fa-arrow-right ms-2"></i>
        </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/relacionBiometrico.js') }}"></script>
@endsection
