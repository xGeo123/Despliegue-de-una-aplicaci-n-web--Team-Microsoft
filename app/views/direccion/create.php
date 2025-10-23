<?php
// Define la ruta base para que los enlaces y el 'action' del formulario funcionen
$basePath = '/public/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Direccion</title>
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
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px; /* Espacio para el enlace 'Volver' */
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
</head>
<body>

<div class="form-container">
    <!-- CORRECCIÓN: Etiqueta h2 cerrada correctamente -->
    <h2>Agregar Direccion</h2>
    
    <!-- 
      ACCIÓN CORREGIDA: 
      Debe apuntar a la RUTA '/public/direccion/store'
    -->
    <form action="<?php echo $basePath; ?>direccion/store" method="POST"> 
        <label for="idpersona">Persona:</label>
        <select name="idpersona" id="idpersona" required>
            <option value="">Seleccione una persona</option>
            <?php if (!empty($personas)): // Buena práctica: comprobar si $personas existe ?>
                <?php foreach ($personas as $persona): ?>
                    <option value="<?= $persona['idpersona'] ?>">
                        <?= htmlspecialchars($persona['apellidos'] . ' ' . $persona['nombres']) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <label for="nombre">Direccion:</label>
        <input type="text" name="nombre" id="nombre" required>

        <input type="submit" value="Guardar Direccion">
    </form>

    <!-- Enlace para Volver -->
    <a href="<?php echo $basePath; ?>direccion">Volver al listado</a>
</div>

</body>
</html>
