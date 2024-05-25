<?php include 'diseño/base.php' ?> 
<?php startblock('contenido') ?>

<form id="miFormulario">
    <div id="mensaje" style="display: none; padding:20px; margin:10px; border-radius:10px; border:1px solid green; background-color:#9EF7A1;">
        <p>Entrenamiento creado con éxito.</p>
    </div>
    <h1>Entrenamiento Diario:</h1><br>
    <strong>Dia<span style="color: red;">*</span>:</strong> <input type="date" id="dia" name="dia" required><br>
    <div id="tipoEjercicio">
        <p>Que tipo de entrenamiento has realizado:</p>
        <button type="button" onclick="cambiarTipo('bodybuilding')">Bodybuilding</button>
        <button type="button" onclick="cambiarTipo('crossfit')">Crossfit</button>
        <button type="button" onclick="cambiarTipo('kettlebells')">Kettlebells</button>
    </div>
    <p id="tipoSeleccionado"></p><br>
    <div id="ejercicios">
        <div class="ejercicio">
            <label for="opciones">Ejercicio<span style="color: red;">*</span>:</label> 
                <select name="opciones[]" required>
                </select>
            <!-- <label for="nombre_ejercicio"></label><input type="text" id="nombre_ejercicio" placeholder="Introduce nuevo ejercicio">
            <button type="button" onclick="agregarNuevoEjercicio()">Añadir nuevo</button><br> -->
            <label for="series">Series<span style="color: red;">*</span>:</label> <input type="number" name="series[]" placeholder="Introduce nº de series" required><br>
            <label for="repeticiones">Repeticiones<span style="color: red;">*</span>:</label> <input type="number" name="repeticiones[]" placeholder="Introduce nº de repeticiones" required><br>
            <label for="peso">Peso(kg.):</label> <input type="number" name="peso[]" placeholder="Introduce peso en kg"><br>
        </div>
    </div>
    <br>
    <button id="botonLimpiar" type="button" onclick="limpiarFormulario()">Limpiar Formulario</button><br>
    <button id="botonAgregar" type="button" onclick="agregarEjercicio()">Agregar Ejercicio</button><br>
    <button id="botonQuitar" type="button" onclick="quitarEjercicio()">Quitar Ejercicio</button><br>
    <br><br>
    <input type="button" value="Enviar" onclick="enviarDatos()"><br>
    <input type="button" id="volverAtras" value="Volver">
</form>

<script>

var opcionesBodyBuilding = [
    "Sentadilla",
    "Press de banca con barra",
    "Press militar",
    "Press de banca inclinado con barra",
    "Aperturas",
    "Fondo tríceps",
    "Polea tríceps",
    "Dominadas",
    "Peso muerto",
    "Remo",
    "Elevación lateral con mancuernas"
];

var opcionesCrossfit = [
    "Thrusters",
    "Pull ups",
    "Burpees",
    "Double unders",
    "Toes to bars",
    "Wall balls",
    "Snatches",
    "Clean and jerks",
    
];

var opcionesKettlebells = [
    "Swing",
    "Turkish get up",
    "Clean",
    "Snatch",
    "Deadlift",
    "Row",
    "Carry",
    "Goblet squat"
    
];

function cambiarTipo(tipo){
    var seleccionada = document.querySelector('select[name="opciones[]"]');
    seleccionada.innerHTML = "";

    var opciones = [];
    if (tipo === "bodybuilding") {
        opciones = opcionesBodyBuilding;
    } else if (tipo === "crossfit") {
        opciones = opcionesCrossfit;
    } else if (tipo === "kettlebells") {
        opciones = opcionesKettlebells;
    }
    opciones.forEach(function(opcion) {
        var option = document.createElement("option");
        option.value = opcion;
        option.text = opcion;
        seleccionada.appendChild(option);
    });

   // Deshabilitar los botones después de cambiar el tipo
   var botones = document.querySelectorAll('#tipoEjercicio button');
    botones.forEach(function(button) {
        button.disabled = true;
    });

    var tipoSeleccionado = document.getElementById("tipoSeleccionado");
    tipoSeleccionado.innerHTML = "Tipo de entrenamiento seleccionado: <span class='tipo' style='background-color:red;color:white'>" 
    + tipo.toUpperCase() + 
    "</span><br><span class='mensaje'>(Para modificar el tipo de entrenamiento, recargue la página).</span>";
    tipoSeleccionado.classList.add("tipoSeleccionado");
}

/* // Agrega el evento 'click' a los botones para cambiar el tipo de ejercicio
document.getElementById("tipoEjercicio").addEventListener("click", function(event) {
    if (event.target.tagName === "BUTTON") {
        var tipo = event.target.textContent.toLowerCase();
        cambiarTipo(tipo);
    }
}); */

function limpiarFormulario() {
    document.getElementById("miFormulario").reset();
}

function agregarEjercicio() {
    var divEjercicios = document.getElementById("ejercicios");
    var nuevoEjercicio = document.createElement("div");
    nuevoEjercicio.classList.add("ejercicio");
    nuevoEjercicio.innerHTML = `
        <label for="opciones">Ejercicio<span style="color: red;">*</span>:</label> 
            <select name="opciones[]">
            ${document.querySelector('select[name="opciones[]"]').innerHTML}
            </select><br>
        <label for="series">Series<span style="color: red;">*</span>:</label> <input type="number" name="series[]" placeholder="Introduce nº de series"><br>
        <label for="repeticiones">Repeticiones<span style="color: red;">*</span>:</label> <input type="number" name="repeticiones[]" placeholder="Introduce nº de repeticiones"><br>
        <label for="peso">Peso(kg.):</label> <input type="number" name="peso[]" placeholder="Introduce peso en kg"><br>
    `;
    divEjercicios.appendChild(nuevoEjercicio);
}

function quitarEjercicio(){
    var divEjercicios = document.getElementById("ejercicios");
    var ejercicios = divEjercicios.getElementsByClassName("ejercicio");
    if (ejercicios.length > 1) {
        divEjercicios.removeChild(ejercicios[ejercicios.length - 1]);
    } else {
        alert("No hay ejercicios para eliminar.");
    }
}

function enviarDatos() {
    if (document.getElementById('miFormulario').checkValidity()) {
        var dia = document.getElementById("dia").value;
        var ejercicios = document.getElementsByName("opciones[]");
        var series = document.getElementsByName("series[]");
        var repeticiones = document.getElementsByName("repeticiones[]");
        var peso = document.getElementsByName("peso[]");
        var datos = {
            dia: dia,
            ejercicios: [],
        };

        for (var i = 0; i < ejercicios.length; i++) {
            datos.ejercicios.push({
                ejercicio: ejercicios[i].value,
                series: series[i].value,
                repeticiones: repeticiones[i].value,
                peso: peso[i].value
            });
        }
        // console.log(datos);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controladores.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    try{
                        var respuesta = JSON.parse(xhr.responseText);
                        // console.log(respuesta.message);
                        if(respuesta.exito){
                            document.getElementById("mensaje").style.display="block";
                            limpiarFormulario()
                        }
                    }
                    catch(e) {
                        console.log("Error del servidor " + e.message + " respuesta: " + xhr.responseText);
                    }
                } else {
                    console.log("Error al enviar los datos" + xhr.status);
                }
            }
        };
        xhr.send(JSON.stringify(datos));   
    } else {
        alert('Por favor, complete todos los campos obligatorios.');
    }
}


function redireccionar(){
        window.location.href = "entrenamiento.php";
        }
        var plantilla = document.getElementById("volverAtras")
        plantilla.addEventListener("click",redireccionar);

/* function agregarNuevoEjercicio() {
    var nombreEjercicioId = document.getElementById("nombre_ejercicio");
    var nombreEjercicio = nombreEjercicioId.value.trim();
    
    if (nombreEjercicio !== "") {
        var selectEjercicios = document.getElementsByName("opciones[]")[0];
        var añadirOption = document.createElement("option");
        añadirOption.text = nombreEjercicio;
        añadirOption.value = nombreEjercicio;
        
        // Crea un nuevo array a partir de la colección de opciones dentro del elemento selectEjercicios
        var ejerciciosExistentes = Array.from(selectEjercicios.options).map(option => option.value);
        if (!ejerciciosExistentes.includes(nombreEjercicio)) {
            selectEjercicios.appendChild(añadirOption);
        } else {
            alert("El ejercicio ya existe en la lista.");
        }
        
        // Limpiar el campo de entrada después de añadir el ejercicio
        nombreEjercicioId.value = "";
    } 
} */

</script>

<?php endblock() ?>