<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
    $idIncidenciaModificar = $_POST["id_incidencia_modificar"];
    $nuevaDescripcion = $_POST["nueva_descripcion"];
    $nuevoIdRestaurante = $_POST["nuevo_id_restaurante"];

    // Consulta SQL para actualizar la incidencia
    $sqlUpdateIncidencia = "UPDATE incidencias SET descripcion = '$nuevaDescripcion', id_restaurante = '$nuevoIdRestaurante' WHERE id = $idIncidenciaModificar";

    if ($conn->query($sqlUpdateIncidencia) === TRUE) {
        echo "Incidencia actualizada con éxito.";
        header("Location: ver_incidencias.php");
    } else {
        echo "Error al actualizar la incidencia: " . $conn->error;
    }
}

// Obtener la incidencia a modificar
if (isset($_GET['id'])) {
    $idIncidencia = $_GET['id'];

    $sqlGetIncidencia = "SELECT * FROM incidencias WHERE id = $idIncidencia";
    $resultGetIncidencia = $conn->query($sqlGetIncidencia);

    if ($resultGetIncidencia->num_rows > 0) {
        $rowIncidencia = $resultGetIncidencia->fetch_assoc();
    } else {
        echo "Incidencia no encontrada.";
        exit();
    }
} else {
    echo "ID de incidencia no proporcionado.";
    exit();
}

// Obtener la lista de restaurantes
$sqlRestaurantes = "SELECT id, nombre FROM restaurantes";
$resultRestaurantes = $conn->query($sqlRestaurantes);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilo.css">
    <title>Modificar incidencias</title>
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
     <div class="container mt-4">

        <!-- Carta para mostrar formulario de modificación -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Modificar Incidencia</h5>
            </div>
            <div class="card-body">

                <!-- Formulario de Modificación -->
                <form method="POST">
                    <input type="hidden" name="id_incidencia_modificar" value="<?php echo $rowIncidencia['id']; ?>">
                    <div class="form-group">
                        <label for="nueva_descripcion">Nueva Descripción:</label>
                        <textarea class="form-control" id="nueva_descripcion" name="nueva_descripcion" rows="4" required><?php echo $rowIncidencia['descripcion']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nuevo_id_restaurante">Nuevo Restaurante:</label>
                        <select class="form-control" id="nuevo_id_restaurante" name="nuevo_id_restaurante">
                            <?php
                            while ($rowRestaurante = $resultRestaurantes->fetch_assoc()) {
                                $idRestaurante = $rowRestaurante['id'];
                                $nombreRestaurante = $rowRestaurante['nombre'];
                                $selected = ($idRestaurante == $rowIncidencia['id_restaurante']) ? 'selected' : '';
                                echo "<option value='$idRestaurante' $selected>$nombreRestaurante</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="modificar">Modificar Incidencia</button>
                </form>

            </div>
        </div>

    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
