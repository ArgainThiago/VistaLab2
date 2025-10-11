<?php 
include("../../Backend/Conexion.php");

if (isset($_GET['Cedula_D']) && is_numeric($_GET['Cedula_D'])) {
    $Cedula_D = (int) $_GET['Cedula_D'];
} else {
    die("Cédula del doctor inválida.");
}

$sql_especialidades = "DELETE FROM especialidad WHERE Cedula_D = $Cedula_D";
mysqli_query($conn, $sql_especialidades);

$sql_consultas = "DELETE FROM consulta WHERE Cedula_D = $Cedula_D";
mysqli_query($conn, $sql_consultas);

$sql_doctor = "DELETE FROM doctor WHERE Cedula_D = $Cedula_D";

if (mysqli_query($conn, $sql_doctor)) {
    echo "<script>
        alert('Doctor eliminado correctamente.');
        window.location.href='../PaginaDeMedicos.php';
    </script>";
} else {
    echo "<script>
        alert('Error al eliminar el doctor: " . mysqli_error($conn) . "');
        window.location.href='../PaginaDeMedicos.php';
    </script>";
}
?>
