<?php 
include("../../Backend/Conexion.php");


if (!isset($_GET['Cedula_D']) || !is_numeric($_GET['Cedula_D'])) {
    die("Error: Cédula del doctor inválida.");
}

$Cedula_D = (int) $_GET['Cedula_D'];


mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");


$delete_especialidades = $conn->prepare("DELETE FROM especialidad WHERE Cedula_D = ?");
$delete_especialidades->bind_param("i", $Cedula_D);
$delete_especialidades->execute();

$delete_consultas = $conn->prepare("DELETE FROM consulta WHERE Cedula_D = ?");
$delete_consultas->bind_param("i", $Cedula_D);
$delete_consultas->execute();


$delete_doctor = $conn->prepare("DELETE FROM doctor WHERE Cedula_D = ?");
$delete_doctor->bind_param("i", $Cedula_D);

if ($delete_doctor->execute()) {
    echo "<script>
        alert('Doctor eliminado correctamente.');
        window.location.href='../PaginaDeMedicos.php';
    </script>";
} else {
    echo "<script>
        alert('No se pudo eliminar el doctor. Verifique que no tenga registros asociados.');
        window.location.href='../PaginaDeMedicos.php';
    </script>";
}


mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");


$delete_especialidades->close();
$delete_consultas->close();
$delete_doctor->close();
$conn->close();
?>

