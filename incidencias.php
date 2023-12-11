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
    <title>Dejar Incidencia</title>
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


    <!-- Formulario de Opinión -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Resgistra una incidencia</h5>

            <form id="formularioIncidencia" action="procesoIncidencia.php" method="POST">
               <div class="form-group">
                <label for="id_restaurante">Selecciona un Restaurante:</label>
                <select class="form-control" id="id_restaurante" name="id_restaurante">
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
                <label for="opinion">Incidencia:</label>
                <textarea class="form-control" id="opinion" name="descripcion" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" >Enviar incidencia</button>
        </form>
        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>

            <a class="nav-link" href="ver_incidencias.php">Ver Incidencias</a>

        <?php endif; ?>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>