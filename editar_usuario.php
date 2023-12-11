<?php
session_start();
require_once 'db.php';

// Verificar si se ha proporcionado un ID en la URL
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Consultar la información del usuario
    $sql = "SELECT * FROM usuarios WHERE id = $idUsuario";
    $result = $conn->query($sql);

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        // Redirigir o manejar el caso cuando no se encuentra el usuario
        header("Location: lista_usuarios.php");
        exit();
    }
} else {
    // Redirigir o manejar el caso cuando no se proporciona un ID
    header("Location: lista_usuarios.php");
    exit();
}

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevoUsuario = $_POST["nuevo_usuario"];
    $nuevoEmail = $_POST["nuevo_email"];
    $nuevaContrasena = $_POST["nueva_contrasena"];
    $nuevoRol = $_POST["nuevoRol"];

    // Actualizar la información del usuario en la base de datos
    $sqlUpdate = "UPDATE usuarios SET usuario = '$nuevoUsuario', email = '$nuevoEmail', contrasena = '$nuevaContrasena', rol = '$nuevoRol' WHERE id = $idUsuario";

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Usuario actualizado con éxito.";
        // Redirigir a la lista de usuarios u otra página después de la actualización
        header("Location: lista_usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Editar Usuario</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <a class="navbar-brand" href="index.php">Mis Restaurantes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="lista_usuarios.php">Usuarios</a>
                </li>
                
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="container mt-4">
        <div class="card">
    <div class="card-header">
        <h2 class="card-title">Editar Usuario</h2>
    </div>
    <div class="card-body">
        <!-- Formulario para insertar usuario -->
       <form method="POST">
    <div class="form-group">
        <label for="usuario">Nuevo nombre:</label>
        <input type="text" class="form-control" id="usuario" name="nuevo_usuario" required>
    </div>
    <div class="form-group">
        <label for="email">Nuevo correo:</label>
        <input type="email" class="form-control" id="email" name="nuevo_email" required>
    </div>
    <div class="form-group">
        <label for="contrasena">Nueva Contraseña:</label>
        <input type="password" class="form-control" id="contrasena" name="nueva_contrasena" required>
    </div>
    <div class="form-group">
        <label for="rol">Nuevo Rol:</label>
        <select class="form-control" id="rol" name="nuevoRol">
            <option value="admin">Administrador</option>
            <option value="usuario">Usuario</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
</form>

    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
