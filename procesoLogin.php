<?php
session_start();
require_once 'db.php'; 

function iniciarSesion($nombreUsuario, $contrasena, $conn) {
    // Consulta para verificar las credenciales en la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = '$nombreUsuario' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $_SESSION['usuario'] = [
            'nombre_usuario' => $usuario['usuario'],
            'rol' => $usuario['rol']
        ];
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasena = $_POST['contrasena'];

    if (iniciarSesion($nombreUsuario, $contrasena, $conn)) {
        // Redirigir al usuario después del inicio de sesión
        header('Location: bienvenida.php');
        exit();
    } else {
        $mensajeError = 'Nombre de usuario o contraseña incorrectos.';
    }
}
?>
