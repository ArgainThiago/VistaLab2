<?php
include("../Conexion.php");

if (!isset($_GET['ID_Especialidad']) || !is_numeric($_GET['ID_Especialidad'])) {
    die("ID de especialidad inválido.");
}

$ID_Especialidad = (int) $_GET['ID_Especialidad'];

$result = mysqli_query($conn, "SELECT * FROM especialidad WHERE ID_Especialidad=$ID_Especialidad");
$Especialidad = mysqli_fetch_assoc($result);

if (!$Especialidad) {
    die("Especialidad no encontrada.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nom_Especialidad = isset($_POST['Nom_Especialidad']) ? mysqli_real_escape_string($conn, $_POST['Nom_Especialidad']) : '';
    $Cedula_D        = isset($_POST['Cedula_D']) ? mysqli_real_escape_string($conn, $_POST['Cedula_D']) : '';
    $Descripcion     = isset($_POST['Descripcion']) ? mysqli_real_escape_string($conn, $_POST['Descripcion']) : '';
    $Fecha_Esp       = isset($_POST['Fecha_Esp']) ? mysqli_real_escape_string($conn, $_POST['Fecha_Esp']) : '';

    if (!empty($Nom_Especialidad) && !empty($Cedula_D) && !empty($Descripcion) && !empty($Fecha_Esp)) {
        $sql = "UPDATE especialidad SET 
                    Nom_Especialidad='$Nom_Especialidad', 
                    Cedula_D='$Cedula_D', 
                    Descripcion='$Descripcion', 
                    Fecha_Esp='$Fecha_Esp' 
                WHERE ID_Especialidad=$ID_Especialidad";

        if (mysqli_query($conn, $sql)) {
            echo "Especialidad actualizada correctamente.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>

<form method="POST" action="">
    ID_Especialidad: <input type="number" name="ID_Especialidad" value="<?php echo $Especialidad['ID_Especialidad']; ?>" readonly><br>
    Nom_Especialidad: <input type="text" name="Nom_Especialidad" value="<?php echo htmlspecialchars($Especialidad['Nom_Especialidad']); ?>" required><br>
    Cedula_D: <input type="number" name="Cedula_D" value="<?php echo $Especialidad['Cedula_D']; ?>" required><br>
    Descripcion: <input type="text" name="Descripcion" value="<?php echo htmlspecialchars($Especialidad['Descripcion']); ?>" required><br>
    Fecha_Esp: <input type="date" name="Fecha_Esp" value="<?php echo $Especialidad['Fecha_Esp']; ?>" required><br>
    <button type="submit">Actualizar</button>
    <a href="listar.php">Volver</a>
</form>
