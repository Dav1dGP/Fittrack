<?php

require("modelo.php");

$servidor = 'localhost';
$usuario = 'root';
$contrasena = '';
$basedatos = 'fittrack';

function get_listado_ejercicios($busqueda){
    global $servidor, $usuario, $contrasena, $basedatos;
    $modelos = new Modelo();
    $con = $modelos -> conexion($servidor, $basedatos, $usuario, $contrasena);
    //var_dump($busqueda);
    return $modelos->consultarEjercicios($con, $busqueda);
}

?>
