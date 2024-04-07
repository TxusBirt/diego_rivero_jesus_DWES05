<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    // conecto el modelo con la tabla
    protected $table = 'usuarios';
    // Declaro como false las propiedades que laravel da por defecto
    public $timestamps = false;
}
