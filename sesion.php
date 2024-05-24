<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>

<h2>FitTrack: Tu Compañero de Entrenamiento</h2>
<h3>Funcionalidades Principales:</h3>
<div class="parrafos">
    <ul>
        <li>
            <strong>Entrenamiento:</strong> En esta sección, encontrarás plantillas de entrenamiento predefinidas para inspirarte y guiar tus sesiones de ejercicio. Además, tienes la flexibilidad de registrar tus propias sesiones, incluyendo detalles como ejercicios realizados, series, repeticiones y peso utilizado.
        </li>
        <li>
            <strong>Historial:</strong> Accede a listados diarios que muestran todos los datos ingresados en tus sesiones de entrenamiento, permitiéndote revisar y analizar tu progreso a lo largo del tiempo.
        </li>
        <li>
            <strong>Análisis:</strong> Esta sección te proporciona información detallada sobre patrones de entrenamiento, tendencias y áreas para mejorar basadas en los datos registrados. Identifica áreas de oportunidad y optimiza tu rutina de ejercicios para alcanzar tus objetivos de fitness.
                Esta sección solo esta habilitada para usuarios PREMIUM.
        </li>
        <li>
            <strong>Sugerencias:</strong> No dudes en contactarnos para cualquier sugerencia o reportar cualquier incidencia. Si tienes algún ejercicio en mente que te gustaría ver añadido a nuestra colección, ¡háznoslo saber! Simplemente deja una sugerencia incluyendo el nombre del ejercicio y el tipo de entrenamiento al que pertenece.     
        </li>
    </ul>
</div>
<p><small>Se presenta a continuación un gráfico que muestra los días en los que se ha entrenado durante la última semana.
         Cuando se muestra un '1', indica que se ha realizado entrenamiento ese día. Por otro lado, un '0' indica que no ha habido actividad de entrenamiento ese día.
</small></p>
    <hr>

<?php

require_once 'modelo.php';

if (!isset($_SESSION['id'])) {
    die("Error: El usuario no ha iniciado sesión.");
}

$usuario_id = $_SESSION['id'];
$modelo = new Modelo();
$conexion = $modelo->conexion("localhost", "fittrack", "root", "");

if ($conexion !== null) {
    // Obtener los datos de entrenamiento de los últimos 7 días desde el modelo
    $datos_entrenamiento = $modelo->consultarDatosEntrenamientoUltimos7Dias($conexion,$usuario_id);
    if ($datos_entrenamiento !== null) {
        // Convertir los datos a un formato adecuado para JavaScript
        $labels = [];
        $data = [];
        foreach ($datos_entrenamiento as $dato) {
            $labels[] = $dato->fecha; // Utilizamos el formato de fecha 'Y-m-d'
            $data[] = $dato->entrenado;
        }
    } else {
        $labels = [];
        $data = [];
    }
}
?>

<canvas id="grafico_entrenamiento"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('grafico_entrenamiento').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: '¿Que dias he entrenado esta última semana?',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: '#075dc6', 
                borderColor: '#075dc6', 
                borderWidth: 2
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

<?php endblock() ?>