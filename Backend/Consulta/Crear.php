<?php 
include("../Conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

$Cedula_D= mysqli_real_escape_string($conn, $_POST['Cedula_D']);
$ID_Especialidad= mysqli_real_escape_string($conn, $_POST['ID_Especialidad']);
$Fecha_Consulta=mysqli_real_escape_string($conn, $_POST['Fecha_Consulta']);
$Horario=mysqli_real_escape_string($conn, $_POST['Horario']);
$Cedula_P=mysqli_real_escape_string($conn, $_POST['Cedula_P']);
$Estado=mysqli_real_escape_string($conn, $_POST['Estado']);
if (!empty($Cedula_D) && !empty($ID_Especialidad) && !empty($Fecha_Consulta) && !empty($Horario) && !empty($Cedula_P) && !empty($Estado)) {

    $sql = "INSERT INTO consulta (Cedula_D, ID_Especialidad, Fecha_Consulta, Horario, Cedula_P, Estado) VALUES ('$Cedula_D', '$ID_Especialidad', '$Fecha_Consulta', '$Horario', '$Cedula_P', '$Estado')";
    if(mysqli_query($conn, $sql)){
        echo "Consulta agregada correctamente.";
    }
    else{
        echo"Error: " . mysqli_error($conn);
    }                       }else{
        echo"Por favor completa todos los campos";
}

}


?>
<form method="POST" action="">
    Cédula del doctor: <input type="number" name="Cedula_D"><br>
    Id de la especialidad: <input Type="number" name="ID_Especialidad"><br>
    Fecha de la consulta: <input Type="date" name="Fecha_Consulta"><br>
    Horario de la consulta: <input Type="time" name="Horario"><br>
    Cédula del paciente: <input Type="number" name="Cedula_P"><br>
    Estado de consulta: <input Type="enum" name="Estado"><br>
    <button type="submit">Guardar</button>

</form>