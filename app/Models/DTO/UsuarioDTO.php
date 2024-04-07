<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 3/04/2024
    Modulo: DWES
    UD: 05
    Clase PrestadoDTO 
    Es una clase  que sirve para encapsular  los datos de los vehículos prestados y los usuarios 
    de los mismos
*/ 
namespace App\Models\DTO;
use JsonSerializable;

class UsuarioDTO implements JsonSerializable{
    private $usuario_id;
    private $nombre;
    private $departamento;

    
    public function __construct($datos) {
        $this->usuario_id = $datos['usuario_id'];
        $this->nombre = $datos['nombre'];
        $this->departamento = $datos['departamento'];
        
        }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    public function toArray(): array {
        return [
            'usuario_id' => $this->usuario_id,
            'nombre'=>$this->nombre,
            'departamento'=>$this->departamento
        ];
    }
    /**
     * Get the value of nombre
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }



    /**
     * Get the value of departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

}