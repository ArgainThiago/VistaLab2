<?php
session_start();
include '../Base de datos/Conexion.php';

if(!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'paciente'){
    header("Location: ../login.html");
    exit();
}

if(!isset($_SESSION['cedula_d'])){
    echo "<script>alert('No se seleccionó ningún médico'); window.location.href='Agendar_cita.php';</script>";
    exit();
}

$cedula_d = $_SESSION['cedula_d'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda de Citas</title>
<link rel="stylesheet" href="Estilomedico.css">
<link rel="stylesheet" href="Agenda.css">
</head>
<body>
<button class="hamburger" onclick="toggleMenu()">☰</button>
<nav id="menu" class="menu">
    <ul>
        <li><a href="../inicio.html">Inicio</a></li>
        <li><a href="SegundaPagina.php">Atras</a></li>
    </ul>
</nav>

<div class="superior">
    <p class="Texto">SaludLab</p>
    <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
</div>

<div class="navegacion">
    <button id="mes-anterior">&#9664; Mes anterior</button>
    <button id="mes-siguiente">Mes siguiente &#9654;</button>
</div>

<div class="calendario" id="calendario"></div>

<script>
function toggleMenu(){
    document.getElementById("menu").classList.toggle("show");
}
</script>

<script>
let fechaActual = new Date();
fechaActual.setHours(0,0,0,0);
let mes = fechaActual.getMonth();
let anio = fechaActual.getFullYear();
const calendarioDiv = document.getElementById("calendario");
const mesesNombres = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const diasSemana = ["Lun","Mar","Mié","Jue","Vie","Sáb","Dom"];
let diasDisponibles = [];

const cedula_d = <?php echo $cedula_d; ?>;

fetch(`obtener_dias_disponibles.php?cedula_d=${cedula_d}`)
.then(response => response.json())
.then(data => {
    diasDisponibles = data;
    generarCalendario(mes, anio);
});

function generarCalendario(mes, anio){
    const primerDia = new Date(anio, mes, 1).getDay();
    const diasMes = new Date(anio, mes + 1, 0).getDate();
    let html = `<h1>${mesesNombres[mes]} ${anio}</h1>`;
    html += "<table><tr>";
    for(let d of diasSemana) html += `<th>${d}</th>`;
    html += "</tr><tr>";
    let diaSemana = (primerDia === 0) ? 7 : primerDia;
    for(let i = 1; i < diaSemana; i++) html += "<td></td>";

    for(let dia = 1; dia <= diasMes; dia++){
        let fechaStr = `${anio}-${String(mes+1).padStart(2,'0')}-${String(dia).padStart(2,'0')}`;
        let habilitado = diasDisponibles.includes(fechaStr) ? "" : "disabled";
        let claseHoy = "";
        if(dia === fechaActual.getDate() && mes === fechaActual.getMonth() && anio === fechaActual.getFullYear()){
            claseHoy = "hoy";
        }
        html += `<td><button class="dia-boton ${claseHoy}" ${habilitado} onclick="location.href='horario.php?fecha=${fechaStr}'">${dia}</button></td>`;
        if((dia + diaSemana - 1) % 7 === 0) html += "</tr><tr>";
    }
    html += "</tr></table>";
    calendarioDiv.innerHTML = html;
}

document.getElementById("mes-anterior").addEventListener("click", ()=>{
    mes--;
    if(mes < 0){ mes = 11; anio--; }
    generarCalendario(mes, anio);
});

document.getElementById("mes-siguiente").addEventListener("click", ()=>{
    mes++;
    if(mes > 11){ mes = 0; anio++; }
    generarCalendario(mes, anio);
});
</script>
</body>
</html>
