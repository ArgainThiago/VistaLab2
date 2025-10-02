<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Administracion</title>
    <link rel="stylesheet" href="../admin.css">
</head>
<body>

 
    <button class="hamburger" onclick="toggleMenu()">☰</button>

    <nav id="menu" class="menu">
        <ul>
            <li><a href="../inicio.html">Inicio</a></li>
        </ul>
    </nav>

    <button class="Robot"></button>

    <div class="superior">
        <button onclick="location.href='PaginaDePacientes.php'" class="mi-boton">Usuario Pacientes</button>
        <button onclick="location.href='PaginaDeMedicos.php'" class="Boton">Usuario Doctores</button> 
        <p class="Texto">SaludLab</p>
        <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
    </div>

    <h1 class="Cita">Información</h1>

    <div class="estadicticas"></div>

    <script>
       
        function toggleMenu() {
            document.getElementById("menu").classList.toggle("show");
        }
    </script>
</body>
</html>
