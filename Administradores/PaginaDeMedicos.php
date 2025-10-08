<?php
include("../Usuarios/Conexion.php");
$result = mysqli_query($conn, "SELECT * FROM doctor");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Médicos</title>
  <link rel="stylesheet" href="Estilomed.css">
</head>
<body>

  <button class="hamburger" onclick="toggleMenu()">☰</button>

  <nav id="menu" class="menu">
    <ul>
      <li><a href="../inicio.html">Cerrar Sesion</a></li>
      
    </ul>
  </nav>

  <button class="Robot"></button>

  <div class="superior">
    <div class="group">
      <svg viewBox="0 0 24 24" aria-hidden="true" class="search-icon">
        <g>
          <path
            d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 
            9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 
            3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 
            11c0-4.135 3.365-7.5 7.5-7.5s7.5 
            3.365 7.5 7.5-3.365 7.5-7.5 
            7.5-7.5-3.365-7.5-7.5z"
          ></path>
        </g>
      </svg>

      <input
        id="query"
        class="input"
        type="search"
        placeholder="Buscar Médicos..."
        name="searchbar"
        onkeyup="filtrarTabla()"/>
         <button class="anterior" onclick="location.href='Pag_Admin.php'">Atras</button>
        <button onclick="location.href='../Administradores/Doctor/Agregar.php'" class="Agregar">Agregar</button>
    </div>

    <p class="Texto">SaludLab</p>
    <img src="../Imagenes/logohospital.png" alt="logo" class="logo">
  </div>

  <h1 class="Cita">Médicos</h1>

  <div class="tablas">
    <div class="estilos">
      <table border="1" id="tablaMedicos">
        <thead>
          <tr>
            <th>Nombre_D</th>
            <th>Cédula_D</th>
            <th>ID de Administrador</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['Nombre_D']; ?></td>
              <td><?php echo $row['Cedula_D']; ?></td>
              <td><?php echo $row['ID_Administrador']; ?></td>
              <td>
                <button onclick="location.href='../Administradores/Doctor/seelimina.php?Cedula_D=<?php echo $row['Cedula_D']; ?>'" class="Boton1">Eliminar</button>
                <button onclick="location.href='../Administradores/Doctor/Editar.php?Cedula_D=<?php echo $row['Cedula_D']; ?>'" class="Boton2">Modificar</button>
                <button onclick="location.href='../Administradores/Doctor/Disponibilidad.php?Cedula_D=<?php echo $row['Cedula_D']; ?>'" class="Boton2">Disponibilidad</button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function toggleMenu() {
      document.getElementById("menu").classList.toggle("show");
    }

    
    function filtrarTabla() {
      const input = document.getElementById("query");
      const filtro = input.value.toLowerCase();
      const tabla = document.getElementById("tablaMedicos");
      const filas = tabla.getElementsByTagName("tr");

   
      for (let i = 1; i < filas.length; i++) {
        const celdas = filas[i].getElementsByTagName("td");
        let coincide = false;

       
        for (let j = 0; j < celdas.length - 1; j++) { 
          if (celdas[j]) {
            const texto = celdas[j].textContent.toLowerCase();
            if (texto.includes(filtro)) {
              coincide = true;
              break;
            }
          }
        }

        filas[i].style.display = coincide ? "" : "none";
      }
    }
  </script>

</body>
</html>
