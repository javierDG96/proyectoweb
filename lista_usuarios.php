<?php
session_start();
require_once 'db.php';

// Verificar si el usuario tiene permisos de administrador
if ($_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Consulta SQL para obtener todos los usuarios
$sqlUsuarios = "SELECT id, usuario, email, contrasena, rol FROM usuarios";
$resultUsuarios = $conn->query($sqlUsuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Usuarios</title>
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
                    <a class="nav-link" href="restaurantes.php ?>">Restaurantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="opiniones.php">Opiniones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservas.php">Reservas</a>
                </li>
            </ul>
        </div>
    </nav>
</nav>

<div class="container mt-4">
    
    <div class="card">
        <div class="card-body">
            <h2>Lista de Usuarios</h2>
            <div class="table-responsive">
            <!-- Tabla de Usuarios -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Usuario</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rowUsuario = $resultUsuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $rowUsuario['id']; ?></td>
                            <td><?php echo $rowUsuario['usuario']; ?></td>
                            <td><?php echo $rowUsuario['email']; ?></td>
                            <td><?php echo $rowUsuario['contrasena']; ?></td>
                            <td><?php echo $rowUsuario['rol']; ?></td>
                            <td>
                                <a href="editar_usuario.php?id=<?php echo $rowUsuario['id']; ?>">Editar</a>
                                <a href="borrar_usuario.php?id=<?php echo $rowUsuario['id']; ?>">Borrar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

            <!-- Enlace para insertar nuevo usuario -->
            <a href="insertarUsuario.html" class="btn btn-success">Insertar Nuevo Usuario</a>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
