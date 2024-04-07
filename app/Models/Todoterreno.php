<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todoterreno extends Model
{
    use HasFactory;
    // conecto el modelo con la tabla
    protected $table = 'todoterrenos';
    // establezco sus campos como editables
    protected $fillable = ['cuatro_por_cuatro','vehiculo_id'];
    // Declaro como false las propiedades que laravel da por defecto
    protected $created_at=false;
    protected $updated_at=false;
    public $timestamps = false;
    // establezco como clave primaria vehiculo_id
    protected $primaryKey = 'vehiculo_id';

}
