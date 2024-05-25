<?php

require("api.php");

// Obtenemos el parámetro GET de la URL
$q = $_REQUEST["q"];    

$sugerencias = array();

if ($q !== ""){
    // Devuelve un string con todos los caracteres alfabéticos convertidos a minúsculas.
    $q = strtolower($q);
    //Utilizar la función de la API para obtener los resultados
    $resultados = get_listado_ejercicios($q);
    if($resultados !== null && count($resultados) > 0){
        foreach ($resultados as $ejercicio){
            $sugerencias[] = $ejercicio;
        }  
    } else{
        $sugerencias[] = "No se han encontrado sugerencias"; 
    }   
    echo json_encode($sugerencias);
}

?>
