<?php

require_once 'db.php';

// Consulta SQL para obtener las opiniones
$sqlOpiniones = "SELECT o.nombre AS nombre_opinion, o.descripcion, r.nombre AS nombre_restaurante 
FROM opiniones o
JOIN restaurantes r ON o.id_restaurante = r.id";
$resultOpiniones = $conn->query($sqlOpiniones);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Lista de Opiniones</title>
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
                <li class="nav-item ">
                    <a class="nav-link" href="restaurantes.php">Restaurantes</a>
                </li>
                <li class="nav-item active">
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

    <!-- Contenido Principal -->
    <div class="container mt-4">
        <h1 class="bienvenida">Lista de Opiniones</h1>

        <!-- Cartas de Opiniones -->
        <div class="card-columns">
            <?php
           // Mostrar cartas de opiniones
            while ($rowOpinion = $resultOpiniones->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo "<h5 class='card-title'>{$rowOpinion['nombre_opinion']} en {$rowOpinion['nombre_restaurante']}</h5>";
                echo "<p class='card-text'>{$rowOpinion['descripcion']}</p>";
                echo '</div>';
                echo '</div>';
            }

            ?>
             <a class="nav-link" href="opiniones.php">Volver</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
