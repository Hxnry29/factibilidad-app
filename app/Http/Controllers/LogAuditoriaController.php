<?php
namespace App\Http\Controllers;

use App\Models\LogAuditoria;
use Illuminate\Http\Request;

class LogAuditoriaController extends Controller
{
    public function index()
    {
        //logs con los datos del usuario, ordenados del más reciente al más antiguo
        $logs = LogAuditoria::with('user')->orderBy('created_at', 'desc')->get();
        return view('auditoria.index', compact('logs'));
    }
}