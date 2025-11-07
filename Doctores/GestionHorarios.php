<?php
session_start();
include '../Base de datos/Conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'medico') {
    header("Location: ../login.html");
    exit();
}

$usuario_sesion = $_SESSION['usuario'];


$stmt = $conn->prepare("SELECT Cedula_D, Nombre_D FROM doctor WHERE Usuario_D=?");
$stmt->bind_param("s", $usuario_sesion);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$cedula_doctor = $row['Cedula_D'];
$nombre_doctor = $row['Nombre_D'];

$fecha_limite = date('Y-m-d', strtotime('-2 days'));
$delete = $conn->prepare("DELETE FROM consulta WHERE Cedula_D=? AND Fecha_Consulta < ?");
$delete->bind_param("is", $cedula_doctor, $fecha_limite);
$delete->execute();

$fechaSeleccionada = isset($_GET['fecha']) ? $_GET['fecha'] : '';


if(isset($_POST['fecha'], $_POST['hora_inicio'], $_POST['hora_fin'])){
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $inicio = strtotime($hora_inicio);
    $fin = strtotime($hora_fin);

    while($inicio < $fin){
        $horaTurno = date('H:i:s', $inicio);

        
        $check = $conn->prepare("SELECT * FROM consulta WHERE Cedula_D=? AND Fecha_Consulta=? AND Horario=?");
        $check->bind_param("iss", $cedula_doctor, $fecha, $horaTurno);
        $check->execute();

        if($check->get_result()->num_rows == 0){
            $sql = "INSERT INTO consulta (Cedula_D, ID_Especialidad, Fecha_Consulta, Horario, Estado) 
                    VALUES (?, 1, ?, ?, 'Disponible')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $cedula_doctor, $fecha, $horaTurno);
            $stmt->execute();
        }

        $inicio = strtotime('+30 minutes', $inicio);
    }

    echo "<script>alert('Horarios agregados correctamente');</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Horarios</title>
    <link rel="stylesheet" href="../Administradores/estiloL.css">
    <link rel="stylesheet" href="../Administradores/Estilo.css">
    <style>
        .cuadrado { max-width: 800px; margin: 20px auto; padding: 20px; background:  #082c6c; border-radius: 10px; }
        .titulo h1 { text-align: center; color: white; }
        .formulario-horario label { display: block; margin: 10px 0; color:white; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid white; padding: 8px; text-align: center; color:white; }
        table th { background-color: #c4ad5c; color: white; }
        button { background-color:  #c4ad5c; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px; }
        button:hover { background-color: #2980b9; }
    </style>
</head>
<body>

<div class="cuadrado">
    <div class="titulo">
        <h1>Gestión de Horarios - <?php echo htmlspecialchars($nombre_doctor); ?></h1>
    </div>

    <div class="formulario-horario">
        <h2 style="color:white;">Agregar horario disponible</h2>
        <form method="post">
            <label>Fecha: 
                <input type="date" name="fecha" value="<?php echo htmlspecialchars($fechaSeleccionada); ?>" required>
            </label>
            <label>Hora de inicio: 
                <input type="time" name="hora_inicio" required>
            </label>
            <label>Hora de fin: 
                <input type="time" name="hora_fin" required>
            </label>
            <button type="submit">Agregar</button>
        </form>
    </div>

    <div class="lista-horarios">
        <h2 style="color:white;">Horarios existentes</h2>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
            <?php
            $sql = "SELECT ID_Consulta, Fecha_Consulta, Horario, Estado 
                    FROM consulta 
                    WHERE Cedula_D=? 
                    ORDER BY Fecha_Consulta, Horario";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $cedula_doctor);
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>{$row['Fecha_Consulta']}</td>
                        <td>{$row['Horario']}</td>
                        <td>{$row['Estado']}</td>
                        <td>
                            <form method='post' action='CancelarTurno.php' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['ID_Consulta']}'>
                                <button type='submit' onclick='return confirm(\"¿Cancelar este turno?\");'>Cancelar</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <div style="text-align:center; margin-top:20px;">
        <button onclick="location.href='Pag_Medico.php'">Volver</button>
    </div>
</div>

</body>
</html>

