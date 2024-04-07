<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furgoneta extends Model
{
    use HasFactory;
    // conecto el modelo con la tabla
    protected $table = 'furgonetas';
    // establezco sus campos como editables
    protected $fillable = ['capacidad','vehiculo_id'];
    // Declaro como false las propiedades que laravel da por defecto
    protected $created_at=false;
    protected $updated_at=false;
    public $timestamps = false;
    // establezco como clave primaria vehiculo_id
    protected $primaryKey = 'vehiculo_id';
}
