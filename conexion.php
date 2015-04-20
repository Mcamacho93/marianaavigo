<?php

class MYSQLIfunctions{

    /*private $conexion;
    private $server = 'localhost';
    private $usuario = 'root';
    private $contrasena = 'root';
    private $base = 'casalaietana';*/


/*
    private $conexion;
    private $server = 'localhost';
    private $usuario = 'root';
    private $contrasena = 'arturo1234';
    private $base = 'casalaietana';*/


/*
    private $conexion;
    private $server = 'localhost';
    private $usuario = 'root';
    private $contrasena = 'mcamacho';
    private $base = 'casalaietana';
*/

    private $conexion;
    private $server = 'localhost';
    private $usuario = 'lomas_mike';
    private $contrasena = 'lomas4529aeie';
    private $base = 'lomas_casalaietana';

    public function __construct(){
        $this->conexion = mysqli_connect($this->server, $this->usuario, $this->contrasena, $this->base) or die("Error: ".mysqli_errno($this->conexion));
    }

    public function __destruct(){
        mysqli_close($this->conexion);
    }

    public function query($consulta){
        $resultado = mysqli_query($this->conexion, $consulta);

        if(!$resultado){
             echo "Error: ".mysqli_errno($this->conexion);
        }
        return $resultado;
    }

    public function rows($consulta){
        return mysqli_num_rows($consulta);
    }

    public function farray($consulta){
        return mysqli_fetch_array($consulta);
    }

    public function fassoc($consulta){
        return mysqli_fetch_assoc($consulta);
    }

    public function lastid(){
        return mysqli_insert_id($this->conexion);
    }

    public function escapestr($str){
        return mysqli_real_escape_string($this->conexion, $str);
    }

}
?>
