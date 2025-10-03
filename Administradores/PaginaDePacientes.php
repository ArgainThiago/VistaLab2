
<?php
include("../Usuarios/Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM paciente");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes</title>
    <link rel="stylesheet" href="Estilomed.css">
</head>
<body>
 <button class="Robot"></button>
 
    <div class="superior">
       <div class="group">
  <svg viewBox="0 0 24 24" aria-hidden="true" class="search-icon">
    <g>
      <path
        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"
      ></path>
    </g>
  </svg>

  <input
    id="query"
    class="input"
    type="search"
    placeholder="Buscar Medicos..."
    name="searchbar"

  />
  <button onclick="location.href='../Administradores/Paciente/Agregar.php'" class="Agregar">Agregar</button>
</div>

        <p class="Texto">SaludLab</p>

        <img src="../Imagenes/logohospital.png"alt="logo"class="logo">
    </div>
    <h1 class="Cita">Pacientes</h1>
<div class="tablas">
    <div class="estilos">
    <Table border="1">

    <?php while($row=mysqli_fetch_assoc($result)){
        ?>
       
        <tr>
            <td>Paciente: <?php echo $row['Nombre_P'];?></td>
            <td>   CI: <?php echo $row['Cedula_P'];?></td>
            <td>
              <button onclick="location.href='../Administradores/Paciente/seelimina.php?Cedula_P=<?php echo $row['Cedula_P']; ?>'" class="Boton1">Eliminar</button>
              <button onclick="location.href='../Administradores/Paciente/Editar.php?Cedula_P=<?php echo $row['Cedula_P']; ?>'" class="Boton1">Modificar</button>
               
            </td>
            
        </tr>
        
        
        <?php }?>
</table>
</div>
</div>

</body>
</html>