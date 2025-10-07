<?php
include '../Base de datos/Conexion.php';

if (isset($_POST['nombre_especialidad'])) {
    $nombreEsp = $_POST['nombre_especialidad'];

    $stmt = $conn->prepare("
        SELECT DISTINCT d.Cedula_D, d.Nombre_D
        FROM doctor d
        INNER JOIN especialidad e ON d.Cedula_D = e.Cedula_D
        WHERE e.Nom_Especialidad = ?
    ");
    $stmt->bind_param("s", $nombreEsp);
    $stmt->execute();
    $res = $stmt->get_result();

    echo '<option value="">Seleccione el médico</option>';
    while ($row = $res->fetch_assoc()) {
        echo '<option value="'.$row['Cedula_D'].'">'.$row['Nombre_D'].'</option>';
    }

    $stmt->close();
}
?>
