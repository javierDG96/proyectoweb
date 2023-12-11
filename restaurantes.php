<?php
session_start();
require_once 'db.php';
// Verifica si la sesión está iniciada
if (!isset($_SESSION['usuario'])) {
    // La sesión no está iniciada, redirige a la página de inicio de sesión
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
    <title>Restaurantes</title>
</head>
<body>

    <!-- Barra de Navegación -->
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
                    <a class="nav-link" href="restaurantes.php">Restaurantes</a>
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
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h1 class="bienvenida">Listado de restaurantes</h1>
                       <form action="obtener_restaurantes.php" method="POST">
                        <div class="form-group">
                            <label for="categoria">Filtrar por Categoría:</label>
                            
                            <?php
                            


                            // Consulta SQL para obtener las especialidades desde la tabla especialidades
                            $sqlEspecialidades = "SELECT id, nombre FROM especialidades";
                            $resultEspecialidades = $conn->query($sqlEspecialidades);

                            // Verificar si hay especialidades disponibles
                            if ($resultEspecialidades->num_rows > 0) {
                                echo '<select class="form-control" id="especialidad" name="especialidad">';
                                echo '<option value="todas">Todas las Especialidades</option>';

                            // Iterar sobre las filas y agregar opciones al select
                                while ($rowEspecialidad = $resultEspecialidades->fetch_assoc()) {
                                    $idEspecialidad = $rowEspecialidad['id'];
                                    $nombreEspecialidad = $rowEspecialidad['nombre'];

                                    echo "<option value='$idEspecialidad'>$nombreEspecialidad</option>";
                                }

                                echo '</select>';
								echo '<button type="submit" class="btn btn-primary mt-2">Filtrar</button>';
                            } else {
                                echo '<p>No hay especialidades disponibles.</p>';
                            }
                            ?>


                           
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
