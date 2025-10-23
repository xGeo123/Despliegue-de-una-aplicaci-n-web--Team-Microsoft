<?php
    // Estandarizar definiendo basePath
    $basePath = '/public/'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Direcciones</title>
    <!-- CORREGIDO: Usar basePath para CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css"> 
</head>
<body>

<div class="container">
    <h1>Listar Direcciones</h1>
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
    <a href="<?php echo $basePath; ?>" class="back-button">Volver al Menú Principal</a> 
    <a href="<?php echo $basePath; ?>direccion/create"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Persona</th>
                <th>Nombre Dirección</th> <!-- Título de columna ajustado -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- CORREGIDO: Usar $direcciones (plural correcto) -->
            <?php if (!empty($direcciones) && is_array($direcciones)): ?>
                <?php foreach ($direcciones as $direccion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($direccion['iddireccion']); ?></td>
                        <!-- CORREGIDO: Usar 'persona_nombre' del JOIN y '??' -->
                        <td><?php echo htmlspecialchars($direccion['persona_nombre'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($direccion['nombre']); ?></td>
                        <td>
                            <a href="<?php echo $basePath; ?>direccion/edit?iddireccion=<?php echo htmlspecialchars($direccion['iddireccion']); ?>">
                                <button>Editar</button>
                            </a>
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

<!-- CORREGIDO: Usar basePath para JS -->
<script src="<?php echo $basePath; ?>js/script.js"></script> 
</body>
</html>

