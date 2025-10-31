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
            <li><a href="../inicio.html">Cerrar Sesion</a></li>
        </ul>
    </nav>

    

    <div class="superior">
        <button onclick="location.href='PaginaDePacientes.php'" class="mi-boton">Usuario Pacientes</button>
        <button onclick="location.href='PaginaDeMedicos.php'" class="Boton">Usuario Doctores</button> 
        <p class="Texto">SaludLab</p>
        <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
    </div>

    <h1 class="Cita">Manual</h1>

    <div class="estadicticas">
        <h1>Primer paso</h1><br>
        <p class="manual">Administrar Usuarios:</p><br>
        <p class="manual">  -</p><br>
        <p class="manual"> 1-Despectivamente para lo q quiera hacier, presione el boton Usuario Medico o Usuario Paciente</p><br>
        <p></p>
        <p class="manual"> 2-El usuario Administrador puede elegir entre eliminar, actualizar, listar, y agregar un usuario</p><br>
        <p class="manual"> Si desea trabajar con un usuario Doctor, debe hacer lo siguiente:</p><br>
        <p class="manual">  </p><br>
        <p class="manual">  1- Para crear un usuario: </p><br>
        <p class="manual">  -Presione el boton agregar </p><br>
        <p class="manual"> -Complete los datos correspondientes y presione guardar </p><br>
         <p class="manual">  </p><br>
        <p class="manual">  2- Para modificar un usuario: </p><br>
        <p class="manual">  -Elegir el usuario que desee modificar </p><br>
        <p class="manual">  -Edite los datos correspondientes y a continuacion presione el boton actualizar </p><br>
        <p class="manual">  </p><br>
        <p class="manual">  3- Para eliminar un usuario: </p><br>
        <p class="manual">  -Precione el boton Eliminar </p><br>
        <p class="manual">  -Confirme presionando nuevamente eliminar </p><br>
        <p class="manual">  </p><br>
        <p class="manual">  </p><br>
        <p class="manual"> Si desea trabajar con un usuario Paciente, debe hacer lo siguiente:</p><br>
        <p class="manual">  </p><br>
        <p class="manual">  1- Para crear un usuario: </p><br>
        <p class="manual">  -Presione el boton agregar </p><br>
        <p class="manual"> -Complete los datos correspondientes y presione guardar </p><br>
         <p class="manual">  </p><br>
        <p class="manual">  2- Para modificar un usuario: </p><br>
        <p class="manual">  -Elegir el usuario que desee modificar </p><br>
        <p class="manual">  -Edite los datos correspondientes y a continuacion presione el boton actualizar </p><br>
        <p class="manual">  </p><br>
        <p class="manual">  3- Para eliminar un usuario: </p><br>
        <p class="manual">  -Precione el boton Eliminar </p><br>
        <p class="manual">  -Confirme presionando nuevamente eliminar </p><br>
        <p class="manual">  </p><br>
        <p class="manual">  </p><br>

  
    </div>

    <script>
       
        function toggleMenu() {
            document.getElementById("menu").classList.toggle("show");
        }
    </script>
</body>
</html>
