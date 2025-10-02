
<?php
include("../../Usuarios/Conexion.php");

$result = mysqli_query($conn, "SELECT * FROM doctor");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="seelimina.css">
</head>
<body>
    <div class="card">
  <div class="header">
    <div class="image">
      <svg
        aria-hidden="true"
        stroke="currentColor"
        stroke-width="1.5"
        viewBox="0 0 24 24"
        fill="none"
      >
        <path
          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
          stroke-linejoin="round"
          stroke-linecap="round"
        ></path>
      </svg>
    </div>
    <div class="content">
      <span class="title">Eliminar Médico</span>
      <p class="message">
        ¿Está seguro que desea eliminar a este usuario?
      </p>
    </div>
    <div class="actions">
      <button onclick="location.href='Eliminar.php?Cedula_D=<?php echo $row['Cedula_D']; ?>'" type="button" class="desactivate">Eliminar</button>
      <button onclick="location.href='../PaginaDeMedicos.php'" class="cancel" type="button" >Cancelar</button>
    </div>
  </div>
</div>
<a href="Eliminar.php?Cedula_P=<?php echo $row['Cedula_P']; ?>"></a>
</body>
</html>