<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Sexo</title>
</head>
<body>

<h1>Eliminar</h1>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
        }

        .form-container {
            background-color: #ffffff;
            max-width: 500px;
            margin: auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #dc3545; /* Color rojo para eliminar */
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: #e9ecef; /* Fondo gris para campo 'readonly' */
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #dc3545; /* Botón rojo para 'Eliminar' */
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px; /* Espacio para el enlace 'Volver' */
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }
        
        .form-container p {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container a {
            display: block;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
<form action="/public/sexo/delete" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($sexo['id']); ?>">
    
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($sexo['nombre']); ?>" required>
    
    <input type="submit" value="Eliminar">
</form>

<a href="index.php">Volver al listado</a>

</body>
</html>
