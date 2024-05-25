<?php

session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fittrack";

try{
    $usuario_id = $_SESSION["id"];
    //var_dump($usuario_id);
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        throw new Exception('Error en los datos');
    }
    
    // Obtener los datos enviados desde la vista
    $data = json_decode(file_get_contents("php://input"), true);
    
    if(json_last_error()!== JSON_ERROR_NONE){
        throw new Exception('Error en los datos JSON');
    }
    if(!isset($data['ejercicios']) || !isset($data['dia'])){
        throw new Exception('Estructura de datos incorrecta');
    }
    /* var_dump($data);
    die(); */

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception('Error en la conexión');
    }
    
    $sql = "INSERT INTO entrenamiento (ejercicio_id, repeticiones, series, peso, fecha, usuario_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if($stmt === false){
        throw new Exception('Error en la preparación de la consulta');
    }
    
    $stmt->bind_param("ssssss", $ejercicio_id, $repeticiones, $series, $peso, $fecha, $usuario_id);
    foreach ($data['ejercicios'] as $ejercicio) {
        
        if (!is_array($ejercicio)){
            throw new Exception('Estructura de datos incorrecta');
        }
        if(!isset($ejercicio['repeticiones']) || !isset($ejercicio['series']) || !isset($ejercicio['peso']) ){
            throw new Exception('Faltan datos en el ejercicio');
        }
        
        $repeticiones = $ejercicio['repeticiones'];
        $series = $ejercicio['series'];
        $peso = $ejercicio['peso'];
        $fecha = $data['dia'];
        
        // Obtener el ID del ejercicio según su nombre
        $nombre_ejercicio = $ejercicio['ejercicio'];
        $sql_ejercicio_id = "SELECT id FROM ejercicios WHERE nombre_ejercicio = ?";
        $stmt_ejercicio_id = $conn->prepare($sql_ejercicio_id);
        
        if($stmt_ejercicio_id === false){
            throw new Exception('Error en la preparación de la consulta');
        }
        
        $stmt_ejercicio_id->bind_param("s", $nombre_ejercicio);
        $stmt_ejercicio_id->execute();
        $result = $stmt_ejercicio_id->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ejercicio_id = $row['id'];
            
            if (!$stmt->execute()) {
                throw new Exception('Error al guardar los datos ' . $stmt->error);
            }
        } else {
                throw new Exception('Error al encontrar ejercicio ' . $nombre_ejercicio);
        }
    }

    // Si todas las inserciones fueron exitosas, enviar una respuesta con éxito
    echo json_encode(['exito' => true]);
    
    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
}


catch(Exception $e){
    echo json_encode(['message' => $e->getMessage()]);
}

?>
