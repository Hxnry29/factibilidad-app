<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EFAC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; height: 100vh; } </style>
</head>
<body>
    <div class="card shadow-sm border-0" style="width: 400px; border-radius: 12px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">EFAC</h3>
                <p class="text-muted small">Estudios de Factibilidad</p>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger small">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium small">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="juan@efac.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-medium small">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #2563eb;">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>