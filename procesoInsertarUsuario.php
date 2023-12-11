<?php
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rolbd"];


    // Consulta SQL para insertar el usuario en la base de datos
    $sqlInsertUsuario = "INSERT INTO usuarios (usuario, email, contrasena, rol) VALUES ('$usuario', '$email', '$contrasena', '$rol')";

    // Ejecutar la consulta
    if ($conn->query($sqlInsertUsuario) === TRUE) {
        // Mensaje de éxito
        echo "Inserción exitosa. Redirigiendo...";
        
        // Redirigir al listado de usuarios después de 2 segundos
        header("refresh:2;url=lista_usuarios.php");
        exit();
    } else {
        echo "Error al insertar el usuario: " . $conn->error;
    }
} else {
    echo "Acceso no autorizado.";
}

$conn->close();
?>
