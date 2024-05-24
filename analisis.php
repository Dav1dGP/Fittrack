<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>
<?php

    if(isset($_SESSION["usuario"]) && $_SESSION["tipo_usuario"] == "PREMIUM"){

?>

<h2>Análisis:</h2>

<form action="" id="formulario" onkeyup="mostrarEjercicios()">
    <p><strong>Por favor, introduce el nombre completo de un ejercicio para que aparezca el nº de veces que lo has entrenado y la progresión del peso utilizado. </strong></p>
    <input type="text" name="texto" id="texto">
    <br>
    <div id="resultado" style="display: none; padding:10px; margin:10px; border-radius:10px; border:1px solid #DDDDDD; background-color:#F2F2F2;">
        <div id="textoResultado"></div>
        <div id="vecesEntrenado"></div> 
        <div id="pesos"></div> 
    </div>
    <br>
    <hr>
    <br>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
    function mostrarEjercicios(){
        var valor = document.getElementById("texto").value;
        var asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = cambioEstado;
        asyncRequest.open("GET", "servidor_ajax.php?q=" + valor , true);
        asyncRequest.send();

        function cambioEstado() {
            if(asyncRequest.readyState === 4 && asyncRequest.status === 200){
                var data = JSON.parse(asyncRequest.responseText);
                
                var coincidencias = data.length;
                if (coincidencias > 0) {
                    var ejercicio = data[0].nombre_ejercicio;
                    var pesos = data.map(ejercicio => ejercicio.peso + " kg").sort((a, b) => a - b).join(' ➜ ');

                    document.getElementById("textoResultado").innerHTML = `<strong><p> ${ejercicio.toUpperCase()}: <strong></p>`;
                    document.getElementById("vecesEntrenado").innerText = "Número de veces entrenado: " + coincidencias;
                    document.getElementById("pesos").innerHTML = `<p>Progreso en ${ejercicio}: ${pesos}</p>`;
                    document.getElementById("resultado").style.display = 'block';
                } else {
                    document.getElementById("resultado").style.display = 'none';
                    document.getElementById("pesos").innerHTML = "<p>No se encontraron ejercicios.</p>";
                }
            }
        }
    }  
</script>

<?php
    require_once 'modelo.php';

    if (!isset($_SESSION['id'])) {
        die("Error: El usuario no ha iniciado sesión.");
    }
    
    $usuario_id = $_SESSION['id'];
    $modelo = new Modelo();
    $conexion = $modelo->conexion("localhost", "fittrack", "root", "");
    
    if ($conexion !== null) {
        $datos_entrenamiento = $modelo->consultarDiasEntrenados($conexion,$usuario_id);

        $labels = []; // Array para almacenar los días
        $data = [];   // Array para almacenar si se ha entrenado o no en cada día
        $fecha_actual = date('Y-m-d');
        $fecha_inicio = '2024-01-01'; 
        $fecha_actual = new DateTime($fecha_actual);
        $fecha_inicio = new DateTime($fecha_inicio);

        while ($fecha_actual >= $fecha_inicio) {
            $dia = $fecha_actual->format('Y-m-d');
            $labels[] = $dia; 

            $entrenado = false;
            foreach ($datos_entrenamiento as $dato) {
                if ($dato->fecha === $dia) {
                    $entrenado = true;
                    break;
                }
            }
            
            $data[] = $entrenado ? 1 : 0;
            $fecha_actual->modify('-1 day');
        }
    }

?>

<!-- HTML para el contenedor del gráfico -->
<canvas id="grafico_entrenamiento"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('grafico_entrenamiento').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_reverse($labels)); ?>, 
            datasets: [{
                label: 'Dias entrenados en el último año:',
                data: <?php echo json_encode(array_reverse($data)); ?>, 
                backgroundColor: '#075dc6', 
                borderColor: '#075dc6',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
    } else {
        
?>
<p>Para poder acceder a este contenido se necesita una membresía PREMIUM.</p>
<?php
    }
?>
<?php endblock() ?>

