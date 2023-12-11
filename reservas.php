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
    <title>Hacer Reserva</title>
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
    </nav>>

<!-- Contenido Principal -->
<div class="container mt-4">


    <!-- Formulario de Reserva -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Hacer Reserva</h5>

            <form id="formularioReserva" action="procesoReserva.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="restaurante">Restaurante:</label>
                    <select class="form-control" id="restaurante" name="id_restaurante" required>
                        <?php
                    
                        require_once 'db.php';

                    // Consulta SQL para obtener los restaurantes
                        $sqlRestaurantes = "SELECT id, nombre FROM restaurantes";
                        $resultRestaurantes = $conn->query($sqlRestaurantes);


                        while ($rowRestaurante = $resultRestaurantes->fetch_assoc()) {
                            $idRestaurante = $rowRestaurante['id'];
                            $nombreRestaurante = $rowRestaurante['nombre'];
                            echo "<option value='$idRestaurante'>$nombreRestaurante</option>";
                        }


                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control"  id="fecha" name="fecha" required>
                </div>
                <div class="form-group">
                    <label for="hora">Hora:</label>
                    <input type="time" class="form-control" id=" hora"name="hora" required>
                </div>
                <button type="submit" class="btn btn-primary">Hacer Reserva</button>
            </form>
            <a href="ver_reservas.php">Ver mis reservas</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
