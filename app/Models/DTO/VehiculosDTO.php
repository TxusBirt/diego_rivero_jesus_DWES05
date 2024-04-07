<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 04
    Clase VehiculosDTO 
    Es una clase general que sirve para encapsular todos los datos relacionados con 
    la creacion de vehículos
*/  
namespace App\Models\DTO;

use JsonSerializable;


class VehiculosDTO implements JsonSerializable{

    private $marca;
    private $modelo;
    private $kilometros;
    private $year;
    private $clase;
    private $disponible;
    private $prestado;
    private $fecha_inicio;
    private $fecha_fin;
    private $usuario_id;
    private $revision;
    private $id;
    private $cuatro_por_cuatro;
    private $electrico;
    private $capacidad;

    // las propiedades se establecen a partir de un array asociativo
    public function __construct($datos)
    {
            $this->marca = $datos->marca;
            $this->modelo = $datos->modelo;
            $this->kilometros = $datos->kilometros;
            $this->year = $datos->year;
            $this->clase = $datos->clase;
            $this->disponible = $datos->disponible;
            $this->prestado = $datos->prestado;
            $this->fecha_inicio = $datos->fecha_inicio;
            $this->fecha_fin = $datos->fecha_fin;
            $this->usuario_id = $datos->usuario_id;
            $this->revision = $datos->revision;
            $this->id = $datos->id;
            $this->cuatro_por_cuatro = $datos->cuatro_por_cuatro;
            $this->electrico = $datos->electrico;
            $this->capacidad = $datos->capacidad;
    }
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
    public function toArray(): array {
        return [
            'marca' => $this->marca,
            'modelo'=>$this->modelo,
            'kilometros'=>$this->kilometros,
            'year'=>$this->year,
            'clase'=>$this->clase,
            'disponible'=>$this->disponible,
            'prestado'=>$this->prestado,
            'fecha_inicio'=>$this->fecha_inicio,
            'fecha_fin'=>$this->fecha_fin,
            'usuario_id'=>$this->usuario_id,
            'revision'=>$this->revision,
            'id'=>$this->id,
            'electrico'=>$this->electrico,
            'cuatro_por_cuatro'=>$this->cuatro_por_cuatro,
            'capacidad'=>$this->capacidad
        ];
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
     * Get the value of kilometros
     */
    public function getKilometros()
    {
        return $this->kilometros;
    }    
    /**
     * Get the value of year
     */
    public function getYear()
    {
        return $this->year;
    }    
    /**
     * Get the value of clase
     */
    public function getClase()
    {
        return $this->clase;
    }
    /**
      * Get the value of disponible
    */
    public function getDisponible()
    {
        return $this->disponible;
    }
    /**
     * Get the value of prestado
     */
    public function getPrestado()
    {
        return $this->prestado;
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
     * Get the value of usuario_id
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    /**
     * Get the value of revision
     */
    public function getRevision()
    {
        return $this->revision;
    }
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get the value of cuatro_por_cuatro
     */
    public function getCuatroPorCuatro()
    {
        return $this->cuatro_por_cuatro;
    }
    /**
     * Get the value of electrico
     */
    public function getElectrico()
    {
        return $this->electrico;
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