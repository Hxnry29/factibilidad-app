<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\AuthController;
use App\Models\Estudio;
use App\Http\Controllers\LogAuditoriaController;

//Rutas Públicas (Login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Rutas Protegidas
Route::middleware('auth')->group(function () {
    
    Route::get('/', function () { return redirect()->route('dashboard'); });

    Route::get('/auditoria', [LogAuditoriaController::class, 'index'])->name('auditoria.index');

    //DASHBOARD CON BUSCADOR
    Route::get('/dashboard', function (Request $request) {
        $query = Estudio::query();
        
        //Buscador
        if ($request->has('buscar') && $request->buscar != '') {
            $query->where('nombre_proyecto', 'LIKE', '%' . $request->buscar . '%');
        }

        $estudios = $query->orderBy('created_at', 'desc')->get();
        
        return view('dashboard', compact('estudios'));
    })->name('dashboard');

    //Módulo de Estudios
    Route::get('/estudios/nuevo', [EstudioController::class, 'create'])->name('estudios.create');
    Route::post('/estudios/guardar', [EstudioController::class, 'store'])->name('estudios.store');
    Route::get('/estudios/{id}/resultados', [EstudioController::class, 'show'])->name('estudios.show');
    Route::delete('/estudios/{id}', [EstudioController::class, 'destroy'])->name('estudios.destroy');

    //Menú
    #Route::get('/mis-estudios', function () { return "Vista en construcción"; })->name('estudios.index');
    #Route::get('/auditoria', function () { return "Vista en construcción"; })->name('auditoria.index');
});