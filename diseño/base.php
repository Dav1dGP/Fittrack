<?php 
require_once 'ti.php';

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_destroy(); 
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: 'Roboto', Arial, sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            h1{
                font-size: 3em;
                font-weight:900;
            }

            .parrafos{
                text-align:justify;
            }

            header {
                font-family: 'Roboto Condensed', Arial, sans-serif;
                background-color: #222;
                color: #fff;
                text-align: center;
                padding: 10px 20px;
            }
            
            nav {
                font-family: 'Roboto Condensed', Arial, sans-serif;
                font-size: 16px;
                background-color: #333;
                padding: 10px;
                text-align: center;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                
            }

            nav a {  
                color: #fff;
                text-decoration: none;
                padding: 10px 20px;
                margin: 2px;
                transition: background-color 0.3s ease;
                border-radius:5%;
                
            }

            nav a:hover {
                background-color: #444;
                border-radius:5%;
            }

            nav #inicio { 
                background-color: #075dc6;
                color: #fff;

            }

            section {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 5px;
            }

            section section {
                width: 70%;
                background-color: #075dc6;
                text-align: center;
                cursor: pointer;
                color: #fff;
                margin-bottom: 20px;
                padding: 20px;
                transition: background-color 0.3s ease;
                border-radius: 10px;
            }

            section section:hover {
                background-color: #397DD1;
            }

            .user {
                font-family: 'Roboto', Arial, sans-serif;
                color: #fff;
                background-color: #222;
                padding: 10px;
                position: absolute;
                top: 20px;
                right: 20px;
            }

            #cerrar {
                background-color: #E9E9E9; 
                color: black;
                font-family: 'Roboto', Arial, sans-serif;
                cursor: pointer;
                display: none;
                padding: 5px 10px;
                border: none;
                border-radius: 3px;
            }

            .user:hover #cerrar {
                display: inline-block;
            }

            #cerrar:hover {
                background-color: white;
            }

            #btn-añadir, #botonEliminar {
                color: #fff;
                cursor: pointer;
                font-weight: bold; 
                font-size: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
                padding: 10px;
                text-align: center;
                margin: 10px 0;
                width: calc(50% - 20px);
                box-sizing: border-box;
            }

            #btn-añadir {
                background-color: #075dc6;
            }

            #btn-añadir:hover {
                background-color: #397DD1;
            }

            #botonEliminar {
                background-color: rgba(195, 0, 0, 1);
                height:40px;
                width: 40px;
            }

            #botonEliminar:hover {
                background-color: red;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            table, th, td {
                border: 1px solid black;
            }

            th, td {
                padding: 8px;
                text-align: center;
            }

            th {
                background-color: #f2f2f2;
            }

            .tipoSeleccionado {
                color: red;
            }

            .mensaje {
                font-size: smaller; 
                color: red; 
            }

            footer {
                margin-top: 20px;
                text-align: center;
                font-family: 'Roboto', Arial, sans-serif;  
                background-color: #000;
                padding: 10px;
                color: #a2a2a2;
            }

            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            input[type="date"],
            input[type="number"],
            select {
                width: 100%;
                padding: 8px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 3px;
                box-sizing: border-box;
            }

            input[type="email"],
            input[type="text"],
            textarea {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            textarea {
                height: 150px; 
            }

            input[type="submit"] {
                width: 100%;
                padding: 10px;
                background-color: #075dc6;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }

            input[type="submit"]:hover {
                background-color: #397DD1;
            }

            .ejercicio {
                border: 1px solid #ccc;
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 5px;
            }

            .ejercicio label {
                display: inline-block;
                width: 120px;
                margin-bottom: 5px;
            }

            .ejercicio input[type="number"],
            .ejercicio select {
                width: calc(100% - 130px);
            }

            .ejercicio button {
                margin-top: 10px;
                background-color: #555;
                color: #fff;
                border: none;
                padding: 8px 16px;
                border-radius: 3px;
                cursor: pointer;
            }

            .ejercicio button:hover {
                background-color: #333;
            }

            button{
                border-radius: 5px;
            }

            button:hover{
                background-color: #333;
                color: #fff;
            }

            input[type="button"] {
                display: block;
                margin: 0 auto;
                background-color: #555;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 3px;
                cursor: pointer;
            }

            input[type="button"]:hover {
                background-color: #333;
            }

            #volverAtras {
                margin-top: 20px;
            }

            #cerrar {
                background-color:rgba(195, 0, 0, 1);
                color:#fff;
            }

            #cerrar:hover{
                background-color:red;
                color:#fff;
            }

            #botonLimpiar, #botonAgregar, #botonQuitar {
                display: block;
                margin: 0 auto;
                background-color: #555;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 3px;
                cursor: pointer;
            }

            #botonLimpiar:hover, #botonAgregar:hover, #botonQuitar:hover {
                background-color: #333;
            }

            @media screen and (max-width: 600px) {
                nav {
                    flex-direction: column;
                }

                nav a {
                    margin: 5px 0;
                    padding: 10px 0; 
                }

                .user {
                    top: 60px;
                    right: 10px;
                }

                #btn-añadir, #botonEliminar {
                    width: 100%;
                }

                table {
                    font-size: 12px; 
                    width: 100%;   
                }

                th, td {
                    padding: 0;  
                }

                .ejercicio label {
                    width: 100%; 
                }

                .ejercicio input[type="number"],
                .ejercicio select {
                    width: 100%; 
                }

                input[type="button"],
                #botonLimpiar,
                #botonAgregar,
                #botonQuitar {
                    width: 100%; 
                }

                section {
                    margin: 10px auto;
                    padding: 10px; 
                    width: 90%;
                }

                section section {
                    padding: 10px; 
                    margin-bottom: 10px; 
                    width: 100%; 
                    box-sizing: border-box;
                }

                #texto {
                    margin:2px;
                }
            }

        </style>
    </head>
    <body>
        <header>
            <h1>FITTRACK</h1>  
        </header>
        <div class="user">
            <?php echo "User: " . $_SESSION['usuario'] ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <button id="cerrar" type="submit" name="logout">Cerrar sesión</button>
            </form>
        </div>
        <nav>
            <a id="inicio" href="sesion.php">Inicio</a>
            <a href="entrenamiento.php">Entrenamiento</a>
            <a href="historial.php">Historial</a>
            <a href="analisis.php">Análisis</a>
            <a href="sugerencias.php">Sugerencias</a>        
        </nav>        
        <section>
            <?php startblock('contenido'); ?> <?php endblock() ?>
        </section>
        <footer>
            <?php startblock('pie'); ?>
            <p>© 2024 DAVID GASPAR PÉREZ.</p>
            <?php endblock() ?>
        </footer> 
    </body>
</html>
