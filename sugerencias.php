<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>
<?php

require_once 'modelo.php';

$usuario_id = $_SESSION['id'];
$nombre_usuario = $_SESSION['usuario'];
$modelo = new Modelo();
$conexion = $modelo->conexion("localhost", "fittrack", "root", "");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['correo']) && isset($_POST['asunto']) && isset($_POST['mensaje'])) {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $asunto = htmlspecialchars($_POST['asunto']);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (!empty($correo) && !empty($asunto) && !empty($mensaje)) {
        if ($modelo->guardarContacto($conexion, $usuario_id, $nombre_usuario, $correo, $asunto, $mensaje)) {
            $mensaje_exito = "Mensaje enviado correctamente.";
        } else {
            $mensaje_error = "Error al enviar el mensaje.";
        }
    } else {
        $mensaje_error = "Todos los campos son obligatorios.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Sugerencias</title>
    <script>
        function validarFormulario() {
            var correo = document.getElementById('correo').value;
            var asunto = document.getElementById('asunto').value;
            var mensaje = document.getElementById('mensaje').value;

            if (correo === "" || asunto === "" || mensaje === "") {
                alert("Todos los campos son obligatorios.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>Formulario de Sugerencias</h2>
    <?php
    if (isset($mensaje_exito)) {
        echo "<p style='padding:20px; margin:10px; border-radius:10px; border:1px solid green; background-color:#9EF7A1;'>$mensaje_exito</p>";
    }
    if (isset($mensaje_error)) {
        echo "<p style='color:red;'>$mensaje_error</p>";
    }
    ?>
    <form action="sugerencias.php" method="post" onsubmit="return validarFormulario();">
        <label for="correo">Correo Electrónico:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="asunto">Asunto:</label><br>
        <input type="text" id="asunto" name="asunto" required><br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" required></textarea><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>

<?php endblock() ?>