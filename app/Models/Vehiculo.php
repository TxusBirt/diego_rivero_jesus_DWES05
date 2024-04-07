<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Vehiculo extends Model
{
    use HasFactory;
    // conecto con la tabla vehiculos de la BBDD
    protected $table = 'vehiculos';
    // establezco sus campos como editables
    protected $fillable = ['marca','modelo','kilometros','year','clase',
    'disponible','prestado','fecha_inicio','fecha_fin',
    'usuario_id', 'revision','id'];
    // Declaro como false las propiedades que laravel da por defecto
    protected $created_at=false;
    protected $updated_at=false;
    public $timestamps = false;


  
}
