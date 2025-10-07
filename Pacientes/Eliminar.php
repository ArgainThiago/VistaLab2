<?php
include '../Base de datos/Conexion.php';

if (isset($_GET['ID_Consulta']) && is_numeric($_GET['ID_Consulta'])) {
    $ID_Consulta = $_GET['ID_Consulta'];

    $stmt = $conn->prepare("DELETE FROM consulta WHERE ID_Consulta = ?");
    $stmt->bind_param("i", $ID_Consulta);

    if ($stmt->execute()) {
        echo "<script>alert('Cita cancelada correctamente.'); window.location.href='SegundaPagina.php';</script>";
    } else {
        echo "Error al cancelar la cita: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "ID de cita inválido.";
}
?>
