<?php
// Funciones auxiliares
function leerObras() {
    if (file_exists('datos/obras.json')) {
        return json_decode(file_get_contents('datos/obras.json'), true) ?? [];
    }
    return [];
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

function calcularEdad($fechaNacimiento) {
    $hoy = new DateTime();
    $nacimiento = new DateTime($fechaNacimiento);
    return $hoy->diff($nacimiento)->y;
}

$mensaje = '';
$tipo_mensaje = '';
$personaje_editar = null;

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $personajes = leerPersonajes();
    
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'crear':
                // Verificar si la cédula ya existe
                $cedula_existe = false;
                foreach ($personajes as $personaje) {
                    if ($personaje['cedula'] == $_POST['cedula']) {
                        $cedula_existe = true;
                        break;
                    }
                }
                
                if ($cedula_existe) {
                    $mensaje = 'Error: La cédula ya existe. Por favor, use una cédula diferente.';
                    $tipo_mensaje = 'error';
                } else {
                    $nuevo_personaje = [
                        'obra_codigo' => $_POST['obra_codigo'],
                        'cedula' => $_POST['cedula'],
                        'foto_url' => $_POST['foto_url'],
                        'nombre' => $_POST['nombre'],
                        'apellido' => $_POST['apellido'],
                        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                        'sexo' => $_POST['sexo'],
                        'habilidades' => $_POST['habilidades'],
                        'comida_favorita' => $_POST['comida_favorita'],
                        'fecha_registro' => date('Y-m-d H:i:s')
                    ];
                    
                    $personajes[] = $nuevo_personaje;
                    guardarPersonajes($personajes);
                    $mensaje = '¡Personaje agregado exitosamente!';
                    $tipo_mensaje = 'success';
                }
                break;
                
            case 'actualizar':
                $cedula_original = $_POST['cedula_original'];
                $cedula_nueva = $_POST['cedula'];
                
                // Verificar si la nueva cédula ya existe (si es diferente a la original)
                if ($cedula_original != $cedula_nueva) {
                    $cedula_existe = false;
                    foreach ($personajes as $personaje) {
                        if ($personaje['cedula'] == $cedula_nueva) {
                            $cedula_existe = true;
                            break;
                        }
                    }
                    
                    if ($cedula_existe) {
                        $mensaje = 'Error: La nueva cédula ya existe.';
                        $tipo_mensaje = 'error';
                        break;
                    }
                }
                
                // Actualizar personaje
                for ($i = 0; $i < count($personajes); $i++) {
                    if ($personajes[$i]['cedula'] == $cedula_original) {
                        $personajes[$i] = [
                            'obra_codigo' => $_POST['obra_codigo'],
                            'cedula' => $cedula_nueva,
                            'foto_url' => $_POST['foto_url'],
                            'nombre' => $_POST['nombre'],
                            'apellido' => $_POST['apellido'],
                            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                            'sexo' => $_POST['sexo'],
                            'habilidades' => $_POST['habilidades'],
                            'comida_favorita' => $_POST['comida_favorita'],
                            'fecha_registro' => $personajes[$i]['fecha_registro'],
                            'fecha_actualizacion' => date('Y-m-d H:i:s')
                        ];
                        break;
                    }
                }
                
                guardarPersonajes($personajes);
                $mensaje = '¡Personaje actualizado exitosamente!';
                $tipo_mensaje = 'success';
                break;
        }
    }
}

// Procesar GET para editar
if (isset($_GET['editar'])) {
    $personajes = leerPersonajes();
    foreach ($personajes as $personaje) {
        if ($personaje['cedula'] == $_GET['editar']) {
            $personaje_editar = $personaje;
            break;
        }
    }
}

// Procesar GET para eliminar
if (isset($_GET['eliminar'])) {
    $personajes = leerPersonajes();
    $cedula_eliminar = $_GET['eliminar'];
    
    $personajes = array_filter($personajes, function($personaje) use ($cedula_eliminar) {
        return $personaje['cedula'] != $cedula_eliminar;
    });
    $personajes = array_values($personajes); // Reindexar
    
    guardarPersonajes($personajes);
    $mensaje = '¡Personaje eliminado exitosamente!';
    $tipo_mensaje = 'success';
}

$obras = leerObras();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $personaje_editar ? 'Editar' : 'Agregar' ?> Personaje - Batman Universe</title>
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
                    <i class="fas fa-users mr-3"></i><?= $personaje_editar ? 'EDITAR' : 'AGREGAR' ?> PERSONAJE
                </h2>
                
                <?php if ($mensaje): ?>
                    <div class="<?= $tipo_mensaje == 'success' ? 'bg-green-600' : 'bg-red-600' ?> text-white p-4 rounded-lg mb-6">
                        <i class="fas fa-<?= $tipo_mensaje == 'success' ? 'check' : 'exclamation-triangle' ?> mr-2"></i>
                        <?= $mensaje ?>
                    </div>
                <?php endif; ?>
                
                <?php if (empty($obras)): ?>
                    <div class="bg-yellow-600 text-black p-4 rounded-lg mb-6">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        No hay obras registradas. <a href="registrar_obra.php" class="underline font-bold">Registre una obra primero</a>.
                    </div>
                <?php else: ?>
                    <form method="POST" class="space-y-6">
                        <input type="hidden" name="accion" value="<?= $personaje_editar ? 'actualizar' : 'crear' ?>">
                        <?php if ($personaje_editar): ?>
                            <input type="hidden" name="cedula_original" value="<?= htmlspecialchars($personaje_editar['cedula']) ?>">
                        <?php endif; ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Obra Asociada *</label>
                                <select name="obra_codigo" class="batman-input w-full px-4 py-3 rounded-lg" required>
                                    <option value="">Seleccionar obra</option>
                                    <?php foreach ($obras as $obra): ?>
                                        <option value="<?= htmlspecialchars($obra['codigo']) ?>" 
                                                <?= ($personaje_editar && $personaje_editar['obra_codigo'] == $obra['codigo']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($obra['codigo']) ?> - <?= htmlspecialchars($obra['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Cédula/ID *</label>
                                <input type="text" name="cedula" 
                                       value="<?= $personaje_editar ? htmlspecialchars($personaje_editar['cedula']) : '' ?>"
                                       class="batman-input w-full px-4 py-3 rounded-lg" 
                                       placeholder="123456789" required>
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Nombre *</label>
                                <input type="text" name="nombre" 
                                       value="<?= $personaje_editar ? htmlspecialchars($personaje_editar['nombre']) : '' ?>"
                                       class="batman-input w-full px-4 py-3 rounded-lg" 
                                       placeholder="Bruce" required>
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Apellido *</label>
                                <input type="text" name="apellido" 
                                       value="<?= $personaje_editar ? htmlspecialchars($personaje_editar['apellido']) : '' ?>"
                                       class="batman-input w-full px-4 py-3 rounded-lg" 
                                       placeholder="Wayne" required>
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Fecha de Nacimiento *</label>
                                <input type="date" name="fecha_nacimiento" 
                                       value="<?= $personaje_editar ? $personaje_editar['fecha_nacimiento'] : '' ?>"
                                       class="batman-input w-full px-4 py-3 rounded-lg" required>
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Sexo *</label>
                                <select name="sexo" class="batman-input w-full px-4 py-3 rounded-lg" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Masculino" <?= ($personaje_editar && $personaje_editar['sexo'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                                    <option value="Femenino" <?= ($personaje_editar && $personaje_editar['sexo'] == 'Femenino') ? 'selected' : '' ?>>Femenino</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">Comida Favorita</label>
                                <input type="text" name="comida_favorita" 
                                       value="<?= $personaje_editar ? htmlspecialchars($personaje_editar['comida_favorita']) : '' ?>"
                                       class="batman-input w-full px-4 py-3 rounded-lg" 
                                       placeholder="Pizza">
                            </div>
                            <div>
                                <label class="block text-yellow-400 font-semibold mb-2">URL de Imagen</label>
                                <input type="url" name="foto_url" 
                                       value="<?= $personaje_editar ? htmlspecialchars($personaje_editar['foto_url']) : '' ?>"
                                       class="batman-input w-full px-4 py-3 rounded-lg" 
                                       placeholder="https://example.com/personaje.jpg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-yellow-400 font-semibold mb-2">Habilidades (separadas por comas) *</label>
                            <textarea name="habilidades" rows="3" class="batman-input w-full px-4 py-3 rounded-lg" 
                                      placeholder="Combate, Inteligencia, Tecnología" required><?= $personaje_editar ? htmlspecialchars($personaje_editar['habilidades']) : '' ?></textarea>
                        </div>
                        <div class="flex space-x-4">
                            <button type="submit" class="batman-btn px-8 py-3 rounded-lg font-bold text-lg flex-1">
                                <i class="fas fa-user-plus mr-2"></i><?= $personaje_editar ? 'ACTUALIZAR' : 'AGREGAR' ?> PERSONAJE
                            </button>
                            <?php if ($personaje_editar): ?>
                                <a href="agregar_personaje.php" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-bold text-lg text-center">
                                    <i class="fas fa-times mr-2"></i>CANCELAR
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
            
            <!-- Lista de personajes -->
            <div class="batman-card p-8 rounded-xl">
                <h3 class="batman-font text-2xl font-bold text-yellow-400 mb-6 text-center">
                    <i class="fas fa-users mr-3"></i>PERSONAJES REGISTRADOS
                </h3>
                
                <?php
                $personajes = leerPersonajes();
                
                if (empty($personajes)): ?>
                    <div class="text-center">
                        <i class="fas fa-users text-6xl text-gray-400 mb-4"></i>
                        <p class="text-gray-400">No hay personajes registrados</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <?php foreach ($personajes as $personaje): 
                            $edad = calcularEdad($personaje['fecha_nacimiento']);
                            
                            // Buscar nombre de la obra
                            $nombre_obra = '';
                            foreach ($obras as $obra) {
                                if ($obra['codigo'] == $personaje['obra_codigo']) {
                                    $nombre_obra = $obra['nombre'];
                                    break;
                                }
                            }
                        ?>
                            <div class="bg-gray-800 p-4 rounded-lg border border-yellow-400">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center space-x-3">
                                        <img src="<?= htmlspecialchars($personaje['foto_url'] ?: 'https://via.placeholder.com/50x50/000000/FFFF00?text=No+Img') ?>" 
                                             alt="<?= htmlspecialchars($personaje['nombre']) ?>" 
                                             class="w-12 h-12 object-cover rounded border border-yellow-400">
                                        <div class="flex-1">
                                            <h4 class="batman-font text-lg font-bold text-yellow-400">
                                                <?= htmlspecialchars($personaje['nombre'] . ' ' . $personaje['apellido']) ?>
                                            </h4>
                                            <p class="text-sm text-gray-300">ID: <?= htmlspecialchars($personaje['cedula']) ?></p>
                                            <p class="text-sm text-gray-300">Obra: <?= htmlspecialchars($nombre_obra) ?></p>
                                            <p class="text-sm text-yellow-400">Edad: <?= $edad ?> años</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="?editar=<?= urlencode($personaje['cedula']) ?>" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?eliminar=<?= urlencode($personaje['cedula']) ?>" 
                                           onclick="return confirm('¿Está seguro de eliminar este personaje?')"
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
