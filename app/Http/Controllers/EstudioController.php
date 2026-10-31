<?php
namespace App\Http\Controllers;

use App\Models\Estudio;
use Illuminate\Http\Request;
use App\Models\LogAuditoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
    
    $request->validate([
        'nombre_proyecto' => 'required|string|max:255',
        'inflacion' => 'required|numeric',
        'tasa_cambio' => 'required|numeric',
        'capex' => 'required|numeric',
        'plazo_meses' => 'required|numeric',
        'ingresos' => 'required|numeric',
        'opex' => 'required|numeric',
    ]);

    // 1. CÁLCULO MATEMÁTICO (Básico y simplificado)
    $flujoOperativo = $request->ingresos - $request->opex;
    
    // Cálculo básico de VPN (Simplificado a 1 año para el prototipo)
    $tasaDescuento = 0.12; 
    $vpn = -$request->capex + ($flujoOperativo / (1 + $tasaDescuento));
    
    // Cálculo de cuota y RCSD (Simplificado)
    $tasaInteresMes = 0.15 / 12;
    $cuotaMensual = ($request->capex * $tasaInteresMes) / (1 - pow(1 + $tasaInteresMes, -$request->plazo_meses));
    $pagoDeudaAnual = $cuotaMensual * 12;
    
    $rcsd = ($pagoDeudaAnual > 0) ? ($flujoOperativo / $pagoDeudaAnual) : 0;

    // 2. CONEXIÓN CON INTELIGENCIA ARTIFICIAL (PYTHON)
    $probabilidad_ia = 0;
    $recomendacion_ia = "No se pudo conectar con la IA.";

    try {
        
        $response = Http::post('http://127.0.0.1:5000/predecir', 
        [
            'inflacion' => $request->inflacion / 100,
            'tasa_cambio' => $request->tasa_cambio,
            'capex' => $request->capex,
            'opex' => $request->opex,
            'plazo_meses' => $request->plazo_meses,
            'vpn' => $vpn,
            'rcsd' => $rcsd
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Si Python procesó todo bien:
            if (isset($data['exito']) && $data['exito'] == true) {
                $probabilidad_ia = $data['probabilidad'];
                $recomendacion_ia = $data['recomendacion'];
            } else {
                // Si Python tuvo un error interno (ej: librerías desactualizadas)
                $recomendacion_ia = "Error de Python: " . ($data['error'] ?? 'Desconocido');
            }
        } else {
            $recomendacion_ia = "Error HTTP: " . $response->status();
        }
    } catch (\Exception $e) {
        // Si Laravel no encuentra el servidor 127.0.0.1:5000
        $recomendacion_ia = "Fallo de conexión: " . $e->getMessage();
    }

    // 3. GUARDAR TODO EN BASE DE DATOS
    $estudio = Estudio::create(array_merge($request->all(), [
        'vpn' => $vpn,
        'rcsd' => $rcsd,
        'probabilidad_ia' => $probabilidad_ia,
        'recomendacion_ia' => $recomendacion_ia
    ]));

    // 4. REGISTRAR PISTA DE AUDITORÍA (SARO)
    LogAuditoria::create([
        'user_id' => Auth::id(),
        'accion' => "Creación y evaluación de estudio: " . $estudio->nombre_proyecto . " (IA: ".$probabilidad_ia."%)",
        'ip_address' => $request->ip()
    ]);

    // Redirigir al dashboard
   return redirect()->route('estudios.show', $estudio->id)->with('success', 'Análisis completado con éxito.');


}
    public function show($id)
    {
    $estudio = Estudio::findOrFail($id);
    return view('estudios.show', compact('estudio'));
    }

    public function destroy(Request $request, $id)
    {
        
        $estudio = Estudio::findOrFail($id);
        $nombre_proyecto = $estudio->nombre_proyecto;

        // 2. Registrar la eliminación antes de borrar el estudio
        LogAuditoria::create([
            'user_id' => Auth::id(),
            'accion' => "Eliminación del estudio: " . $nombre_proyecto,
            'ip_address' => $request->ip()
        ]);

        
        $estudio->delete();

        
        return redirect()->route('dashboard')->with('success', 'El estudio ha sido eliminado correctamente.');
    }
}