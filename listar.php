<?php
include 'Conexion.php';

$sql = "SELECT * FROM Paciente";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "<pre>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "ID: " . $fila["id"] . "";
        echo "Nombre del Paciente: " . $fila["Nombre_P"] . "";
        echo "Cédula: " . $fila["Cedula_P"] . "";
        echo "Fecha de Nacimiento: " . $fila["Fech_Nac"] . "";
        echo "Sexo: " . $fila["Sexo"] . "";
        echo "Correo: " . $fila["correo"] . "";
        echo "Historial Médico: " . $fila["His_med"] . "";
        echo "Teléfono: " . $fila["Tel"] . "";
    }
    echo "</pre>";
} else {
    echo "No hay registros.";
}

$conn->close();
?>
