<?php
session_start();
include("../Usuarios/Conexion.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_consulta = (int)$_POST['id_consulta'];
    $nueva_fecha = $_POST['fecha'];
    $nueva_hora = $_POST['hora'];

    // Obtener Cedula_D del doctor de esta cita
    $stmt = $conn->prepare("SELECT Cedula_D FROM consulta WHERE ID_Consulta=?");
    $stmt->bind_param("i", $id_consulta);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0) die("Cita no encontrada.");
    $cedula_doctor = $result->fetch_assoc()['Cedula_D'];

    // Verificar si ya hay cita en ese horario
    $stmt2 = $conn->prepare("SELECT COUNT(*) AS total FROM consulta WHERE Cedula_D=? AND Fecha_Consulta=? AND Horario=? AND ID_Consulta<>?");
    $stmt2->bind_param("issi", $cedula_doctor, $nueva_fecha, $nueva_hora, $id_consulta);
    $stmt2->execute();
    $res = $stmt2->get_result()->fetch_assoc();

    if($res['total'] > 0){
        die("Error: Ese horario ya está ocupado para este doctor.");
    }

    // Actualizar cita
    $stmt3 = $conn->prepare("UPDATE consulta SET Fecha_Consulta=?, Horario=? WHERE ID_Consulta=?");
    $stmt3->bind_param("ssi", $nueva_fecha, $nueva_hora, $id_consulta);
    if($stmt3->execute()){
        header("Location: Pag_Medico.php");
        exit();
    } else {
        die("Error al actualizar la cita.");
    }
}
?>
