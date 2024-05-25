<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>

<form id="miFormulario">
    <div id="mensaje" style="display: none; padding:20px; margin:10px; border-radius:10px; border:1px solid green; background-color:#9EF7A1;">
        <p>Entrenamiento creado con éxito.</p>
    </div>
    <h3>Entrenamiento Pecho y Triceps:</h3><br>
    <strong>Dia<span style="color: red;">*</span>:</strong> <input type="date" id="dia" required><br>
    <div class="ejercicio">
        <label for="opciones">Ejercicio 1:</label> <input type="text" name="opciones" value="Press de banca con barra" readonly><br>
        <label for="series">Series:</label> <input type="number" name="series" value="4" readonly><br>
        <label for="repeticiones">Repeticiones:</label> <input type="number" name="repeticiones" value="10" readonly><br>
        <label for="peso">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <div class="ejercicio">
        <label for="opciones">Ejercicio 2:</label> <input type="text" name="opciones" value="Press de banca inclinado con barra" readonly><br>
        <label for="series">Series:</label> <input type="number" name="series" value="4" readonly><br>
        <label for="repeticiones">Repeticiones:</label> <input type="number" name="repeticiones" value="10" readonly><br>
        <label for="peso">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <div class="ejercicio">
        <label for="opciones">Ejercicio 3:</label> <input type="text" name="opciones" value="Aperturas" readonly><br>
        <label for="series">Series:</label> <input type="number" name="series" value="4" readonly><br>
        <label for="repeticiones">Repeticiones:</label> <input type="number" name="repeticiones" value="12" readonly><br>
        <label for="peso">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <div class="ejercicio">
        <label for="opciones">Ejercicio 4:</label> <input type="text" name="opciones" value="Fondos triceps" readonly><br>
        <label for="series">Series:</label> <input type="number" name="series" value="4" readonly><br>
        <label for="repeticiones">Repeticiones:</label> <input type="number" name="repeticiones" value="8" readonly><br>
        <label for="peso">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <div class="ejercicio">
        <label for="opciones">Ejercicio 5:</label> <input type="text" name="opciones" value="Polea Triceps" readonly><br>
        <label for="series">Series:</label> <input type="number" name="series" value="3" readonly><br>
        <label for="repeticiones">Repeticiones:</label> <input type="number" name="repeticiones" value="12" readonly><br>
        <label for="peso">Peso(kg.)<span style="color: red;">*</span>:</label> <input type="number" name="peso" placeholder="Introduce peso en kg" required><br>
    </div>
    <p style="color:red">RECUERDA: Únicamente se puede añadir el día del entrenamiento y el peso utilizado*</p>
    <input type="button" value="Enviar" onclick="enviarDatos()">
    <br><br>
    <input type="button" id="volverAtras" value="Volver">
</form>

<script>

function redireccionar(){
    window.location.href = "entrenamiento.php";
}
var plantilla = document.getElementById("volverAtras")
plantilla.addEventListener("click",redireccionar);

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
    xhr.send(JSON.stringify(datos));
    } else { 
        alert('Por favor, complete todos los campos obligatorios.');
    }
}

</script>

<?php endblock() ?>