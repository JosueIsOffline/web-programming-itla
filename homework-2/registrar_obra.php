<?php
// Funciones auxiliares
function leerObras() {
    if (file_exists('datos/obras.json')) {
        return json_decode(file_get_contents('datos/obras.json'), true) ?? [];
    }
    return [];
}

function guardarObras($obras) {
    if (!file_exists('datos')) {
        mkdir('datos', 0777, true);
    }
    file_put_contents('datos/obras.json', json_encode($obras, JSON_PRETTY_PRINT));
}

function leerPersonajes() {
    if (file_exists('datos/personajes.json')) {
        return json_decode(file_get_contents('datos/personajes.json'), true) ?? [];
    }
    return [];
}

function guardarPersonajes($personajes) {
    if (!file_exists('datos')) {
        mkdir('datos', 0777, true);
    }
    file_put_contents('datos/personajes.json', json_encode($personajes, JSON_PRETTY_PRINT));
}

$mensaje = '';
$tipo_mensaje = '';
$obra_editar = null;

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $obras = leerObras();
    
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'crear':
                // Verificar si el código ya existe
                $codigo_existe = false;
                foreach ($obras as $obra) {
                    if ($obra['codigo'] == $_POST['codigo']) {
                        $codigo_existe = true;
                        break;
                    }
                }
                
                if ($codigo_existe) {
                    $mensaje = 'Error: El código ya existe. Por favor, use un código diferente.';
                    $tipo_mensaje = 'error';
                } else {
                    $nueva_obra = [
                        'codigo' => $_POST['codigo'],
                        'foto_url' => $_POST['foto_url'],
                        'tipo' => $_POST['tipo'],
                        'nombre' => $_POST['nombre'],
                        'descripcion' => $_POST['descripcion'],
                        'pais' => $_POST['pais'],
                        'autor' => $_POST['autor'],
                        'fecha_registro' => date('Y-m-d H:i:s')
                    ];
                    
                    $obras[] = $nueva_obra;
                    guardarObras($obras);
                    $mensaje = '¡Obra registrada exitosamente!';
                    $tipo_mensaje = 'success';
                }
                break;
                
            case 'actualizar':
                $codigo_original = $_POST['codigo_original'];
                $codigo_nuevo = $_POST['codigo'];
                
                // Verificar si el nuevo código ya existe (si es diferente al original)
                if ($codigo_original != $codigo_nuevo) {
                    $codigo_existe = false;
                    foreach ($obras as $obra) {
                        if ($obra['codigo'] == $codigo_nuevo) {
                            $codigo_existe = true;
                            break;
                        }
                    }
                    
                    if ($codigo_existe) {
                        $mensaje = 'Error: El nuevo código ya existe.';
                        $tipo_mensaje = 'error';
                        break;
                    }
                }
                
                // Actualizar obra
                for ($i = 0; $i < count($obras); $i++) {
                    if ($obras[$i]['codigo'] == $codigo_original) {
                        $obras[$i] = [
                            'codigo' => $codigo_nuevo,
                            'foto_url' => $_POST['foto_url'],
                            'tipo' => $_POST['tipo'],
                            'nombre' => $_POST['nombre'],
                            'descripcion' => $_POST['descripcion'],
                            'pais' => $_POST['pais'],
                            'autor' => $_POST['autor'],
                            'fecha_registro' => $obras[$i]['fecha_registro'],
                            'fecha_actualizacion' => date('Y-m-d H:i:s')
                        ];
                        break;
                    }
                }
                
                // Si el código cambió, actualizar personajes
                if ($codigo_original != $codigo_nuevo) {
                    $personajes = leerPersonajes();
                    for ($i = 0; $i < count($personajes); $i++) {
                        if ($personajes[$i]['obra_codigo'] == $codigo_original) {
                            $personajes[$i]['obra_codigo'] = $codigo_nuevo;
                        }
                    }
                    guardarPersonajes($personajes);
                }
                
                guardarObras($obras);
                $mensaje = '¡Obra actualizada exitosamente!';
                $tipo_mensaje = 'success';
                break;
        }
    }
}

// Procesar GET para editar
if (isset($_GET['editar'])) {
    $obras = leerObras();
    foreach ($obras as $obra) {
        if ($obra['codigo'] == $_GET['editar']) {
            $obra_editar = $obra;
            break;
        }
    }
}

// Procesar GET para eliminar
if (isset($_GET['eliminar'])) {
    $obras = leerObras();
    $codigo_eliminar = $_GET['eliminar'];
    
    // Eliminar obra
    $obras = array_filter($obras, function($obra) use ($codigo_eliminar) {
        return $obra['codigo'] != $codigo_eliminar;
    });
    $obras = array_values($obras); // Reindexar
    
    // Eliminar personajes asociados
    $personajes = leerPersonajes();
    $personajes = array_filter($personajes, function($personaje) use ($codigo_eliminar) {
        return $personaje['obra_codigo'] != $codigo_eliminar;
    });
    $personajes = array_values($personajes);
    
    guardarObras($obras);
    guardarPersonajes($personajes);
    
    $mensaje = '¡Obra y sus personajes eliminados exitosamente!';
    $tipo_mensaje = 'success';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $obra_editar ? 'Editar' : 'Registrar' ?> Obra - Batman Universe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
        .batman-font { font-family: 'Orbitron', monospace; }
        .batman-gradient { background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%); }
        .batman-card { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border: 1px solid #fbbf24; }
        .batman-btn { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #000; transition: all 0.3s ease; }
        .batman-btn:hover { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); transform: translateY(-2px); }
        .batman-input { background: rgba(45, 45, 45, 0.8); border: 1px solid #fbbf24; color: #fbbf24; }
        .batman-input:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1); outline: none; }
        .batman-input::placeholder { color: #9ca3af; }
    </style>
</head>
<body class="batman-gradient min-h-screen text-yellow-400">
    <?php include 'nav.php'; ?>
    
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulario -->
            <div class="batman-card p-8 rounded-xl">
                <h2 class="batman-font text-3xl font-bold text-yellow-400 mb-8 text-center">
                    <i class="fas fa-film mr-3"></i><?= $obra_editar ? 'EDITAR' : 'REGISTRAR' ?> OBRA
                </h2>
                
                <?php if ($mensaje): ?>
                    <div class="<?= $tipo_mensaje == 'success' ? 'bg-green-600' : 'bg-red-600' ?> text-white p-4 rounded-lg mb-6">
                        <i class="fas fa-<?= $tipo_mensaje == 'success' ? 'check' : 'exclamation-triangle' ?> mr-2"></i>
                        <?= $mensaje ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="accion" value="<?= $obra_editar ? 'actualizar' : 'crear' ?>">
                    <?php if ($obra_editar): ?>
                        <input type="hidden" name="codigo_original" value="<?= htmlspecialchars($obra_editar['codigo']) ?>">
                    <?php endif; ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">Código Único *</label>
                            <input type="text" name="codigo" 
                                   value="<?= $obra_editar ? htmlspecialchars($obra_editar['codigo']) : '' ?>"
                                   class="batman-input w-full px-4 py-3 rounded-lg" 
                                   placeholder="BAT001" required>
                        </div>
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">Tipo de Obra *</label>
                            <select name="tipo" class="batman-input w-full px-4 py-3 rounded-lg" required>
                                <option value="">Seleccionar tipo</option>
                                <option value="Serie" <?= ($obra_editar && $obra_editar['tipo'] == 'Serie') ? 'selected' : '' ?>>Serie</option>
                                <option value="Película" <?= ($obra_editar && $obra_editar['tipo'] == 'Película') ? 'selected' : '' ?>>Película</option>
                                <option value="Otro" <?= ($obra_editar && $obra_editar['tipo'] == 'Otro') ? 'selected' : '' ?>>Otro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">Nombre *</label>
                            <input type="text" name="nombre" 
                                   value="<?= $obra_editar ? htmlspecialchars($obra_editar['nombre']) : '' ?>"
                                   class="batman-input w-full px-4 py-3 rounded-lg" 
                                   placeholder="The Dark Knight" required>
                        </div>
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">País *</label>
                            <input type="text" name="pais" 
                                   value="<?= $obra_editar ? htmlspecialchars($obra_editar['pais']) : '' ?>"
                                   class="batman-input w-full px-4 py-3 rounded-lg" 
                                   placeholder="Estados Unidos" required>
                        </div>
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">Autor/Director *</label>
                            <input type="text" name="autor" 
                                   value="<?= $obra_editar ? htmlspecialchars($obra_editar['autor']) : '' ?>"
                                   class="batman-input w-full px-4 py-3 rounded-lg" 
                                   placeholder="Christopher Nolan" required>
                        </div>
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">URL de Imagen</label>
                            <input type="url" name="foto_url" 
                                   value="<?= $obra_editar ? htmlspecialchars($obra_editar['foto_url']) : '' ?>"
                                   class="batman-input w-full px-4 py-3 rounded-lg" 
                                   placeholder="https://example.com/image.jpg">
                        </div>
                    </div>
                    <div>
                        <label class="block text-yellow-400 font-semibold mb-2">Descripción *</label>
                        <textarea name="descripcion" rows="4" class="batman-input w-full px-4 py-3 rounded-lg" 
                                  placeholder="Descripción de la obra..." required><?= $obra_editar ? htmlspecialchars($obra_editar['descripcion']) : '' ?></textarea>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="batman-btn px-8 py-3 rounded-lg font-bold text-lg flex-1">
                            <i class="fas fa-save mr-2"></i><?= $obra_editar ? 'ACTUALIZAR' : 'REGISTRAR' ?> OBRA
                        </button>
                        <?php if ($obra_editar): ?>
                            <a href="registrar_obra.php" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-bold text-lg text-center">
                                <i class="fas fa-times mr-2"></i>CANCELAR
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            
            <!-- Lista de obras -->
            <div class="batman-card p-8 rounded-xl">
                <h3 class="batman-font text-2xl font-bold text-yellow-400 mb-6 text-center">
                    <i class="fas fa-list mr-3"></i>OBRAS REGISTRADAS
                </h3>
                
                <?php
                $obras = leerObras();
                $personajes = leerPersonajes();
                
                if (empty($obras)): ?>
                    <div class="text-center">
                        <i class="fas fa-film text-6xl text-gray-400 mb-4"></i>
                        <p class="text-gray-400">No hay obras registradas</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <?php foreach ($obras as $obra): 
                            $cantidadPersonajes = count(array_filter($personajes, function($p) use ($obra) {
                                return $p['obra_codigo'] === $obra['codigo'];
                            }));
                        ?>
                            <div class="bg-gray-800 p-4 rounded-lg border border-yellow-400">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="batman-font text-lg font-bold text-yellow-400">
                                            <?= htmlspecialchars($obra['nombre']) ?>
                                        </h4>
                                        <p class="text-sm text-gray-300">Código: <?= htmlspecialchars($obra['codigo']) ?></p>
                                        <p class="text-sm text-gray-300">Tipo: <?= htmlspecialchars($obra['tipo']) ?></p>
                                        <p class="text-sm text-yellow-400">Personajes: <?= $cantidadPersonajes ?></p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="?editar=<?= urlencode($obra['codigo']) ?>" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="detalle.php?codigo=<?= urlencode($obra['codigo']) ?>" 
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="?eliminar=<?= urlencode($obra['codigo']) ?>" 
                                           onclick="return confirm('¿Está seguro de eliminar esta obra y todos sus personajes?')"
                                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
