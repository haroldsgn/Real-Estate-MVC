<?php

namespace Model;

class ActiveRecord
{
    //BD
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];


    //Definir la conexion a la BD
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        if (!is_null($this->id)) {
            // Actualizar
            $this->actualizar();
        } else {
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarDatos();
        //join()→Crear un string a partir de un arreglo
        //Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla .  " ( ";
        $query .= join(", ", array_keys($atributos));
        $query .= " ) Values (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        //Mensaje de exito o error
        if ($resultado) {
            //Redireccionar al usuario
            header("Location: /admin?resultado=1");
        }
    }

    public function actualizar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarDatos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $query = " UPDATE " .  static::$tabla  . " SET ";
        $query .= join(',', $valores);
        $query .= "WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            //Redireccionar al usuario
            header("Location: /admin?resultado=2");
        }
    }
    // Eliminar una propiedad
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla .  " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header("location: /admin?resultado=3");
        }
    }



    // Identificar y unir atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna == "id") continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarDatos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];


        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImage($imagen)
    {
        // Elimina la imagen previa
        if (!is_null($this->id)) {
            // Comprobar si existe el archivo
            $this->borrarImagen();
        }

        // Asignar al atributo de Imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    // Elimina el archivo
    public function borrarImagen()
    {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validacion
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    //Lista de todas las propiedades
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtiene determinado num de propiedades
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca una propiedad x su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id} ";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // Consultar DB
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    // Sincronizar el obj en memoria con los cambios realizados por el user
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value))
                $this->$key = $value;
        }
    }
}
