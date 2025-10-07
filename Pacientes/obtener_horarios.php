<?php
include '../Base de datos/Conexion.php';

if (isset($_POST['cedula_d']) && isset($_POST['fecha'])) {
    $cedula_d = $_POST['cedula_d'];
    $fecha = $_POST['fecha'];


    $horarios = ["08:00:00", "09:00:00", "10:00:00", "11:00:00", "15:00:00", "16:00:00", "17:00:00"];

    
    $stmt = $conn->prepare("SELECT Horario FROM consulta WHERE Cedula_D=? AND Fecha_Consulta=? AND Estado='Ocupado'");
    $stmt->bind_param("is", $cedula_d, $fecha);
    $stmt->execute();
    $res = $stmt->get_result();

    $ocupados = [];
    while($row = $res->fetch_assoc()){
        $ocupados[] = $row['Horario'];
    }


    echo '<option value="">Seleccione un horario</option>';
    foreach($horarios as $h){
        if(!in_array($h, $ocupados)){
            echo '<option value="'.$h.'">'.$h.'</option>';
        }
    }
}
?>

