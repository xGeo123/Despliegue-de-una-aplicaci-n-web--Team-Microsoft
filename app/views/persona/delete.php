<?php
// Define la ruta base para que los enlaces y el 'action' del formulario funcionen
$basePath = '/public/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Persona</title>
    <!-- Estilos (copiados de sexo/delete.php) -->
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
</head>
<body>

    <div class="form-container">
        <h2>Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este registro?</p>

        <!-- 
          ACCIÓN CORREGIDA: 
          Debe apuntar a la RUTA '/public/persona/delete'
        -->
        <form action="<?php echo $basePath; ?>persona/delete" method="POST">
            
            <!-- 
              CORREGIDO: 
              Debe ser 'idpersona' y usar la variable $persona
            -->
            <input type="hidden" name="idpersona" value="<?php echo htmlspecialchars($persona['idpersona']); ?>">
            
            <label for="nombre">Nombre Completo:</label>
            <!-- 
              CAMBIO: 
              Cambiado a 'readonly' y usando la variable $persona
            -->
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($persona['nombres'] . ' ' . $persona['apellidos']); ?>" readonly>
            
            <input type="submit" value="Confirmar Eliminación">
        </form>

        <!-- Enlace para Volver -->
        <a href="<?php echo $basePath; ?>persona">Volver al listado</a>
    </div>

</body>
</html>
