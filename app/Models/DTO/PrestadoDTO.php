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
class PrestadoDTO implements JsonSerializable{
    private $marca;
    private $modelo;
    private $clase;
    private $prestado;
    private $fecha_inicio;
    private $fecha_fin;
    private $capacidad;
    private $electrico;
    private $cuatro_por_cuatro;
    private $nombre;
    private $departamento;
    private $id;

    
    public function __construct($datos) {
        $this->marca = $datos->marca;
        $this->modelo = $datos->modelo;
        $this->id = $datos->id;

        $this->clase = $datos->clase;
   
        $this->prestado = $datos->prestado;
        $this->fecha_inicio = $datos->fecha_inicio;
        $this->fecha_fin = $datos->fecha_fin;
        $this->cuatro_por_cuatro = $datos->cuatro_por_cuatro;
        $this->electrico = $datos->electrico;
        $this->capacidad = $datos->capacidad;    

        $this->nombre = $datos->nombre;
        $this->departamento = $datos->departamento;
        
        }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
        /**
     * Get the value of marca
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of marca
     */
    public function getMarca()
    {
        return $this->marca;
    }



    /**
     * Get the value of modelo
     */
    public function getModelo()
    {
        return $this->modelo;
    }


    /**
     * Get the value of clase
     */
    public function getClase()
    {
        return $this->clase;
    }



    /**
     * Get the value of prestado
     */
    public function getPrestado()
    {
        return $this->prestado;
    }

    /**
     * Get the value of capacidad
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Get the value of cuatro_por_cuatro
     */
    public function getCuatro_por_cuatro()
    {
        return $this->cuatro_por_cuatro;
    }
    /**
     * Get the value of cuatro_por_cuatro
     */
    public function getElectrico()
    {
        return $this->electrico;
    }
    /**
     * Get the value of fecha_inicio
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }



    /**
     * Get the value of fecha_fin
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
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