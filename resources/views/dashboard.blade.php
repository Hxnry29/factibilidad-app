@extends('layouts.app')

@section('content')
    <!-- Encabezado de la página -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Mis Estudios</h2>
            <p class="text-muted mb-0">Consulta y administra tus estudios de factibilidad.</p>
        </div>
       <a href="{{ route('estudios.create') }}" class="btn btn-primary px-4 py-2" style="background-color: #2563eb; border-radius: 8px;">
    <i class="bi bi-plus-lg"></i> Crear nuevo estudio
</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Tarjeta Blanca de la Tabla -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-4 py-3 border-bottom-0">ID</th>
                        <th class="py-3 border-bottom-0">Nombre del proyecto</th>
                        <th class="py-3 border-bottom-0">Fecha</th>
                        <th class="py-3 border-bottom-0">Creado por</th>
                        <th class="py-3 border-bottom-0">Estado</th>
                        <th class="pe-4 py-3 border-bottom-0 text-end"></th>
                    </tr>
                </thead>
               <tbody>
                @foreach($estudios as $estudio)
                    <tr>
                        <td class="ps-4 py-3 text-secondary">FS-{{ str_pad($estudio->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-3 fw-medium">{{ $estudio->nombre_proyecto }}</td>
                        <td class="py-3 text-secondary">{{ $estudio->created_at->format('Y-m-d') }}</td>
                        <!-- Por ahora pondremos un texto estático hasta que le amarremos el ID del usuario al estudio -->
                        <td class="py-3 text-secondary">Analista del sistema</td> 
                        <td class="py-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-normal">
                        {{ $estudio->estado ?? 'Evaluado' }}
                    </span>
                    </td>
                    <td class="pe-4 py-3 text-end">
    <div class="d-flex justify-content-end gap-2">
        <!-- Botón Ver Resultados -->
        <a href="{{ route('estudios.show', $estudio->id) }}" class="btn btn-sm btn-outline-primary">
            Ver Resultados
        </a>

        <!-- Botón Eliminar con Advertencia -->
        <form action="{{ route('estudios.destroy', $estudio->id) }}" method="POST" onsubmit="return confirm('ADVERTENCIA DE SEGURIDAD:\n\n¿Estás completamente seguro de que deseas eliminar el proyecto \'{{ $estudio->nombre_proyecto }}\'?\n\nEsta acción es DEFINITIVA e IRREVERSIBLE.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar Estudio">
                <i class="bi bi-trash3"></i>
            </button>
        </form>
    </div>
</td>
        </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
@endsection