<?php

class Modelo {

    /**
     * Crea conexión con la base de datos.
     * 
     * @param string $servidor Nombre del servidor.
     * @param string $base_de_datos Nombre de la base de datos.
     * @param string $usuario Nombre del usuario de la base de datos.
     * @param string $contraseña la contraseña de la base de datos.
     * @return mysqli|null La conexión a la base de datos o en caso de error null.
     */
    public function conexion($servidor, $base_de_datos, $usuario, $contrasena) {
        try {
            $mysqli = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);
        } catch (mysqli_sql_exception $e) {
            error_log($e->__toString());
            return null;
         }
        return $mysqli;
    }

    /**
     * Consulta los datos de los entrenamientos de los últimos 7 dias de la semana.
     * 
     * @param mysqli $conexion La conexión con la base de datos.
     * @param int usuario_id El ID del usuario.
     * @return array|null Devuelve los datos de entrenamiento o null en caso de error.
     */
    public function consultarDatosEntrenamientoUltimos7Dias($conexion,$usuario_id) {
        $fecha_inicio = date('Y-m-d', strtotime('monday this week'));
        $fecha_fin = date('Y-m-d', strtotime('sunday this week'));
        $sql = "SELECT fecha, IF(COUNT(*) > 0, 1, 0) as entrenado 
                FROM entrenamiento 
                WHERE usuario_id = ? AND fecha BETWEEN ? AND ? 
                GROUP BY fecha";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iss", $usuario_id,$fecha_inicio,$fecha_fin);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado === false) {
            return null;
        }
        
        $datos_entrenamiento = [];
        while ($fila = $resultado->fetch_object()) {
            $datos_entrenamiento[] = $fila;
        }
        
        $resultado->close();
        return $datos_entrenamiento;
    }
    
    /**
     * Consulta los días en los que se ha registrado al menos un entrenamiento.
     * 
     * @param mysqli $conexion La conexión con la base de datos.
     * @param int usuario_id El ID del usuario.
     * @return array|null Devuelve los dias en los que se ha entrenado o null en caso de error.
     */
    public function consultarDiasEntrenados($conexion,$usuario_id) {
        $sql = "SELECT DISTINCT fecha FROM entrenamiento WHERE usuario_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado === false) {
            return null;
        }
        
        $dias_entrenados = [];
        while ($fila = $resultado->fetch_object()) {
            $dias_entrenados[] = $fila;
        }
        
        $resultado->close();
        return $dias_entrenados;
    }

    /**
     * Consulta los ejercicios que coinciden con la búsqueda.
     * 
     * @param mysqli $con La conexión con la base de datos.
     * @param string $busqueda La cadena de la búsqueda.
     * @return array|null Devuelve los ejercicios encontrados o null en caso de error.
     */
    public function consultarEjercicios($con, $busqueda) {
        try {
            $query = "SELECT entrenamiento.ejercicio_id, ejercicios.nombre_ejercicio, entrenamiento.peso FROM entrenamiento 
                      INNER JOIN ejercicios ON entrenamiento.ejercicio_id = ejercicios.id
                      WHERE ejercicios.nombre_ejercicio LIKE '%$busqueda%'";
            $resultado = $con->query($query);
            $ejercicio = [];
            
            while($ejercicios = $resultado->fetch_object()){
                $ejercicio[] = $ejercicios;
            }     
            
            return $ejercicio;
        } catch (mysqli_sql_exception $e) {
            return null;
        }
    }

    /**
     * Consulta todos los datos del Entrenamiento
     * 
     * @param mysqli $con La conexión con la base de datos.
     * @return array|null Devuelve todos los datos del entrenamiento o null en caso de error.
     */
    public function consultarDatosEntrenamiento($con) {
        try {
            $query = "SELECT * FROM entrenamiento";
            $resultado = $con->query($query);
            $datos = array();
            while ($fila = $resultado -> fetch_object()){
                $fila -> fecha = date('d/m/Y', strtotime($fila -> fecha));
                $datos[] = $fila;
            }
            return $datos;
        } catch (mysqli_sql_exception $e) {
            error_log($e->__toString());
            return null;
        }
    }

    /**
     * Consulta el nombre de un ejercicio dado su ID.
     * 
     * @param mysqli $conexion La conexión con la base de datos.
     * @param int ejercicio_id El ID del ejercicio.
     * @return array|null Devuelve nombre de ejercicio o null en caso de error.
     */
    public function consultarNombreEjercicio($conexion, $ejercicio_id) {
        try {
            $sql = "SELECT nombre_ejercicio FROM ejercicios WHERE id = ?";
            $consulta = $conexion->prepare($sql);
            $consulta->bind_param("i", $ejercicio_id);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $fila = $resultado->fetch_assoc();
            $nombre_ejercicio = $fila['nombre_ejercicio'];
            $consulta->close();
            return $nombre_ejercicio;
        } catch (mysqli_sql_exception $e) {
            error_log($e->__toString());
            return null;
        }
    }    
   
    /**
     * Consulta los datos de entrenamiento ordenados según el criterio seleccionado.
     * 
     * @param mysqli $conexion La conexión con la base de datos.
     * @param string $orden El criterio de ordenación
     * @return array|null Los datos de entrenamiento ordenados o null en caso de error.
     */
    public function consultarDatosEntrenamientoOrdenado($conexion, $orden) { 
        $sql = "SELECT * FROM entrenamiento ORDER BY ";
        switch ($orden) {
            case 'dia_asc':
                $sql .= "fecha ASC";
                break;
            case 'dia_desc':
                $sql .= "fecha DESC";
                break;
            case 'opciones_asc':
                $sql .= "ejercicio_id ASC";
                break;
            case 'opciones_desc':
                $sql .= "ejercicio_id DESC";
                break;
                case 'peso_asc':
                $sql .= "peso ASC";
                break;
            case 'peso_desc':
                $sql .= "peso DESC";
                break;
            default:
            
            return $this->consultarDatosEntrenamiento($conexion);
            }
            
        $resultado = $conexion->query($sql);
        if ($resultado === false) {
            
            return null;
        }
            
        $entrenamiento = [];
        while ($fila = $resultado->fetch_object()) {
            $entrenamiento[] = $fila;
        }
            
        $resultado->close();  
        return $entrenamiento;
    }
    
    /**
     * Borra un ejercicio de la base de datos conforme a su ID.
     * 
     * @param mysqli $con La conexión con la base de datos.
     * @param int $id El ID del ejercicio a borrar
     * @return bool True si el ejercicio fue borrado exitosamente, false en caso contrario.
     */
    public function borrarEjercicio($con, $id){
        try{
            $query = "DELETE FROM entrenamiento WHERE id='$id'";
            $resultado = $con->query($query);
            
            if ($resultado === false) {
                throw new Exception("Error al eliminar ejercicio: " . $con->error);
            }
            return true;
        }catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    /**
     * Guarda los datos de contacto en la base de datos.
     * 
     * @param int $usuario_id ID del usuario.
     * @param string $nombre_usuario Nombre del usuario.
     * @param string $correo Correo electrónico del usuario.
     * @param string $asunto Asunto del mensaje.
     * @param string $mensaje Mensaje del usuario.
     * @return bool True en caso de éxito, false en caso de error.
     */
    public function guardarContacto($conexion, $usuario_id, $nombre_usuario, $correo, $asunto, $mensaje) {
        $sql = "INSERT INTO contacto (usuario_id, nombre_usuario, correo_electronico, asunto, mensaje) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issss", $usuario_id, $nombre_usuario, $correo, $asunto, $mensaje);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>