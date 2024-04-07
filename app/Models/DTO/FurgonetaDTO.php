<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 05
    Clase FurgonetaDTO
    Es una clase  que sirve para encapsular todos los datos relacionados con 
    furgonetas
*/  
namespace App\Models\DTO;

use JsonSerializable;

// clase para encapsular los datos de la tabla furgonetas
class FurgonetaDTO implements JsonSerializable{
   
        private $vehiculo_id;
        private $capacidad;

        // las propiedades se establecen a partir de un array asociativo
        public function __construct($vehiculoNuevo, $datos)
        {
            $this->vehiculo_id = $vehiculoNuevo['id'];
            $this->capacidad = $datos['capacidad'];
        }
    
    

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function toArray(): array {
        return [
            'vehiculo_id' => $this->vehiculo_id,
            'capacidad' => $this->capacidad
        ];
    }

        /**
         * Get the value of capacidad
         */
        public function getCapacidad()
        {
                return $this->capacidad;
        }


}

?>