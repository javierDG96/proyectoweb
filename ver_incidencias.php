<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Ver incidencias</title>
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
            <li class="nav-item active">
                <a class="nav-link" href="incidencias.php">Incidencias</a>
            </li>
            <li class="nav-item">
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

        <!-- Verificación de rol de usuario -->
        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <!-- Carta para mostrar incidencias -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Lista de Incidencias</h5>
                </div>
                <div class="card-body">

                    <!-- Tabla para mostrar incidencias con opciones de modificar y eliminar -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Restaurante</th>
                                <th>Incidencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            require_once 'db.php';

                            // Consulta SQL para obtener las incidencias
                            $sqlIncidencias = "SELECT i.id, r.nombre AS restaurante, i.descripcion
                                               FROM incidencias i
                                               JOIN restaurantes r ON i.id_restaurante = r.id";

                            $resultIncidencias = $conn->query($sqlIncidencias);

                            // Mostrar las incidencias en la tabla
                            while ($rowIncidencia = $resultIncidencias->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$rowIncidencia['id']}</td>";
                                echo "<td>{$rowIncidencia['restaurante']}</td>";
                                echo "<td>{$rowIncidencia['descripcion']}</td>";
                                echo "<td><a href='modificar_incidencia.php?id={$rowIncidencia['id']}'>Modificar</a> | 
                                          <a href='eliminar_incidencia.php?id={$rowIncidencia['id']}'>Eliminar</a></td>";
                                echo "</tr>";
                            }

                            
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                     <a class="nav-link" href="incidencias.php">Volver</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Mensaje para usuarios no administradores -->
            <p>No tienes permisos para ver esta página.</p>
        <?php endif; ?>

    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
