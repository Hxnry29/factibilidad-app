@extends('layouts.app')

@section('content')
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Registro de Auditoría (SARO)</h2>
            <p class="text-muted mb-0">Historial inmodificable de acciones y eventos del sistema.</p>
        </div>
        <div>
            <button class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">
                <i class="bi bi-download"></i> Exportar PDF
            </button>
        </div>
    </div>

    <!-- Tabla de Logs -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">Fecha y Hora</th>
                        <th class="py-3 border-bottom-0">Usuario Responsable</th>
                        <th class="py-3 border-bottom-0">Rol</th>
                        <th class="py-3 border-bottom-0">Acción Realizada</th>
                        <th class="pe-4 py-3 border-bottom-0 text-end">Dirección IP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td class="ps-4 py-3 text-secondary" style="font-family: monospace;">
                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="py-3 fw-medium">{{ $log->user->name }}</td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    {{ $log->user->rol }}
                                </span>
                            </td>
                            <td class="py-3 text-dark">
                                @if(str_contains($log->accion, 'Inicio de sesión'))
                                    <i class="bi bi-box-arrow-in-right text-success me-2"></i>
                                @else
                                    <i class="bi bi-file-earmark-plus text-primary me-2"></i>
                                @endif
                                {{ $log->accion }}
                            </td>
                            <td class="pe-4 py-3 text-end text-muted small" style="font-family: monospace;">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection