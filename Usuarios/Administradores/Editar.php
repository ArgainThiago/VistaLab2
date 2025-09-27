<?php
include("../Conexion.php");

if (!isset($_GET['ID_Administrador']) || !is_numeric($_GET['ID_Administrador'])) {
    die("ID de administrador inválido.");
}

$ID_Administrador = (int) $_GET['ID_Administrador'];
$result = mysqli_query($conn, "SELECT * FROM administrador WHERE ID_Administrador=$ID_Administrador");
$Administrador = mysqli_fetch_assoc($result);

if (!$Administrador) {
    die("Administrador no encontrado.");
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $Tel           = mysqli_real_escape_string($conn, $_POST['Tel']);
    $Correo        = mysqli_real_escape_string($conn, $_POST['Correo']);
    $Contraseña_A  = mysqli_real_escape_string($conn, $_POST['Contraseña_A']);
    $Usuario_A     = mysqli_real_escape_string($conn, $_POST['Usuario_A']);

    $sql = "UPDATE administrador SET 
                Tel='$Tel', 
                Correo='$Correo', 
                Contraseña_A='$Contraseña_A', 
                Usuario_A='$Usuario_A' 
            WHERE ID_Administrador=$ID_Administrador";

    if (mysqli_query($conn, $sql)) {
        echo "Administrador actualizado correctamente.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST" action="">
    Tel: <input type="text" name="Tel" value="<?php echo htmlspecialchars($Administrador['Tel']); ?>"><br>
    Correo: <input type="text" name="Correo" value="<?php echo htmlspecialchars($Administrador['Correo']); ?>"><br>
    Contraseña: <input type="text" name="Contraseña_A" value="<?php echo htmlspecialchars($Administrador['Contraseña_A']); ?>"><br>
    Usuario: <input type="text" name="Usuario_A" value="<?php echo htmlspecialchars($Administrador['Usuario_A']); ?>"><br>
    <button type="submit">Actualizar</button>
</form>
