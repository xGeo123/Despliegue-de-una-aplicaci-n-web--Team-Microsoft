<?php
    // Define la ruta base para que los enlaces y el 'action' del formulario funcionen
    $basePath = '/public/'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Teléfono</title>
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
            margin-bottom: 20px; /* Espacio para Volver */
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
</head>
<body>

<div class="form-container">
    <h2>Actualizar Teléfono</h2>
    <!-- ACTION CORREGIDO: Apunta a la ruta 'telefono/update' -->
    <form action="<?php echo $basePath; ?>telefono/update" method="POST">

        <!-- ID oculto del teléfono -->
        <input type="hidden" name="idtelefono" value="<?php echo htmlspecialchars($telefono['idtelefono'] ?? ''); ?>">

        <label for="idpersona">Persona:</label>
        <select name="idpersona" id="idpersona" required>
            <option value="">Seleccione una persona</option>
             <?php if (!empty($personas) && is_array($personas)): ?>
                <?php foreach ($personas as $persona): ?>
                    <option value="<?php echo htmlspecialchars($persona['idpersona']); ?>" 
                        <?php echo isset($telefono['idpersona']) && $persona['idpersona'] == $telefono['idpersona'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($persona['apellidos'] . ' ' . $persona['nombres']); ?>
                    </option>
                <?php endforeach; ?>
             <?php else: ?>
                 <option value="">No hay personas disponibles</option>
            <?php endif; ?>
        </select>

        <label for="numero">Número de Teléfono:</label>
        <input type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($telefono['numero'] ?? ''); ?>" required>

        <input type="submit" value="Actualizar Teléfono">
    </form>
    
    <!-- Enlace Volver -->
    <a href="<?php echo $basePath; ?>telefono">Volver al listado</a>
</div>

</body>
</html>
