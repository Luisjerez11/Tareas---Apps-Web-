<?php

session_start();

# Verificar si el usuario inició sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

# Establecer código HTTP 400
http_response_code(400);

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Error 400</title>
    </head>

    <body>

        <h1>Error 400 - Bad Request</h1>

        <h3>
            Bienvenido <?php echo htmlspecialchars($_SESSION['nombre']); ?>
        </h3>

        <p>Los datos ingresados no son válidos.</p>

        <p>
            <a href="registrar.php">Regresar al formulario</a>
        </p>

        <p>
            <a href="cerrar_sesion.php">Cerrar Sesion</a>
        </p>

    </body>
</html>
