<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    use HasFactory;

    protected $fillable = ['departamento_id', 'nombre', 'imagen'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
