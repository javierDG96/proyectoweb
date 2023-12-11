<?php
session_start();
require_once 'db.php';
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
    <title>Dejar Opinión</title>
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
                <h5 class="card-title">Deja tu Opinión</h5>

                <form id="formularioOpinion" action="procesoOpinion.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="opinion">Opinión:</label>
                        <textarea class="form-control" id="opinion" name="opinion" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="id_restaurante">Selecciona un Restaurante:</label>
                        <select class="form-control" id="id_restaurante" name="id_restaurante">
                            <?php



                    // Consulta SQL para obtener los restaurantes
                            $sqlRestaurantes = "SELECT id, nombre FROM restaurantes";
                            $resultRestaurantes = $conn->query($sqlRestaurantes);

                    // Mostrar opciones del menú desplegable
                            while ($rowRestaurante = $resultRestaurantes->fetch_assoc()) {
                                $idRestaurante = $rowRestaurante['id'];
                                $nombreRestaurante = $rowRestaurante['nombre'];
                                echo "<option value='$idRestaurante'>$nombreRestaurante</option>";
                            }


                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Opinión</button>
                </form>
                <p>¿Quieres ver las opiniones? <a href="listaOpiniones.php">Haz clic aquí</a>.</p>
                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                    <!-- Formulario de Modificación -->
                    <form id="formularioModificar" action="modificaropinion.php" method="POST">
                        <div class="form-group">
                            <label for="id_opinion_modificar">Selecciona una Opinión:</label>
                            <select class="form-control" id="id_opinion_modificar" name="id_opinion_modificar">
                             <?php
                             $servername = "web.c6ivyf6dwj1q.us-east-1.rds.amazonaws.com";
                             $username = "admin";
                             $password = "admin1234";
                             $database = "mi_restaurante";
                             $port = 3306; // Puerto por defecto para MySQL

                             // Crear conexión
                             $conn = new mysqli($servername, $username, $password, $database, $port);


                             if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }



                            

                        



                        // Consulta SQL para obtener las opiniones
                        $sqlOpiniones = "SELECT id, nombre FROM opiniones";

                        $resultOpiniones = $conn->query($sqlOpiniones);

                        // Mostrar opciones del menú desplegable
                        while ($rowOpinion = $resultOpiniones->fetch_assoc()) {

                           $idOpinion = $rowOpinion['id'];
                           $nombreOpinion = $rowOpinion['nombre'];
                           echo "<option value='$idOpinion'>$nombreOpinion</option>";
                       }


                       $conn->close();
                   ?>

               </select>
           </div>
           <div class="form-group">
            <label for="nuevo_nombre_opinion">Nuevo Nombre de la Opinión:</label>
            <input type="text" class="form-control" id="nuevo_nombre_opinion" name="nuevo_nombre_opinion" required>
        </div>
        <div class="form-group">
            <label for="nuevo_nombre_opinion">Nueva descripcion de la Opinión:</label>
            <input type="text" class="form-control" id="nuevo_nombre_opinion" name="nueva_descripcion_opinion" required>
        </div>
        <div class="form-group">
            <label for="nuevo_restaurante_opinion">Selecciona un Nuevo Restaurante:</label>
            <select class="form-control" id="nuevo_restaurante_opinion" name="nuevo_restaurante_opinion">
                <?php
                        // Vuelve a realizar la conexión y la consulta para obtener los restaurantes
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

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
        <button type="submit" class="btn btn-secondary">Modificar Opinión</button>
    </form>
    <!-- Formulario de Borrado -->
    <form id="formularioBorrar" action="borrarOpinion.php" method="POST">
        <div class="form-group">
            <label for="id_opinion_borrar">Selecciona una Opinión:</label>
            <select class="form-control" id="id_opinion_borrar" name="id_opinion_borrar">
               <?php
                        // Vuelve a realizar la conexión y la consulta para obtener las opiniones
               $conn = new mysqli($servername, $username, $password, $database, $port);

               if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $sqlOpiniones = "SELECT id, nombre FROM opiniones";
            $resultOpiniones = $conn->query($sqlOpiniones);

            while ($rowOpinion = $resultOpiniones->fetch_assoc()) {
                $idOpinion = $rowOpinion['id'];
                $nombreOpinion = $rowOpinion['nombre'];
                echo "<option value='$idOpinion'>$nombreOpinion</option>";
            }

            $conn->close();
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-danger">Borrar Opinión</button>
</form>
<?php endif; ?>

</div>



</div>

</div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
