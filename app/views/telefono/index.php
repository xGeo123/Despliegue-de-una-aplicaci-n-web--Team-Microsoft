<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Teléfonos</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <?php
        // Estandarizar definiendo basePath
        $basePath = '/public/'; 
    ?>
</head>
<body>

<div class="container">
    <h1>Listar Teléfonos</h1>
    <a href="<?php echo $basePath; ?>telefono/create"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Persona</th>
                <th>Número</th> <!-- Título de columna corregido -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($telefonos) && is_array($telefonos)): ?>
                <?php foreach ($telefonos as $telefono): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($telefono['idtelefono']); ?></td>
                        <td><?php echo htmlspecialchars($telefono['lapersona']); ?></td>
                        <td><?php echo htmlspecialchars($telefono['numero']); ?></td>
                        <td>
                            <a href="<?php echo $basePath; ?>telefono/edit?idtelefono=<?php echo htmlspecialchars($telefono['idtelefono']); ?>">
                                <button>Editar</button>
                            </a>
                            <!-- CORREGIDO: 'onclick' eliminado (ya tenemos página de confirmación) -->
                            <a href="<?php echo $basePath; ?>telefono/eliminar?idtelefono=<?php echo htmlspecialchars($telefono['idtelefono']); ?>">
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay registros disponibles.</td> <!-- Colspan corregido a 4 -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/public/js/script.js"></script>
</body>
</html>
