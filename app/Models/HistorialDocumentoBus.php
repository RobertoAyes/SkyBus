<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialDocumentoBus extends Model
{
    use HasFactory;

    protected $table = 'historial_documentos_buses';

    protected $fillable = [
        'documento_id',
        'accion',
        'descripcion',
        'usuario_id',
    ];

    public function documento()
    {
        return $this->belongsTo(DocumentoBus::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
