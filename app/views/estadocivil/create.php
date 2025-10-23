<?php
// Define la ruta base para que los enlaces y el 'action' del formulario funcionen
$basePath = '/public/';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Estado Civil</title>
    <!-- Estilos tomados de tu formulario de Teléfono -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
            margin: 0;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 { /* Cambiado de h2 a h1 */
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        select {
            width: 100%;
            box-sizing: border-box; /* Añadido para padding correcto */
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px; /* Añadido espacio antes del enlace 'Volver' */
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        a {
            display: block;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Crear Nuevo Estado Civil</h1>
        
        <!-- 
          ACCIÓN CORREGIDA: 
          Debe apuntar a la RUTA '/public/estadocivil/store' 
          y NO al archivo del controlador.
        -->
        <form action="<?php echo $basePath; ?>estadocivil/store" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            
            <input type="submit" value="Crear Estado Civil">
        </form>

        <!-- El enlace 'Volver' también usa $basePath -->
        <a href="<?php echo $basePath; ?>estadocivil">Volver al listado</a>
    </div>
</body>
</html>

