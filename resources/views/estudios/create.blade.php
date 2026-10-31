@extends('layouts.app')

@section('content')
<style>
    
    .stepper-circle {
        width: 35px; height: 35px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 14px;
    }
    .stepper-active { background-color: #2563eb; color: white; }
    .stepper-inactive { background-color: #e2e8f0; color: #64748b; }
    .stepper-line { flex-grow: 1; height: 2px; background-color: #e2e8f0; margin: 0 15px; position: relative; }
    .stepper-line::after { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 50%; background-color: #2563eb; }
    
    .card-custom { border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .icon-box { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: #eff6ff; color: #2563eb; font-size: 1.2rem; }
    .input-suffix { background-color: transparent; border-left: 0; color: #94a3b8; font-size: 0.9rem; }
    .form-control-custom { border-right: 0; }
    .form-control-custom:focus { box-shadow: none; border-color: #dee2e6; }
</style>

<div class="mb-4">
    <h2 class="fw-bold mb-4">Nuevo Estudio de Factibilidad</h2>
    
    <!-- Barra de progreso (Stepper) -->
    <div class="d-flex align-items-center mb-5" style="max-width: 600px;">
        <div class="d-flex align-items-center gap-2">
            <div class="stepper-circle stepper-active">1</div>
            <span class="text-primary fw-medium">1. Entradas</span>
        </div>
        <div class="stepper-line"></div>
        <div class="d-flex align-items-center gap-2">
            <div class="stepper-circle stepper-inactive">2</div>
            <span class="text-muted fw-medium">2. Resultados</span>
        </div>
    </div>

    <!-- EL FORMULARIO FUNCIONAL -->
    <form action="{{ route('estudios.store') }}" method="POST">
        @csrf <!-- Token de seguridad obligatorio en Laravel -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Campo extra necesario para guardar en la BD -->
        <div class="mb-4" style="max-width: 400px;">
            <label class="form-label fw-medium">Nombre del Proyecto</label>
            <input type="text" name="nombre_proyecto" class="form-control" placeholder="Ej. Expansión Planta de Alimentos" required>
        </div>

        <div class="row g-4 mb-5">
            <!-- TARJETA 1: MACRO -->
            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <div class="card-body">
                        <div class="d-flex gap-3 mb-4">
                            <div class="icon-box"><i class="bi bi-globe"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1">Macro</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.2;">Variables del entorno económico que afectan el proyecto.</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Inflación (%)</label>
                            <div class="input-group">
                                <input type="number" step="any" name="inflacion" class="form-control form-control-custom" placeholder="Ej. 3.5" required>
                                <span class="input-group-text input-suffix">%</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="form-label fw-medium small">Tasa de cambio actual</label>
                            <div class="input-group">
                                <input type="number" step="any" name="tasa_cambio" class="form-control form-control-custom" placeholder="Ej. 4320" required>
                                <span class="input-group-text input-suffix">COP/USD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA 2: INVERSIÓN -->
            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <div class="card-body">
                        <div class="d-flex gap-3 mb-4">
                            <div class="icon-box"><i class="bi bi-database"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1">Inversión</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.2;">Recursos necesarios para el desarrollo del proyecto.</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium small">CAPEX</label>
                            <div class="input-group">
                                <input type="number" step="any" name="capex" class="form-control form-control-custom" placeholder="Ej. 1500000000" required>
                                <span class="input-group-text input-suffix">COP</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="form-label fw-medium small">Plazo de financiación (meses)</label>
                            <div class="input-group">
                                <input type="number" name="plazo_meses" class="form-control form-control-custom" placeholder="Ej. 36" required>
                                <span class="input-group-text input-suffix">meses</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA 3: OPERACIÓN -->
            <div class="col-md-4">
                <div class="card card-custom h-100 p-3">
                    <div class="card-body">
                        <div class="d-flex gap-3 mb-4">
                            <div class="icon-box"><i class="bi bi-gear"></i></div>
                            <div>
                                <h5 class="fw-bold mb-1">Operación</h5>
                                <p class="text-muted small mb-0" style="line-height: 1.2;">Ingresos y costos esperados del proyecto.</p>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-medium small">Ingresos esperados</label>
                            <div class="input-group">
                                <input type="number" step="any" name="ingresos" class="form-control form-control-custom" placeholder="Ej. 2800000000" required>
                                <span class="input-group-text input-suffix">COP</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="form-label fw-medium small">OPEX</label>
                            <div class="input-group">
                                <input type="number" step="any" name="opex" class="form-control form-control-custom" placeholder="Ej. 1200000000" required>
                                <span class="input-group-text input-suffix">COP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Envío -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary px-5 py-3 shadow-sm" style="background-color: #2563eb; border-radius: 8px; font-weight: 500;">
                <i class="bi bi-stars"></i> Calcular y Evaluar con IA
            </button>
        </div>
    </form>
</div>
@endsection