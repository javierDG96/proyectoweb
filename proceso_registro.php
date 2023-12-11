<?php
// Verificar si se reciben datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol']; 

    

    
    require_once 'db.php';

   
   

    // Consulta SQL para insertar el nuevo usuario
    $sqlInsertarUsuario = "INSERT INTO usuarios (usuario, email, contrasena, rol) VALUES ('$nombre', '$email', '$contrasena', '$rol')";

    if ($conn->query($sqlInsertarUsuario) === TRUE) {
        // Registro exitoso, puedes redirigir al usuario a alguna página
        header('Location: registro.html');
        exit();
    } else {
        // Error al registrar el usuario
        echo "Error: " . $sqlInsertarUsuario . "<br>" . $conn->error;
    }

    
    $conn->close();
} else {
    // Si no se reciben datos por POST, redirige al formulario de registro
    header('Location: registro.html');
    exit();
}
?>
