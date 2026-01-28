<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = ['nombre','imagen'];

    public function lugares() {
        return $this->hasMany(Lugar::class);
    }

    public function comidas() {
        return $this->hasMany(Comida::class);
    }
}
