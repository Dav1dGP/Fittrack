<?php

    session_start();
    require_once "conexion.php"; 
    
    if(isset($_SESSION["usuario"])){
        header("Location: sesion.php");
        exit;
    } 

    $mensajeError = "";
    $claseUsuario = ""; 
    $claseContraseña = ""; 

    if($_POST){
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];

        $consulta = "SELECT * FROM Usuarios WHERE nombre = '$usuario' AND password = '$contraseña'";
        $resultado = mysqli_query($conexion, $consulta);
        if(mysqli_num_rows($resultado) == 1){ 
            $fila = mysqli_fetch_assoc($resultado);
            $_SESSION["usuario"] = $usuario;
            $_SESSION["tipo_usuario"] = $fila["tipo_usuario"]; 
            $_SESSION["id"] = $fila["id"]; 
            header("Location: sesion.php");
            exit;
        }
        else{
            $mensajeError = "Usuario o contraseña incorrectos.";    
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTrack</title>
    <style>
    
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-family: Roboto condensed, arial;
            font-size: 48px;
        }

        h3{
            font-family: Roboto condensed, Arial;  
        }

        p{
            font-family: helvetica;   
        }

        input[type="text"],
        input[type="password"],
        button {
            width: 93%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: crimson;
            color: #fff;
            cursor: pointer;
            font-family: Roboto condensed, arial;  
            width: 100%;
            border-radius:5px;
        }

        button:hover {
            background-color: red;
        }

        .error-label {
            color: red;
            font-family: helvetica;
            font-size: 12px;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-family: Roboto, Arial;  
            background-color: #000000;
            padding: 10px;
            color: #a2a2a2;
            bottom: 0;
            width: 100%;
            position: fixed;
        }


    </style>
</head>
<body>
    <div class="container">
        <h1>FITTRACK</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <h3>INICIAR SESIÓN</h3>
            <hr>
            <div id="usuario-contenedor">
                <label for="usuario">Usuario<span style="color: red;">*</span>:</label>
                <input type="text" name="usuario" id="usuario" >
            </div>
            <div id="contraseña-contenedor">
                <label for="contraseña">Contraseña<span style="color: red;">*</span>:</label>
                <input type="password" name="contraseña" id="contraseña" >
            </div>
            <label for="error" class="error-label"><?= $mensajeError; ?></label>
            <div>
                <br>
                <button type="submit" name="login">Iniciar Sesión</button>
            </div>
        </form>
    </div>
    <footer>         
        <p>© 2024 DAVID GASPAR PÉREZ.</p>        
    </footer>
</body>
</html>