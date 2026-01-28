<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    protected $fillable = ['departamento_id','nombre','imagen'];

    public function departamento() {
        return $this->belongsTo(Departamento::class);
    }
}
