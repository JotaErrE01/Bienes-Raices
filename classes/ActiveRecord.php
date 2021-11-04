<?php 

namespace App;

abstract class ActiveRecord {

    protected static $db;
    protected static $columnasDb = [];
    
    protected static $tabla = '';

    protected static $errores = [];

    // Conectar la base de datos
    public static function setDb( $database ){
        self::$db = $database;
    }

    //subida de archivos
    public function setImagen( $imagen ){
        $this->deleteImagen();
        //asignar el nuevo nombre de la imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    // Elimina el archivo
    public function deleteImagen(){
        if($this->imagen){
            $imagenVieja = CARPETA_IMAGENES . $this->imagen;
            //coprobar si existe el archivo
            if(file_exists( $imagenVieja )){
                // eliminar la imagen vieja
                unlink( $imagenVieja );
            };
        };
    }

    // Funcion para sanitizar los datos
    protected function sanitizarAtributos(){
        $atributos = (array) $this;
        $sanitizedAttributes = [];       

        // recorrer los valores y sanitizarlos
        foreach($atributos as $columna => $valor){
            if($columna === 'id') continue;
            $sanitizedAttributes[$columna] = self::$db->escape_string($valor);
        }

        return $sanitizedAttributes;
    }

    //Consultar propiedades
    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;
        $resultados = self::$db->query($query);
        $consultas = [];
        if($resultados){
            while($resultado = $resultados->fetch_object()){
                $consultas[] = new static( (array) $resultado);
            }
        }
        return $consultas;
    }

    //obtener un determinado numero de registros
    public static function get( $cantidad ){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$cantidad};";
        $resultados = self::$db->query($query);
        $consultas = [];
        if($resultados){
            while($resultado = $resultados->fetch_object()){
                $consultas[] = new static( (array) $resultado);
            }
        }
        return $consultas;
    }

    //Consultar por id una tabla
    public static function find( $id ){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id} LIMIT 1;";
        $resultado = self::$db->query($query);
        $consulta = null;
        
        if($resultado->num_rows == 1){
            $consulta = $resultado->fetch_object();
            $consulta = new static( (array) $consulta );
        }

        return $consulta;
    }

    //Guardar en la base de datos
    public function guardar(){
        //Sanitizar los datos
        $sanitizados = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( " . join(', ', array_keys( $sanitizados )) . " ) VALUES ( ' ".
        join("', '", array_values( $sanitizados )) ." ');";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    public function actualizar(){
        //Sanitizar los datos
        $sanitizados = $this->sanitizarAtributos();

        // Actualizar en la base de datos
        foreach($sanitizados as $columna => $valor){
            $valores[] = "{$columna} = '{$valor}'";
        }

        // actualizar en la base de datos
        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1;";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    // Eliminar propiedad
    public function delete(){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1;";
        $resultado = self::$db->query($query);
        if($resultado){
            $this->deleteImagen();
            header('location: ' . '/admin?resultado=3');
        }
    }

    // funcion para obtener los errores
    public static function getErrores(){
        return static::$errores;
    }
    
    // Sincronizar el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($datos){
        foreach($datos as $key => $value){
            if( property_exists( $this, $key ) ){
                $this->$key = $value;
            }
        }
    }
    
    // Metodos abstractos
    public abstract function validar();
}