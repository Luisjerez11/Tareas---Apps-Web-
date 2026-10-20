<?php

session_start();
require_once "conexion.php";

# Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

# Obtener el ID de la incidencia enviado por GET
$id_incidencia = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
]);

$incidencia = false;

if ($id_incidencia !== false) {

    # Buscar la incidencia solo si pertenece al usuario logeado
    $sql = "SELECT * FROM incidencia
            WHERE id_incidencia = :id_incidencia AND id_usuario = :id_usuario";

    $consulta = $conexion->prepare($sql);
    $consulta->execute([
        ':id_incidencia' => $id_incidencia,
        ':id_usuario' => $_SESSION['id_usuario']
    ]);

    $incidencia = $consulta->fetch(PDO::FETCH_ASSOC);
}

# Si la incidencia no existe se responde con 404
if (!$incidencia) {
    http_response_code(404);
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalle de Incidencia</title>
    </head>

    <body>

        <h1>Sistema de Tickets de Incidencias</h1>

        <h2>Detalle de la Incidencia</h2>
        
        <h3>
            Bienvenido <?php echo htmlspecialchars($_SESSION['nombre']); ?>
        </h3>

        <p>
            <a href="cerrar_sesion.php">Cerrar Sesion</a>
        </p>

        <hr>


        <?php if ($incidencia) { ?>

        <table border="1">
            <tr>
                <th>ID</th>
                <td><?php echo $incidencia['id_incidencia']; ?></td>
            </tr>

            <tr>
                <th>Nombre</th>
                <td><?php echo htmlspecialchars($incidencia['nombre']); ?></td>
            </tr>

            <tr>
                <th>Descripción</th>
                <td><?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></td>
            </tr>

            <tr>
                <th>Prioridad</th>
                <td><?php echo htmlspecialchars(ucfirst($incidencia['prioridad'])); ?></td>
            </tr>
        </table>

        <?php } else { ?>

        <p>La incidencia no existe</p>

        <?php } ?>

        <br>

        <a href="listar.php">Regresar al listado</a>

    </body>
</html>
