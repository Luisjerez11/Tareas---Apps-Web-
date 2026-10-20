
<?php

session_start();

# Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

# Establecer código de respuesta HTTP 201
http_response_code(201);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Incidencia Creada</title>
    </head>

    <body>

        <h1>Incidencia Creada - 201 Created</h1>

        <h3>
            Bienvenido <?php echo htmlspecialchars($_SESSION['nombre']); ?>
        </h3>

        <p>La incidencia fue registrada correctamente.</p>

        <p>
            <a href="listar.php">Ver mis incidencias</a>
        </p>

        <p>
            <a href="cerrar_sesion.php">Cerrar Sesion</a>
        </p>

    </body>
</html>
