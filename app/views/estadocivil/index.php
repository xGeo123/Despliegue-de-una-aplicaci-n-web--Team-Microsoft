<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Estados Civiles</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <?php
        // Definir basePath aquí es una buena práctica si 'public' no es la raíz
        $basePath = '/public/'; 
    ?>
</head>
<body>

<div class="container">
    <h1>Listar Estados Civiles</h1>
    
    <!-- 
      AQUÍ ESTÁ LA CORRECCIÓN:
      El enlace debe apuntar a la RUTA '/public/estadocivil/create'
      NO al archivo '/app/views/estadocivil/create.php'
    -->
    <a href="<?php echo $basePath; ?>estadocivil/create"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($estadosciviles) && is_array($estadosciviles)): ?>
                <?php foreach ($estadosciviles as $estadocivil): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($estadocivil['idestadocivil']); ?></td>
                        <td><?php echo htmlspecialchars($estadocivil['nombre']); ?></td>
                        <td>
                            <!-- Este enlace está bien -->
                            <a href="<?php echo $basePath; ?>estadocivil/edit?idestadocivil=<?php echo htmlspecialchars($estadocivil['idestadocivil']); ?>">
                                <button>Editar</button>
                            </a>
                            
                            <!-- 
                              CORRECCIÓN: Se eliminó el 'onclick="return confirm(...)"'
                              Tu controlador 'eliminar()' ya muestra una vista de confirmación.
                            -->
                            <a href="<?php echo $basePath; ?>estadocivil/eliminar?idestadocivil=<?php echo htmlspecialchars($estadocivil['idestadocivil']); ?>">
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay registros disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/public/js/script.js"></script>
</body>
</html>
