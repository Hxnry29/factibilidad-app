@extends('layouts.app')

@section('content')
<div class="mb-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ $estudio->nombre_proyecto }}</h2>
            <p class="text-muted mb-0">Resultados del análisis financiero y predicción algorítmica.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">
            <i class="bi bi-arrow-left"></i> Volver al Inicio
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- TARJETAS DE MÉTRICAS FINANCIERAS (BACKEND) -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-2">
                <div class="card-body">
                    <p class="text-muted fw-medium mb-1 small text-uppercase">Valor Presente Neto (VPN)</p>
                    <h3 class="fw-bold text-dark mb-0">$ {{ number_format($estudio->vpn, 2, ',', '.') }}</h3>
                    <small class="{{ $estudio->vpn > 0 ? 'text-success' : 'text-danger' }} fw-medium">
                        {{ $estudio->vpn > 0 ? 'Genera valor' : 'Destruye valor' }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-2">
                <div class="card-body">
                    <p class="text-muted fw-medium mb-1 small text-uppercase">Ratio de Deuda (RCSD)</p>
                    <h3 class="fw-bold text-dark mb-0">{{ number_format($estudio->rcsd, 2) }}</h3>
                    <small class="{{ $estudio->rcsd >= 1 ? 'text-success' : 'text-danger' }} fw-medium">
                        {{ $estudio->rcsd >= 1 ? 'Capacidad de pago sana' : 'Riesgo de impago' }}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-2">
                <div class="card-body">
                    <p class="text-muted fw-medium mb-1 small text-uppercase">Plazo de Financiación</p>
                    <h3 class="fw-bold text-dark mb-0">{{ $estudio->plazo_meses }} <span class="fs-6 text-muted fw-normal">meses</span></h3>
                    <small class="text-secondary fw-medium">CAPEX: $ {{ number_format($estudio->capex, 0, '', '.') }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- RESULTADO DE LA INTELIGENCIA ARTIFICIAL -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="row g-0">
            <!-- Porcentaje Visual -->
            <div class="col-md-4 text-white d-flex flex-column justify-content-center align-items-center p-5" 
                 style="background: {{ $estudio->probabilidad_ia >= 70 ? 'linear-gradient(135deg, #2563eb, #1d4ed8)' : 'linear-gradient(135deg, #dc3545, #b02a37)' }};">
                <i class="bi bi-robot fs-1 mb-2 opacity-75"></i>
                <h6 class="text-uppercase fw-semibold mb-1 opacity-75">Predicción de Éxito IA</h6>
                <h1 class="display-3 fw-bold mb-0">{{ $estudio->probabilidad_ia }}%</h1>
            </div>
            
            <!-- Explicabilidad y Recomendación -->
            <div class="col-md-8 p-5 bg-white d-flex flex-column justify-content-center">
                <h4 class="fw-bold mb-3">Recomendación del Modelo Predictivo</h4>
                <p class="text-secondary fs-5 mb-4" style="line-height: 1.6;">
                    "{{ $estudio->recomendacion_ia }}"
                </p>
                <div class="d-flex align-items-center text-muted small bg-light p-3 rounded">
                    <i class="bi bi-info-circle-fill text-primary me-2 fs-5"></i>
                    Esta predicción fue generada por un modelo de Machine Learning (Random Forest) entrenado con el historial de inversiones de la entidad.
                </div>
            </div>
        </div>
    </div>

    <!-- BOTONES FINALES DE SARC/SARO -->
    <div class="d-flex justify-content-end mt-4">
        <form action="{{ route('dashboard') }}" method="GET">
            <input type="hidden" name="mensaje" value="Estudio guardado con éxito.">
            <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm" style="background-color: #2563eb; border:none; border-radius: 8px;">
                <i class="bi bi-save me-2"></i> Guardar y Finalizar
            </button>
        </form>
    </div>
@endsection