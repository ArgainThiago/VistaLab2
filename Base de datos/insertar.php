<?php
include 'Conexion.php';


    $Nombre = $_POST['Nombre'];
    $Cedula = $_POST['Cedula'];
    $Fecha = $_POST['Fecha'];
    $Sexo = $_POST['Sexo'];
    $Correo = $_POST['Correo'];
    $His_med = $_POST['His_med'];
    $tel = $_POST['tel'];

    $sql = "INSERT INTO Paciente (Cedula_P, Nombre_P, Fecha_Nac, Sexo, correo, His_med, Tel) 
            VALUES ('$Cedula', '$Nombre', '$Fecha', '$Sexo', '$Correo', '$His_med', '$tel')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar: " . $conn->error;
    }

    $conn->close();

?>
