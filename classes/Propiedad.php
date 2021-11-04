<?php
declare(strict_types=1);
namespace App;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDb = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    //constructor
    public function __construct( $args = [] ){
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y-m-d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    //Validacion
    public function validar(){
        // Validar los datos antes de guardarlos en la base de datos
        if(!$this->titulo){
            self::$errores[] = 'El titulo es obligatorio';
        }

        if(!$this->precio){
            self::$errores[] = 'El precio es obligatorio';
        }

        if(strlen($this->descripcion) < 50){
            self::$errores[] = 'La descripcion es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$this->habitaciones){
            self::$errores[] = 'El numero de habitaciones es obligatorio';
        }

        if(!$this->wc){
            self::$errores[] = 'El numero de baños es obligatorio';
        }

        if(!$this->estacionamiento){
            self::$errores[] = 'El numero de estacionamientos es obligatorio';
        }

        if(!$this->vendedorId){
            self::$errores[] = 'Seleccione un Vendedor';
        }

        if(!$this->imagen){
            self::$errores[] = 'La imagen es obligatoria';
        }

        // // Validar el tamaño de la imagen
        // if($this->imagen['size'] > 2000000){
        //     self::$errores[] = 'La imagen debe pesar menos de 2MB';
        // }

        //obtener extension de la imagen para validarla
        $ext = pathinfo($this->imagen, PATHINFO_EXTENSION);
        if( $ext !== 'jpg' &&  $ext !== 'png' ){
            self::$errores[] = 'La imagen debe ser formato jpg o png';
        }

        return self::$errores;
    }

}