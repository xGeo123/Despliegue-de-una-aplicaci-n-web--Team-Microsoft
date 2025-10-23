<?php
    // Estandarizar definiendo basePath
    $basePath = '/public/'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Teléfonos</title>
    <!-- CORREGIDO: Usar basePath -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css"> 
    <style>
        /* Estilos adicionales para el botón Volver */
        .back-button {
            display: inline-block;
            margin-bottom: 20px; /* Espacio debajo del botón */
            padding: 8px 15px;
            background-color: #6c757d; /* Color gris */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Listar Teléfonos</h1>
    
    <!-- Botón Volver al Principal (Menú) -->
    <a href="<?php echo $basePath; ?>" class="back-button">Volver al Menú Principal</a> 
    
    <a href="<?php echo $basePath; ?>telefono/create"><button>Agregar Teléfono</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Persona</th>
                <th>Número</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($telefonos) && is_array($telefonos)): ?>
                <?php foreach ($telefonos as $telefono): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($telefono['idtelefono']); ?></td>
                        <!-- CORREGIDO: Usar 'persona_nombre' del JOIN y '??' -->
                        <td><?php echo htmlspecialchars($telefono['persona_nombre'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($telefono['numero']); ?></td>
                        <td>
                            <a href="<?php echo $basePath; ?>telefono/edit?idtelefono=<?php echo htmlspecialchars($telefono['idtelefono']); ?>">
                                <button>Editar</button>
                            </a>
                            <a href="<?php echo $basePath; ?>telefono/eliminar?idtelefono=<?php echo htmlspecialchars($telefono['idtelefono']); ?>">
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <!-- CORREGIDO: Colspan a 4 -->
                    <td colspan="4">No hay registros disponibles.</td> 
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- CORREGIDO: Usar basePath -->
<script src="<?php echo $basePath; ?>js/script.js"></script> 
</body>
</html>

