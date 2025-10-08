<?php
include '../Base de datos/Conexion.php';
session_start();

$cedula_d = $_GET['cedula_d'] ?? $_SESSION['cedula_d'] ?? null;
if(!$cedula_d) { echo json_encode([]); exit(); }

$stmt = $conn->prepare("SELECT Fecha_Consulta FROM consulta WHERE Cedula_D=? AND Estado='Disponible'");
$stmt->bind_param("i", $cedula_d);
$stmt->execute();
$res = $stmt->get_result();
$fechas = [];
while($row = $res->fetch_assoc()){
    $fechas[] = $row['Fecha_Consulta'];
}
echo json_encode($fechas);
?>
