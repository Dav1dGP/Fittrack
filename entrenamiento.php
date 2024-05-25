<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>

<h2>Registrar Entrenamiento:</h2>
<br><input type="button" id="btn-añadir" value="Nuevo entrenamiento">
<br><br>
<p><strong>Plantillas de ejemplo:</strong></p>
<section id="fullBody">
    <h3>Full Body</h3>
    <p>Sentadilla 5x5</p>
    <p>Press de Banca con barra 5x5</p>
    <p>Press Militar 5x5</p>
</section>
<section id="pechoTriceps">
    <h3>Pecho y Triceps</h3>
    <p>Press de Banca con barra 4x10</p>
    <p>Press de Banca inclinado con barra 4x10 </p>
    <p>Aperturas 4x12</p>
    <p>Fondos Triceps 4x8</p>
    <p>Polea Triceps 3x12</p>
</section>
<section id="espaldaHombros">
    <h3>Espalda y hombros</h3>
    <p>Dominadas 4x10</p>
    <p>Peso Muerto 4x10</p>
    <p>Remo 4x10 </p>
    <p>Press Militar 4x10</p>
    <p>Elevación lateral con mancuernas 3x8</p>
</section>

<script>

    function redireccionar(){
    window.location.href = "entrenamiento0.php";
    }
    
    function redireccionar1(){
    window.location.href = "entrenamiento1.php";
    }

    function redireccionar2(){
    window.location.href = "entrenamiento2.php";
    }
    
    function redireccionar3(){
    window.location.href = "entrenamiento3.php";
    }
    
    var plantilla = document.getElementById("btn-añadir")
    plantilla.addEventListener("click",redireccionar);
    
    var plantilla1 = document.getElementById("fullBody")
    plantilla1.addEventListener("click",redireccionar1);
    
    var plantilla2 = document.getElementById("pechoTriceps")
    plantilla2.addEventListener("click",redireccionar2);
    
    var plantilla3 = document.getElementById("espaldaHombros")
    plantilla3.addEventListener("click",redireccionar3);

</script>
<?php endblock() ?>