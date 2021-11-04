<?php
namespace App;

class Vendedor extends ActiveRecord{

    protected static $tabla = 'vendedores';
    protected static $columnasDb = ['id', 'nombre', 'apellido', 'telefono'];

    //constructor
    public function __construct( $args = [] ){
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
    
    //Validacion
    public function validar(){
        // Validar los datos antes de guardarlos en la base de datos
        if(!$this->nombre){
            self::$errores[] = 'El nombre es obligatorio';
        }

        if(!$this->apellido){
            self::$errores[] = 'El apellido es obligatorio';
        }

        if(!preg_match('/[0-9]{10}/', $this->telefono)){
            self::$errores[] = 'El numero de telefono no es valido';
        }

        return self::$errores;
    }
}