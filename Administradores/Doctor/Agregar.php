<?php   
include("../../Usuarios/Conexion.php");


$especialidadesDB = [];
$result = mysqli_query($conn, "SELECT ID_Especialidad, Nom_Especialidad, Descripcion, Fecha_Esp FROM especialidad GROUP BY Nom_Especialidad");
while($row = mysqli_fetch_assoc($result)){
    $especialidadesDB[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $Cedula_D        = mysqli_real_escape_string($conn, $_POST['Cedula_D']);
    $Nombre_D        = mysqli_real_escape_string($conn, $_POST['Nombre_D']);
    $Correo          = mysqli_real_escape_string($conn, $_POST['Correo']);
    $His_med         = mysqli_real_escape_string($conn, $_POST['His_med']);
    $Tel             = mysqli_real_escape_string($conn, $_POST['Tel']);
    $Contraseña_D    = mysqli_real_escape_string($conn, $_POST['Contraseña_D']);
    $Usuario_D       = mysqli_real_escape_string($conn, $_POST['Usuario_D']);
    $ID_Administrador= mysqli_real_escape_string($conn, $_POST['ID_Administrador']);
    $Especialidades  = $_POST['Especialidades'] ?? []; 

    if (!empty($Correo) && !empty($Tel) && !empty($Contraseña_D) && !empty($Cedula_D) &&
        !empty($Nombre_D) && !empty($His_med) && !empty($ID_Administrador) && !empty($Usuario_D)) {


        $sql = "INSERT INTO doctor (Cedula_D, Nombre_D, Correo, His_med, Tel, Contraseña_D, ID_Administrador, Usuario_D) 
                VALUES ('$Cedula_D', '$Nombre_D', '$Correo', '$His_med', '$Tel', '$Contraseña_D', '$ID_Administrador', '$Usuario_D')";

        if (mysqli_query($conn, $sql)) {

            foreach ($Especialidades as $espID) {
                $espID = (int)$espID;
                if($espID){
                    $res = mysqli_query($conn, "SELECT Nom_Especialidad, Descripcion, Fecha_Esp FROM especialidad WHERE ID_Especialidad='$espID'");
                    $esp = mysqli_fetch_assoc($res);
                    if($esp){
                        mysqli_query($conn, "INSERT INTO especialidad (Nom_Especialidad, Cedula_D, Descripcion, Fecha_Esp)
                                             VALUES ('{$esp['Nom_Especialidad']}', '$Cedula_D', '{$esp['Descripcion']}', '{$esp['Fecha_Esp']}')");
                    }
                }
            }

            echo "<script>alert('Doctor y especialidades agregadas correctamente');window.location.href='../PaginaDeMedicos.php';</script>";
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Por favor completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Doctor</title>
  <link rel="stylesheet" href="../estiloL.css">
  <link rel="stylesheet" href="../Estilo.css">
</head>
<body>

<div class="cuadrado">
  <div class="titulo">
    <h1>Agregar Doctor</h1>
  </div>
  <div class="info-paciente">
    <form method="POST" action="">
        Nombre: <input type="text" name="Nombre_D" required><br>
        Cédula: <input type="number" name="Cedula_D" required><br>
        Usuario: <input type="text" name="Usuario_D" required><br>
        Contraseña: <input type="text" name="Contraseña_D" required><br>
        Correo: <input type="email" name="Correo" required><br>
        Tel: <input type="number" name="Tel" required><br>
        Historial Médico: <input type="text" name="His_med" required><br>
        ID del Administrador: <input type="number" name="ID_Administrador" required><br><br>

        Especialidades:<br>
        <select name="Especialidades[]" multiple required>
            <?php foreach($especialidadesDB as $esp): ?>
                <option value="<?= $esp['ID_Especialidad'] ?>">
                    <?= $esp['Nom_Especialidad'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <button type="submit">Guardar</button>
        <button type="button" onclick="location.href='../PaginaDeMedicos.php'">Volver</button>
    </form>
  </div>
</div>

</body>
</html>
