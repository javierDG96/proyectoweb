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
</nav>
<?php
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    // Consulta SQL para obtener los detalles de la reserva
    $sqlReserva = "SELECT * FROM reservas WHERE id = $idReserva";
    $resultReserva = $conn->query($sqlReserva);

    if ($resultReserva && $resultReserva->num_rows > 0) {
        $rowReserva = $resultReserva->fetch_assoc();

        // Consulta SQL para obtener la lista de restaurantes
        $sqlRestaurantes = "SELECT id, nombre FROM restaurantes";
        $resultRestaurantes = $conn->query($sqlRestaurantes);


        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Modificar Reserva</h5>';

// Formulario para modificar la reserva
        echo '<form action="proceso_modificar_reserva.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $idReserva . '">';

// Inicio de la tabla
        echo '<table class="table">';
        echo '<tr>';
        echo '<th>Nombre:</th>';
        echo '<td><input type="text" name="nombre" value="' . $rowReserva['nombre'] . '" required></td>';
        echo '</tr>';

// Campo Restaurante
        echo '<tr>';
        echo '<th>Restaurante:</th>';
        echo '<td>';
        echo '<select name="id_restaurante" required>';
        while ($rowRestaurante = $resultRestaurantes->fetch_assoc()) {
            $selected = ($rowRestaurante['id'] == $rowReserva['id_restaurante']) ? 'selected' : '';
            echo '<option value="' . $rowRestaurante['id'] . '" ' . $selected . '>' . $rowRestaurante['nombre'] . '</option>';
        }
        echo '</select>';
        echo '</td>';
        echo '</tr>';

// Campo Fecha
        echo '<tr>';
        echo '<th>Fecha:</th>';
        echo '<td><input type="date" name="fecha" value="' . $rowReserva['fecha'] . '" required></td>';
        echo '</tr>';

// Campo Hora
        echo '<tr>';
        echo '<th>Hora:</th>';
        echo '<td><input type="time" name="hora" value="' . $rowReserva['hora'] . '" required></td>';
        echo '</tr>';

echo '</table>'; // Fin de la tabla

echo '<button type="submit" class="btn btn-primary">Guardar cambios</button>';
echo '</form>';

echo '</div>'; // Fin del cuerpo de la carta
echo '</div>'; // Fin de la carta


} else {
    echo "No se encontró la reserva.";
}

    // Cerrar la conexión a la base de datos
$conn->close();

} else {
    echo "ID de reserva no proporcionado.";
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>