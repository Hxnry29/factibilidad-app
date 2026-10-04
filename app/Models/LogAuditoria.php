<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LogAuditoria extends Model
{
    protected $table = 'logs_auditoria';
    protected $fillable = ['user_id', 'accion', 'ip_address'];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}