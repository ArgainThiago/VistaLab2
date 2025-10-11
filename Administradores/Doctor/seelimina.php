
<?php
include("../../Backend/Conexion.php");

if (isset($_GET['Cedula_D']) && is_numeric($_GET['Cedula_D'])) {
    $Cedula_D = (int) $_GET['Cedula_D'];

    $result = mysqli_query($conn, "SELECT * FROM doctor WHERE Cedula_D=$Cedula_D");
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Doctor no encontrado.");
    }
} else {
    die("ID inválido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Médico</title>
    <link rel="stylesheet" href="seelimina.css">
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="image">
                <svg aria-hidden="true" stroke="currentColor" stroke-width="1.5" 
                     viewBox="0 0 24 24" fill="none">
                    <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 
                             3.374 1.948 3.374h14.71c1.73 0 
                             2.813-1.874 1.948-3.374L13.949 
                             3.378c-.866-1.5-3.032-1.5-3.898 
                             0L2.697 16.126zM12 
                             15.75h.007v.008H12v-.008z"
                          stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
            </div>
            <div class="content">
                <span class="title">Eliminar Médico</span>
                <p class="message">
                    ¿Está seguro que desea eliminar a este usuario?
                </p>
            </div>
            <div class="actions">
                <button onclick="location.href='Eliminar.php?Cedula_D=<?php echo $row['Cedula_D']; ?>'" 
                        type="button" class="desactivate">Eliminar</button>
                <button onclick="location.href='../PaginaDeMedicos.php'" 
                        class="cancel" type="button">Cancelar</button>
            </div>
        </div>
    </div>
</body>
</html>
