<?php
include '../Base de datos/Conexion.php';

if (isset($_POST['id_especialidad'])) {
    $idEsp = $_POST['id_especialidad'];

    //se obtienen los doctores con esa especialidad 
    $stmt = $conn->prepare("
        SELECT d.Cedula_D, d.Nombre_D 
        FROM doctor d
        INNER JOIN especialidad e ON d.Cedula_D = e.Cedula_D
        WHERE e.ID_Especialidad = ?
    ");
    $stmt->bind_param("i", $idEsp);
    $stmt->execute();
    $res = $stmt->get_result();

    echo '<option value="">Seleccione el médico</option>';
    while ($row = $res->fetch_assoc()) {
        echo '<option value="'.$row['Cedula_D'].'">'.$row['Nombre_D'].'</option>';
    }
    }