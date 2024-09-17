<?php

namespace App;

use JsonIncrementalParser;

class Propiedad extends ActiveRecord
{
    // Database
    protected static $columnasDb = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'creado', 'estacionamiento', 'vendedorId'];
    protected static $tabla = 'propiedades';

        // Attributes
        public $id;
        public $titulo;
        public $precio;
        public $imagen;
        public $descripcion;
        public $habitaciones;
        public $wc;
        public  $estacionamiento;
        public $creado;
        public $vendedorId;

           // Constructor
            public function __construct($args = [])
            {
                $this -> id = $args['id'] ?? null;
                $this -> titulo = $args['titulo'] ?? '';
                $this -> precio = $args['precio'] ?? '';
                $this -> imagen = $args['imagen'] ?? null;
                $this -> descripcion = $args['descripcion'] ?? '';
                $this -> habitaciones = $args['habitaciones'] ?? '';
                $this -> wc = $args['wc'] ?? '';
                $this -> estacionamiento = $args['estacionamiento'] ?? '';
                $this -> creado = date('y/m/d');
                $this -> vendedorId = $args['vendedorId'] ?? '';
           }   // Here End Construct

            // Validate al the Inputs
           public function validar()
           {
               // Validate Size
               $medida = 1000 * 1000;
       
               if($this->titulo === '')
               {
                   self::$errores[] = 'Debes Agregar un Titulo';
               }   // Here End IF
       
               if(!$this->precio)
               {
                   self::$errores[] = 'El Precio es Obligatorio';
               }   // Here End IF
       
               if(!$this->imagen)
               {
                   self::$errores[] = 'La Imagen es Obligatoria';
               }   // Here End IF
       
               if(!$this->descripcion)
               {
                   self::$errores[] = 'La Descripcion No Puede Estar Vacio y Debe Tener al Menos 50 Caracteres';
               }   // Here End IF
       
               if(!$this->habitaciones)
               {
                   self::$errores[] = 'Debe Haber un Numero de Habitaciones';
               }   // Here End IF
       
               if(!$this->wc)
               {
                   self::$errores[] = 'Debe Haber un Numero de Baños';
               }   // Here End IF
       
               if(!$this->estacionamiento)
               {
                   self::$errores[] = 'Debe Haber un Numero de Estacionamiento';
               }   // Here End IF
       
               if(!$this->vendedorId)
               {
                   self::$errores[] = 'Debe Seleccionar un Vendedor';
               }   // Here End IF
       
               return self::$errores;
       
           }   // Here End Function

}   // Here End Class

?>