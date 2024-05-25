<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>

<?php
    include 'modelo.php';

    if (isset($_SESSION["id"])) {
        $sessionId = $_SESSION["id"];
        $modelo = new Modelo();
        $conexion = $modelo->conexion("localhost", "fittrack", "root", "");
        if ($conexion !== null) {
            if (isset($_POST['eliminar'])) {
                $id_eliminar = $_POST['id_eliminar'];
                if ($id_eliminar) {
                    $exito = $modelo->borrarEjercicio($conexion, $id_eliminar);
                    if ($exito) {
                        echo "<p style='padding:20px; margin:10px; border-radius:10px; border:1px solid green; background-color:#9EF7A1;'>Se eliminó el ejercicio exitosamente.</p>";
                    } else {
                        echo "<p style='padding:20px; margin:10px; border-radius:10px; border:1px solid green; background-color:#F79E9E;'>Error al eliminar el ejercicio. Por favor, inténtelo de nuevo.</p>";
                    }
                }
            }
            if (isset($_POST['ordenar'])) {
                $orden = $_POST['orden'];
                $entrenamiento = $modelo->consultarDatosEntrenamientoOrdenado($conexion, $orden);
            } else {
                $entrenamiento = $modelo->consultarDatosEntrenamiento($conexion);
            }
            if ($entrenamiento !== null) {
                echo "<h2>Historial de entrenamientos:</h2>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='ordenar'>";
                echo "<label for='orden'>Ordenar por:</label>";
                echo "<select name='orden' id='orden'>";
                echo "<option value='dia_asc'>Día Ascendente</option>";
                echo "<option value='dia_desc'>Día Descendente</option>";
                echo "<option value='opciones_asc'>Ejercicio Ascendente</option>";
                echo "<option value='opciones_desc'>Ejercicio Descendente</option>";
                echo "<option value='peso_asc'>Peso Ascendente</option>";
                echo "<option value='peso_desc'>Peso Descendente</option>";
                echo "</select>";
                echo "<button type='submit'>Ordenar</button>";
                echo "</form>";
                echo "</br><table>";
                echo "<tr><th>Día</th><th>Ejercicio</th><th>Series</th><th>Repeticiones</th><th>Peso (kg)</th><th>Eliminar</th></tr>";

                foreach ($entrenamiento as $dato) {
                    if ($dato->usuario_id == $sessionId) { 
                        // Obtener el nombre del ejercicio correspondiente al ejercicio_id
                        $nombre_ejercicio = $modelo->consultarNombreEjercicio($conexion, $dato->ejercicio_id);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($dato->fecha) . "</td>";
                        echo "<td>" . htmlspecialchars(strtoupper($nombre_ejercicio)) . "</td>";
                        echo "<td>" . htmlspecialchars($dato->series) . "</td>";
                        echo "<td>" . htmlspecialchars($dato->repeticiones) . "</td>";
                        echo "<td>" . htmlspecialchars($dato->peso) . "</td>";
                        echo "<td><form method='post'><input type='hidden' name='id_eliminar' value='" . htmlspecialchars($dato->id) . "'><button id='botonEliminar' type='submit' name='eliminar'>X</button></form></td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";  
            } else {
                echo "No hay entrenamientos";
            }
        }
    $conexion->close();
    }
?>

<?php endblock() ?>
