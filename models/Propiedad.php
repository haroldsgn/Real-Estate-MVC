<?php

namespace Model;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ["id", "titulo", "precio", "imagen", "descripcion", "habitaciones", "wc", "parqueaderos", "creado", "vendedorId"];


    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $parqueaderos;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->titulo = $args["titulo"] ?? "";
        $this->precio = $args["precio"] ?? "";
        $this->imagen = $args["imagen"] ?? "";
        $this->descripcion = $args["descripcion"] ?? "";
        $this->habitaciones = $args["habitaciones"] ?? "";
        $this->wc = $args["wc"] ?? "";
        $this->parqueaderos = $args["parqueaderos"] ?? "";
        $this->creado = date("Y/m/d");
        $this->vendedorId = $args["vendedorId"] ?? "";
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }

        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "Debes añadir una descripción de la propiedad y debe tener al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            self::$errores[] = "El numero de baños es obligatorio";
        }

        if (!$this->parqueaderos) {
            self::$errores[] = "El número de parqueaderos es obligatorio";
        }

        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen de la propiedad es obligaoria";
        }

        return self::$errores;
    }
}
