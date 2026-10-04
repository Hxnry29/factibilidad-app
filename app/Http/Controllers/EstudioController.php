<?php
namespace App\Http\Controllers;

use App\Models\Estudio;
use Illuminate\Http\Request;
use App\Models\LogAuditoria;
use Illuminate\Support\Facades\Auth;

class EstudioController extends Controller
{
    // Mostrar el formulario
    public function create()
    {
        return view('estudios.create');
    }

    // Guardar los datos en la base de datos
    public function store(Request $request)
    {
        //Validar que envíen números
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'inflacion' => 'required|numeric',
            'tasa_cambio' => 'required|numeric',
            'capex' => 'required|numeric',
            'plazo_meses' => 'required|numeric',
            'ingresos' => 'required|numeric',
            'opex' => 'required|numeric',
        ]);

        //Guardar en la base de datos
        $estudio = Estudio::create($request->all());
        
        LogAuditoria::create([
        'user_id' => Auth::id(),
        'accion' => "Creación de estudio de factibilidad: " . $estudio->nombre_proyecto,
        'ip_address' => $request->ip()
        ]);

        //(Por ahora) Redirigimos de vuelta al dashboard con mensaje de éxito
        // Más adelante, aquí llamaremos a la IA y redirigiremos al Paso 2 (Resultados)
        return redirect()->route('dashboard')->with('success', 'Estudio guardado correctamente y listo para evaluar.');
    }
}