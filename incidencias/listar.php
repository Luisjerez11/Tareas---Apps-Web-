<?php

session_start();
require_once "conexion.php";

# Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

# Obtener los datos del usuario logeado
$id_usuario = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];

# Consultar las incidencias del usuario en la BDD
$sql = "SELECT * FROM incidencia WHERE id_usuario = :id_usuario";

$consulta = $conexion->prepare($sql);
$consulta->execute([':id_usuario' => $id_usuario]);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Listado de Incidencias</title>
    </head>

    <body>

        <h1>Sistema de Tickets de Incidencias</h1>

        <h2>Panel Principal</h2>

        <h3>
            Bienvenido <?php echo htmlspecialchars($nombre); ?>
        </h3>

        <p>
            <a href="cerrar_sesion.php">Cerrar Sesion</a>
        </p>

        <hr>

        <h2>Mis Incidencias</h2>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
            </tr>

            <?php
            # Recorrer las incidencias encontradas
            while ($incidencia = $consulta->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <tr>
                <td>
                    <?php echo $incidencia['id_incidencia']; ?>
                </td>

                <td>
                    <a href="detalle.php?id=<?php echo $incidencia['id_incidencia']; ?>">
                        <?php echo htmlspecialchars($incidencia['nombre']); ?>
                    </a>
                </td>
            </tr>

            <?php
            }
            ?>

        </table>

        <br>

        <a href="registrar.php">Registrar nueva incidencia</a>

    </body>
</html>
