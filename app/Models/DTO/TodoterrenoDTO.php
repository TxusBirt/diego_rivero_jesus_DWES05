<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 3/04/2024
    Modulo: DWES
    UD: 05
    Clase TodterrenoDTO
    Es una clase general que sirve para encapsular todos los datos relacionados con 
    todoterrenos
*/  
namespace App\Models\DTO;

use JsonSerializable;

class TodoterrenoDTO implements JsonSerializable{

    private $vehiculo_id;
    private $cuatro_por_cuatro ;
    // las propiedades se establecen a partir de un array asociativo
    public function __construct($vehiculoNuevo, $datos)
    {
        $this->vehiculo_id = $vehiculoNuevo['id'];
        $this->cuatro_por_cuatro = $datos['cuatro_por_cuatro'];
    }
    
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    public function toArray(): array {
        return [
            'vehiculo_id' => $this->vehiculo_id,
            'capacidad'=>$this->cuatro_por_cuatro
        ];
    }
    /**
        * Get the value of capacidad
    */
    public function getCuatro_por_cuatro()
    {
        return $this->cuatro_por_cuatro;
    }
}

?>