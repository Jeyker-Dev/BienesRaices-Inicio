<?php

namespace App;

class Vendedores extends ActiveRecord
{
    // Database
    protected static $columnasDb = ['id', 'nombre', 'apellido', 'telefono'];
    protected static $tabla = 'vendedores';

    // Attributes
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    // Constructor
    public function __construct( $args = [] )
    {
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? null;
        $this -> apellido = $args['apellido'] ?? null;
        $this -> telefono = $args['telefono'] ?? null;
    }   // Here End Construct

    public function validar()
    {
        if( !$this->nombre )
        {
            self::$errores[] = 'Se Debe Agregar un Nombre';
        }   // Here End If

        if( !$this->apellido )
        {
            self::$errores[] = 'Se Debe Agregar un Apellido';
        }   // Here End If

        if( !$this->telefono )
        {
            self::$errores[] = 'Se Debe Agregar un Telefono';
        }   // Here End If

        if( !preg_match( '/[0-9]{11}/', $this->telefono ) )
        {
            self::$errores[] = 'Deben ir al Menos 11 Numeros en el Telefono';
        }   // Here End If

        return self::$errores;
    }   // Here End Function

}   // Here End Class


?>