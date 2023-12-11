<?php
session_start();
require_once 'db.php';
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
    




<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Verificar si se proporcionó la especialidad en la URL
if (isset($_POST['especialidad'])) {
    $especialidadSeleccionada = $_POST['especialidad'];

    if ($especialidadSeleccionada === 'todas') {
        // Si se selecciona "Todas las Especialidades", obtener todos los restaurantes y sus platos
        $sql = "SELECT r.id as restaurante_id, r.nombre as restaurante_nombre, p.id as plato_id, p.nombre as plato_nombre FROM restaurantes r LEFT JOIN platos p ON r.id = p.id_restaurante";
    } else {
        // Consulta SQL para obtener los restaurantes y sus platos según la especialidad seleccionada
        $sql = "SELECT r.id as restaurante_id, r.nombre as restaurante_nombre, p.id as plato_id, p.nombre as plato_nombre FROM restaurantes r LEFT JOIN platos p ON r.id = p.id_restaurante LEFT JOIN especialidades e ON r.id=e.id_restaurante WHERE e.id = $especialidadSeleccionada";
    }

    $result = $conn->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Iniciar una variable para rastrear el restaurante actual
        $restauranteActual = null;
        // Array para almacenar información sobre los restaurantes
        $restaurantes = array();

        // Iterar sobre los resultados
        while ($row = $result->fetch_assoc()) {
            $idRestaurante = $row['restaurante_id'];
            $nombreRestaurante = $row['restaurante_nombre'];
            $idPlato = $row['plato_id'];
            $nombrePlato = $row['plato_nombre'];

            // Agregar información del plato al restaurante correspondiente en el array
            $restaurantes[$idRestaurante]['nombre'] = $nombreRestaurante;
            $restaurantes[$idRestaurante]['platos'][] = $nombrePlato;
        }

        // Imprimir la información almacenada en el array
        foreach ($restaurantes as $restaurante) {
            echo '<div class="card mt-3">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $restaurante['nombre'] . '</h5>';
            echo '<ul>';
            
            foreach ($restaurante['platos'] as $plato) {
                echo '<li>' . $plato . '</li>';
            }

            echo '</ul>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // Mostrar mensaje si no hay restaurantes disponibles para esta especialidad
        echo 'No hay restaurantes disponibles para esta especialidad.';
    }
} else {
    // Mostrar mensaje de error si no se proporcionó la especialidad
    echo 'Error: No se proporcionó la especialidad.';
}

$conn->close();
?>


