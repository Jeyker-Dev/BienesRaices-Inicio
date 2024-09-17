<?php

namespace App;

class ActiveRecord
{
        //  Database
        protected static $database;
        protected static $columnasDb = [];
        protected static $tabla = '';

        // Errors
        protected static $errores = [];

    // Database Connection
    public static function setDB($arg_database)
    {
        self::$database = $arg_database;
    }   // Here End Function

    // Save in Database
    public function crear()
    {
          // Sanitize Data Input
        $atributos = $this-> sanitizarDatos();

        // Insert In Database
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query.= join(', ',array_keys($atributos) );
        $query .= " ) VALUES (' ";
        $query.=  join("', '",array_values($atributos) );
        $query .= " ') ";

        $resultado = self::$database -> query($query);

          // Redirect To Index Page and Return Message
        if($resultado)
        {
            header('Location: /admin/?resultado=1');
        }   // Here End If
    }   // Here End Function

    public function guardar()
    {
        if( !is_null( $this->id ) )
        {
            // Update Data
            $this->actualizar();

        }   // Here End If
        else
        {
            // Create a New Data
            $this->crear();
        }   // Here End Else
    }   // Here End Function

    // Update Data in Database
    public function actualizar()
    {
        // Sanitize Data Input
        $atributos = $this-> sanitizarDatos();

        $valores = [];

        foreach ($atributos as $key => $value) 
        {
            $valores[] = "{$key}='{$value}'";
        }   // Here End Foreach

        $query = " UPDATE " . static::$tabla . " SET ";
        $query.= join(', ', $valores);
        $query.= " WHERE id ='" .  self::$database->escape_string( $this->id ) . "' ";
        $query.= " LIMIT 1 ";

        $resultado = self::$database -> query($query);

        return $resultado;
    }   // Here End Function

    // List al the Attributes
    public function atributos()
    {
        $atributos = [];
        foreach(static::$columnasDb as $columna)
        {
            // Ignore The Column of Id
            if($columna === 'id') continue;
            $atributos[$columna] = $this-> $columna;
        }   // Here End Foreach

        return $atributos;

    }   // Here End Function

    // Sanitize all the Data
    public function sanitizarDatos()
    {
        $atributos = $this-> atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value)
        {
            $sanitizado[$key] = self::$database->escape_string($value);
        }   // Here End Foreach

        return $sanitizado;
    }   // Here End Function

    public function setImagen($imagen)
    {
        // Check If We Have an Id
        if(!is_null( $this->id ) )
        {
            $this->borrarImagen();
        }   // Here End If

        // Assign the image to the image attribute
        if($imagen)
        {
            $this->imagen = $imagen;
        }   // Here End Imagen

    }   // Here End Function

    // Delete Image From Disk
    public function borrarImagen()
    {
        // Check If Image Exists
        $existeArchivo = file_exists( CARPETA_IMAGENES . $this->imagen );
        if( $existeArchivo )
        {
            // Delete Image
            unlink( CARPETA_IMAGENES .  $this->imagen );
        }   // Here End If

    }   // Here End Function

    // Returns Errors
    public static function getErrores() 
    {    
    return self::$errores;
    }   // Here End Function

    // Validate Inputs
    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }   // Here End Function

    // Consult to Get al the Properties
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }   // Here End Function

    public static function get( $cantidad )
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }   // Here End Function

    // Consult to Database
    public static function consultarSQL($query)
    {
        // Consult Database
        $resultado = self::$database->query($query);

       // Repeated Results
        $array = [];

        while($registro = $resultado-> fetch_assoc() ) 
        {
            $array[] = static::crearObjeto($registro);
        }   // Here End While

       // Free memory
        $resultado->free();

       // Return Results
        return $array;

    }   // Here End Function

    // Creat a Object
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach($registro as $key => $value)
        {
            if( property_exists( $objeto, $key ) )
            {
                $objeto -> $key = $value;
            }   // Here End If

        }   // Here End Foreach

        return $objeto;

    }   // Here End Function

    // Look for a record for your ID
    public static function find($id)
    {
         // Get Data From Propiedad
        $consulta = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL( $consulta );
        return array_shift( $resultado );
    }   // Here End Function

    // Synchronizes the object in memory with the changes made by the user
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value)
        {
            if(property_exists($this, $key) && is_null($value) )
            {
                $this->$key = $value;
            }   // Here End If
        }   // Here End Foreach

    }   // Here End Function

    public function eliminar()
    {
          // Delete A Data from table
        $query = "DELETE FROM " . static::$tabla . "
         WHERE id = " . self::$database->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$database->query($query);

        if($resultado)
        {
            $this->borrarImagen();
            header('Location: /admin/?resultado=3');
        }
    }   // Here End Function
}   // Here End Class

?>