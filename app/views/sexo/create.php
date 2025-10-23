<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Sexo</title>
</head>
<body>
    <h1>Crear Nuevo Sexo</h1>
    
    <form action="/public/sexo/store" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <input type="submit" value="Crear">
    </form>

    <a href="/public/sexo">Volver al listado</a>
</body>
</html>