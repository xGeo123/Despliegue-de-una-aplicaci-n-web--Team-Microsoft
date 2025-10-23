<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Personas</title>
    <?php
        // Define la ruta base para que los enlaces funcionen
        $basePath = '/public/'; 
    ?>
    <!-- CORRECCIÓN 1: El enlace CSS debe usar el basePath -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body>

<div class="container">
    <h1>Lista de Personas</h1>
    <!-- CORRECCIÓN 1: El enlace 'Agregar' debe usar el basePath -->
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
                          CORRECCIÓN 2: 
                          Usar 'sexo_nombre' (de la consulta JOIN) en lugar de 'elsexo'
                        -->
                        <td><?php echo htmlspecialchars($persona['sexo_nombre'] ?? $persona['idsexo']); ?></td> 
                        
                        <!-- 
                          CORRECCIÓN 2: 
                          Usar 'estadocivil_nombre' (de la consulta JOIN) en lugar de 'elestadocivil'
                        -->
                        <td><?php echo htmlspecialchars($persona['nombre'] ?? $persona['idestadocivil']); ?></td> 
                        
                        <td>
                            <!-- CORRECCIÓN 1: Los enlaces deben usar el basePath -->
                            <a href="<?php echo $basePath; ?>persona/view?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">
                                <button>View</button>
                            </a>
                            <a href="<?php echo $basePath; ?>persona/edit?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">
                                <button>Editar</button>
                            </a>
                            
                            <!-- 
                              CORRECCIÓN 3: 
                              1. La ruta debe ser 'persona/eliminar'.
                              2. El parámetro debe ser 'idpersona'.
                              3. 'onclick' eliminado.
                            -->
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

<!-- CORRECCIÓN 1: El script JS debe usar el basePath -->
<script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>

