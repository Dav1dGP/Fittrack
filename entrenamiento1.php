<?php include 'diseño/base.php' ?>
<?php startblock('contenido') ?>

<form id="miFormulario">
    <div id="mensaje" style="display: none; padding:20px; margin:10px; border-radius:10px; border:1px solid green; background-color:#9EF7A1;">
        <p>Entrenamiento creado con éxito.</p>
    </div>
    <h3>Entrenamiento Full Body:</h3><br>
    <strong>Día<span style="color: red;">*</span>:</strong> <input type="date" id="dia" required><br>
    <div class="ejercicio">
        <label for="opciones1">Ejercicio 1:</label> <input type="text" id="opciones1" name="opciones" value="sentadilla" readonly><br>
        <label for="series1">Series:</label> <input type="number" id="series1" name="series" value="5" readonly><br>
        <label for="repeticiones1">Repeticiones:</label> <input type="number" id="repeticiones1" name="repeticiones" value="5" readonly><br>
        <label for="peso1">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" id="peso1" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <div class="ejercicio">
        <label for="opciones2">Ejercicio 2:</label> <input type="text" id="opciones2" name="opciones" value="press de banca con barra" readonly><br>
        <label for="series2">Series:</label> <input type="number" id="series2" name="series" value="5" readonly><br>
        <label for="repeticiones2">Repeticiones:</label> <input type="number" id="repeticiones2" name="repeticiones" value="5" readonly><br>
        <label for="peso2">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" id="peso2" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <div class="ejercicio">
        <label for="opciones3">Ejercicio 3:</label> <input type="text" id="opciones3" name="opciones" value="press militar" readonly><br>
        <label for="series3">Series:</label> <input type="number" id="series3" name="series" value="5" readonly><br>
        <label for="repeticiones3">Repeticiones:</label> <input type="number" id="repeticiones3" name="repeticiones" value="5" readonly><br>
        <label for="peso3">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" id="peso3" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <p style="color:red">RECUERDA: Únicamente se puede añadir el día y el peso de los ejercicios*</p>
    <input type="button" value="Enviar" onclick="enviarDatos()">
    <br><br>
    <input type="button" id="volverAtras" value="Volver">
</form>

<script>

function redireccionar(){
    window.location.href = "entrenamiento.php";
}
var plantilla = document.getElementById("volverAtras")
plantilla.addEventListener("click", redireccionar);

function enviarDatos() {
    if (document.getElementById('miFormulario').checkValidity()) {
        var dia = document.getElementById("dia").value;
        var ejercicios = document.getElementsByClassName("ejercicio");
        var datos = {
            dia: dia,
            ejercicios: []
        };

        for (var i = 0; i < ejercicios.length; i++) {
            var ejercicio = ejercicios[i];
            var ejercicioData = {
                ejercicio: ejercicio.querySelector('input[name="opciones"]').value,
                series: ejercicio.querySelector('input[name="series"]').value,
                repeticiones: ejercicio.querySelector('input[name="repeticiones"]').value,
                peso: ejercicio.querySelector('input[name="peso"]').value
            };
        datos.ejercicios.push(ejercicioData);
        }
      //console.log("Datos recopilados:", datos); 

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controladores.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var respuesta = JSON.parse(xhr.responseText);
                    if(respuesta.exito){
                        document.getElementById("mensaje").style.display="block";
                        document.getElementById("miFormulario").reset();
                    }
                } else {
                    alert("Error al enviar los datos");
                }
            }
        };
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(JSON.stringify(datos));
    } else {
        alert('Por favor, complete todos los campos obligatorios.');
    }
}
</script>

<?php endblock() ?>
