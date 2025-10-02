<?php
session_start();
include("../Usuarios/Conexion.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_consulta = $_POST['id_consulta'];
    $nueva_fecha = $_POST['fecha'];
    $nueva_hora = $_POST['hora'];

    // Verificar que el horario no esté ocupado por otra cita del mismo doctor
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM consulta WHERE Cedula_D=(SELECT Cedula_D FROM consulta WHERE ID_Consulta=?) AND Fecha_Consulta=? AND Horario=? AND ID_Consulta<>?");
    $stmt->bind_param("issi", $id_consulta, $nueva_fecha, $nueva_hora, $id_consulta);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if($res['total'] > 0){
        die("Error: Ese horario ya está ocupado para este doctor.");
    }

    // Actualizar cita
    $stmt2 = $conn->prepare("UPDATE consulta SET Fecha_Consulta=?, Horario=? WHERE ID_Consulta=?");
    $stmt2->bind_param("ssi", $nueva_fecha, $nueva_hora, $id_consulta);
    if($stmt2->execute()){
        header("Location: BuscarPac.php");
        exit();
    } else {
        die("Error al actualizar la cita.");
    }
}
?>
