<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 3/04/2024
    Modulo: DWES
    UD: 05
    Clase TurismoDTO 
    Es una clase general que sirve para encapsular todos los datos relacionados con 
    turismos
*/  
namespace App\Models\DTO;

use JsonSerializable;

class TurismoDTO implements JsonSerializable{
   

     
        private $vehiculo_id;
        private $electrico;

        // las propiedades se establecen a partir de un array asociativo
        public function __construct($vehiculoNuevo, $datos)
        {
            $this->vehiculo_id = $vehiculoNuevo['id'];
            $this->electrico = $datos['electrico'];
        }
    
    

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function toArray(): array {
        return [
            'vehiculo_id' => $this->vehiculo_id,
            'electrico' => $this->electrico
        ];
    }

        /**
         * Get the value of capacidad
         */
        public function getElectrico()
        {
                return $this->electrico;
        }


}

?>