<?php 
include("../Conexion.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $Correo= mysqli_real_escape_string($conn, $_POST['Correo']);
    $Tel= mysqli_real_escape_string($conn, $_POST['Tel']);
    $Contraseña_A= mysqli_real_escape_string($conn, $_POST['Contraseña_A']);
    $Usuario_A= mysqli_real_escape_string($conn, $_POST['Usuario_A']);

    if (!empty($Correo) && !empty($Tel) && !empty($Contraseña_A) && !empty($Usuario_A)) {
        $sql = "INSERT INTO administrador (Correo, Tel, Usuario_A, Contraseña_A) 
                VALUES ('$Correo', '$Tel', '$Usuario_A', '$Contraseña_A')";

        if(mysqli_query($conn, $sql)){
            echo "Administrador agregado correctamente.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Por favor completa todos los campos";
    }
}
?>

<form method="POST" action="">
    Correo: <input type="email" name="Correo" required><br>
    Tel: <input type="number" name="Tel" required><br>
    Usuario: <input type="text" name="Usuario_A" required><br>
    Contraseña: <input type="text" name="Contraseña_A" required><br>
    <button type="submit">Guardar</button>
</form>
