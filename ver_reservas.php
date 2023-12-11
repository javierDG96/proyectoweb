<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

require_once 'db.php';

// Obtener el nombre de usuario y rol del usuario actual
$nombreUsuario = $_SESSION['usuario']['nombre_usuario'];
$rolUsuario = $_SESSION['usuario']['rol'];

// Consulta SQL para obtener el ID del usuario actual
$sqlIdUsuario = "SELECT id FROM usuarios WHERE usuario = '$nombreUsuario'";
$resultIdUsuario = $conn->query($sqlIdUsuario);

// Verificar si se obtuvo el ID del usuario
if ($resultIdUsuario && $rowIdUsuario = $resultIdUsuario->fetch_assoc()) {
    $idUsuario = $rowIdUsuario['id'];

    // Consulta SQL para obtener las reservas según el rol del usuario
    if ($rolUsuario === 'admin') {
        $sqlReservas = "SELECT * FROM reservas";
    } else {
        $sqlReservas = "SELECT * FROM reservas WHERE id_usuario = $idUsuario";
    }

    $resultReservas = $conn->query($sqlReservas);

} else {
    // Manejar el caso donde no se pudo obtener el ID del usuario
    echo "Error al obtener el ID del usuario.";
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
</head>
<body>

    <!-- Menú de navegación -->
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
                <li class="nav-item ">
                    <a class="nav-link" href="restaurantes.php">Restaurantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="opiniones.php">Opiniones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="incidencias.php">Incidencias</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="reservas.php">Reservas</a>
                </li>
                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrar Restaurantes
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="editar_restaurantes.php">CRUD Restaurantes</a>
                            <a class="dropdown-item" href="editar_platos.php">CRUD Platos</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <!-- Contenido Principal -->
   <div class="container mt-4">

        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Lista de Reservas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                <!-- Tabla de Reservas -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Usuario</th>
                            <th>ID Restaurante</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <?php if ($rolUsuario === 'admin'): ?>
                                <!-- Columnas adicionales para admin -->
                                <th>Modificar</th>
                                <th>Eliminar</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowReserva = $resultReservas->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $rowReserva['id'] . '</td>';
                            echo '<td>' . $rowReserva['nombre'] . '</td>';
                            echo '<td>' . $rowReserva['id_restaurante'] . '</td>';
                            echo '<td>' . $rowReserva['fecha'] . '</td>';
                            echo '<td>' . $rowReserva['hora'] . '</td>';
                            if ($rolUsuario === 'admin') {
                                // Enlaces o botones para modificar y eliminar
                                echo '<td><a href="modificar_reserva.php?id=' . $rowReserva['id'] . '">Modificar</a></td>';
                                echo '<td><a href="eliminar_reserva.php?id=' . $rowReserva['id'] . '">Eliminar</a></td>';
                            }
                            echo '</tr>';

                        }
                        ?>
                        <a class="nav-link" href="reservas.php">Volver</a>
                    </tbody>
                </table>
            </div>

            </div>
        </div>

    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
