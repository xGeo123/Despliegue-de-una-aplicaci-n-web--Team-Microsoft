<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Personas</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <?php
        // Estandarizar definiendo basePath
        $basePath = '/public/'; 
    ?>
</head>
<body>

<div class="container">
    <h1>Lista de Personas</h1>
    <a href="<?php echo $basePath; ?>persona/create"><button>Agregar</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Fecha de Nacimiento</th>
                <th>Sexo</th>
                <th>Estado Civil</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($personas) && is_array($personas)): ?>
                <?php foreach ($personas as $persona): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($persona['idpersona']); ?></td>
                        <td><?php echo htmlspecialchars($persona['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($persona['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($persona['fechanacimiento']); ?></td>
                        
                        <!-- 
                          CORREGIDO: 
                          Cambiado de 'elsexo' a 'sexo_nombre' para coincidir con registro.php
                        -->
                        <td><?php echo htmlspecialchars($persona['sexo_nombre'] ?? $persona['idsexo']); ?></td> 
                        
                        <!-- 
                          CORREGIDO: 
                          Cambiado de 'elestadocivil' a 'estadocivil_nombre' para coincidir con registro.php
                        -->
                        <td><?php echo htmlspecialchars($persona['estadocivil_nombre'] ?? $persona['idestadocivil']); ?></td> 
                        
                        <td>
                            <a href="<?php echo $basePath; ?>persona/view?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">
                                <button>View</button>
                            </a>
                            <a href="<?php echo $basePath; ?>persona/edit?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">
                                <button>Editar</button>
                            </a>
                            <a href="<?php echo $basePath; ?>persona/eliminar?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">
                                <button>Eliminar</button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay registros de personas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="/public/js/script.js"></script>
</body>
</html>

