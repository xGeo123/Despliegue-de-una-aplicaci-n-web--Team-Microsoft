<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Direcciones</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <?php
        // Estandarizar definiendo basePath
        $basePath = '/public/'; 
    ?>
</head>
<body>

<div class="container">
    <h1>Listar Direcciones</h1>
    <a href="<?php echo $basePath; ?>direccion/create"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Persona</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($direccions) && is_array($direccions)): ?>
                <?php foreach ($direccions as $direccion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($direccion['iddireccion']); ?></td>
                        <td><?php echo htmlspecialchars($direccion['lapersona']); ?></td>
                        <td><?php echo htmlspecialchars($direccion['nombre']); ?></td>
                        <td>
                            <a href="<?php echo $basePath; ?>direccion/edit?iddireccion=<?php echo htmlspecialchars($direccion['iddireccion']); ?>">
                                <button>Editar</button>
                            </a>
                            <!-- CORREGIDO: 'onclick' eliminado (ya tenemos página de confirmación) -->
                            <a href="<?php echo $basePath; ?>direccion/eliminar?iddireccion=<?php echo htmlspecialchars($direccion['iddireccion']); ?>">
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
