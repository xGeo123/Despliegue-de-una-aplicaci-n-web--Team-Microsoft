<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar estadocivil</title>
</head>
<body>

<h1>Editar </h1>
 <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            padding: 40px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
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
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #28a745; /* Verde para actualizar */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px; /* Espacio para el enlace Volver */
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
        
        /* Estilo para el enlace 'Volver' */
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
<form action="/public/estadocivil/update" method="POST">
    <input type="hidden" name="idestadocivil" value="<?php echo htmlspecialchars($estadocivil['idestadocivil']); ?>">
    
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($estadocivil['nombre']); ?>" required>
    
    <input type="submit" value="Actualizar">
</form>

<a href="index">Volver al listado</a>

</body>
</html>
