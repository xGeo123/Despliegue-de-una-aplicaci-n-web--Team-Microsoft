<?php
// Define la ruta base para que los enlaces y el 'action' del formulario funcionen
$basePath = '/public/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Persona</title>
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
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28a745; /* Botón verde para 'Actualizar' */
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px; /* Espacio para el enlace 'Volver' */
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 20px;
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
        <h2>Editar Persona</h2>
        
        <!-- 
          ACCIÓN CORREGIDA: 
          Debe apuntar a la RUTA '/public/persona/update'
        -->
        <form action="<?php echo $basePath; ?>persona/update" method="POST">
            <!-- ID oculto -->
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">

            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" name="nombres" id="nombres" value="<?= htmlspecialchars($persona['nombres']) ?>" required>
            </div>

            <div class="form-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" value="<?= htmlspecialchars($persona['apellidos']) ?>" required>
            </div>

            <div class="form-group">
                <label for="fechanacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="fechanacimiento" id="fechanacimiento" value="<?= $persona['fechanacimiento'] ?>" required>
            </div>

            <div class="form-group">
                <label for="idsexo">Sexo:</label>
                <select name="idsexo" id="idsexo" required>
                    <?php foreach ($sexos as $sexo): ?>
                        <!-- 
                          CORREGIDO: 
                          1. El valor del option debe ser 'id' (PK de la tabla sexo).
                          2. La comparación debe ser 'id' vs 'idsexo' (FK de la tabla persona).
                        -->
                        <option value="<?= $sexo['id'] ?>" <?= $sexo['id'] == $persona['idsexo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sexo['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="idestadocivil">Estado Civil:</label>
                <select name="idestadocivil" id="idestadocivil" required>
                    <?php foreach ($estadosciviles as $estadocivil): ?>
                        <option value="<?= $estadocivil['idestadocivil'] ?>" <?= $estadocivil['idestadocivil'] == $persona['idestadocivil'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($estadocivil['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="submit" value="Actualizar Persona">
        </form>

        <!-- Enlace para Volver -->
        <a href="<?php echo $basePath; ?>persona">Volver al listado</a>
    </div>

</body>
</html>
