<?php
header('Content-Type: application/json; charset=utf-8');
include '../Base de datos/Conexion.php';


$medico = isset($_GET['medico']) ? intval($_GET['medico']) : (isset($_GET['medico_id']) ? intval($_GET['medico_id']) : 0);
$especialidad = isset($_GET['especialidad']) ? intval($_GET['especialidad']) : (isset($_GET['id_especialidad']) ? intval($_GET['id_especialidad']) : 0);

if (!$medico || !$especialidad) {
    
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("
    SELECT DISTINCT Fecha_Consulta
    FROM consulta
    WHERE Cedula_D = ? 
      AND ID_Especialidad = ?
      AND Estado = 'Disponible'
      AND Fecha_Consulta >= CURDATE()
    ORDER BY Fecha_Consulta ASC
");
$stmt->bind_param("ii", $medico, $especialidad);
$stmt->execute();
$res = $stmt->get_result();

$fechas = [];
while ($row = $res->fetch_assoc()) {
    $fechas[] = $row['Fecha_Consulta'];
}
echo json_encode($fechas);
