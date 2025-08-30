<?php
session_start();//Permite almacenar datos del usuario ($_SESSION) que estarán disponibles en otras páginas mientras dure la sesión.

//creo loas variables para poder conectarme con mySQL 
$host = "localhost"; 
$user = "root";
$pass = "";
$db   = "basededatos";

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
//toma los valores enviados por post desde el formulario usuario y contrasena (que esta en el html).
$usuario    = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($usuario) || empty($contrasena)) {
    die("Debe ingresar usuario y contraseña.");
}
//se prepara una consulta segura (prepare) para evitar inyección SQL (evita que nos manipulen la base de datos).
//"ss" indica que ambos parámetros(contraseña y usuario) son strings

$stmt = $conn->prepare("SELECT Contraseña_P, Usuario_P FROM paciente WHERE Usuario_P=? AND Contraseña_P=?");
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$result = $stmt->get_result();
//si se encuentra exactamente 1 fila (num_rows === 1), significa que el usuario y la contraseña coinciden
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $_SESSION['perfil'] = 'paciente';
    $_SESSION['id'] = $row['Contraseña_P'];
    $_SESSION['usuario'] = $row['Usuario_P'];
    header("Location: ../Pacientes/SegundaPagina.html");
    exit;
    }
$stmt->close();

//Igual que la seccion de paciente, pero verifica en la tabla doctor.
$stmt = $conn->prepare("SELECT Contraseña_D, Usuario_D FROM doctor WHERE Usuario_D=? AND Contraseña_D=?");
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $_SESSION['perfil'] = 'medico';
    $_SESSION['id'] = $row['Contraseña_D'];
    $_SESSION['usuario'] = $row['Usuario_D'];
    header("Location: ../Doctores/Pag_Medico.html");
    exit;
}
$stmt->close();

$stmt = $conn->prepare("SELECT Contraseña_A, Usuario_A FROM administrador WHERE Usuario_A=? AND Contraseña_A=?");
$stmt->bind_param("ss", $usuario, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $_SESSION['perfil'] = 'administrador';
    $_SESSION['id'] = $row['Contraseña_A'];
    $_SESSION['usuario'] = $row['Usuario_A'];
    header("Location: ../Administradores/Pag_Admin.html");
    exit;
    }
$stmt->close();
//se cierra la conexión a la base de datos.
//Si ninguna de las consultas anteriores encontró coincidencias, se muestra un mensaje, este mensaje va a indicar que los datos son incorrectos.
$conn->close();
echo "Usuario o contraseña incorrectos.";
?>
