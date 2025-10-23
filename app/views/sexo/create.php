<?php
// Define la ruta base para que los enlaces y el 'action' del formulario funcionen
$basePath = '/public/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Estado Civil</title>
    <!-- Aquí puedes añadir CSS si lo tienes -->
</head>
<body>
    <h1>Crear Nuevo Estado Civil</h1>
    
    <!-- El 'action' usa la variable $basePath para apuntar a la ruta correcta -->
    <form action="<?php echo $basePath; ?>estadocivil/store" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <input type="submit" value="Crear Estado Civil">
    </form>

    <br>
    <!-- El enlace 'Volver' también usa $basePath -->
    <a href="<?php echo $basePath; ?>estadocivil">Volver al listado</a>
</body>
</html>

