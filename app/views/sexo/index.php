<?php
    // Define la ruta base para que los enlaces funcionen
    $basePath = '/public/'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Sexos</title>
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
    <!-- CORREGIDO: Enlace CSS duplicado eliminado -->
</head>
<body>

<div class="container">
    <h1>Listar Sexos</h1>
    <a href="<?php echo $basePath; ?>" class="back-button">Volver al Menú Principal</a> 
    <!-- CORREGIDO: Usar basePath -->
   <a href="<?php echo $basePath; ?>sexo/create"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($sexos) && is_array($sexos)): ?>
                <?php foreach ($sexos as $sexo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sexo['id']); ?></td>
                        <td><?php echo htmlspecialchars($sexo['nombre']); ?></td>
                        <td>
                            <!-- Enlace Editar (Correcto) -->
                            <a href="<?php echo $basePath; ?>sexo/edit?id=<?php echo htmlspecialchars($sexo['id']); ?>">
                                <button>Editar</button>
                            </a>
                            <!-- Enlace Eliminar (Correcto, onclick eliminado) -->
                            <a href="<?php echo $basePath; ?>sexo/eliminar?id=<?php echo htmlspecialchars($sexo['id']); ?>">
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

<!-- CORREGIDO: Usar basePath -->
<script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
