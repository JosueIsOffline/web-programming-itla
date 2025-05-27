<?php
// Funciones auxiliares
function calcularEdad($fechaNacimiento) {
    $hoy = new DateTime();
    $nacimiento = new DateTime($fechaNacimiento);
    return $hoy->diff($nacimiento)->y;
}

function calcularSigno($fechaNacimiento) {
    $fecha = new DateTime($fechaNacimiento);
    $dia = (int)$fecha->format('d');
    $mes = (int)$fecha->format('m');
    
    $signos = [
        ['nombre' => 'Capricornio', 'inicio' => [12, 22], 'fin' => [1, 19]],
        ['nombre' => 'Acuario', 'inicio' => [1, 20], 'fin' => [2, 18]],
        ['nombre' => 'Piscis', 'inicio' => [2, 19], 'fin' => [3, 20]],
        ['nombre' => 'Aries', 'inicio' => [3, 21], 'fin' => [4, 19]],
        ['nombre' => 'Tauro', 'inicio' => [4, 20], 'fin' => [5, 20]],
        ['nombre' => 'Géminis', 'inicio' => [5, 21], 'fin' => [6, 20]],
        ['nombre' => 'Cáncer', 'inicio' => [6, 21], 'fin' => [7, 22]],
        ['nombre' => 'Leo', 'inicio' => [7, 23], 'fin' => [8, 22]],
        ['nombre' => 'Virgo', 'inicio' => [8, 23], 'fin' => [9, 22]],
        ['nombre' => 'Libra', 'inicio' => [9, 23], 'fin' => [10, 22]],
        ['nombre' => 'Escorpio', 'inicio' => [10, 23], 'fin' => [11, 21]],
        ['nombre' => 'Sagitario', 'inicio' => [11, 22], 'fin' => [12, 21]]
    ];
    
    foreach ($signos as $signo) {
        if ($signo['nombre'] === 'Capricornio') {
            if (($mes === $signo['inicio'][0] && $dia >= $signo['inicio'][1]) || 
                ($mes === $signo['fin'][0] && $dia <= $signo['fin'][1])) {
                return $signo['nombre'];
            }
        } else {
            if (($mes === $signo['inicio'][0] && $dia >= $signo['inicio'][1]) || 
                ($mes === $signo['fin'][0] && $dia <= $signo['fin'][1])) {
                return $signo['nombre'];
            }
        }
    }
    
    return 'Capricornio';
}

// Verificar parámetro
if (!isset($_GET['codigo'])) {
    header('Location: ver_obras.php');
    exit;
}

$codigo = $_GET['codigo'];

// Leer obras
$obras = [];
if (file_exists('datos/obras.json')) {
    $obras = json_decode(file_get_contents('datos/obras.json'), true) ?? [];
}

// Buscar la obra
$obra = null;
foreach ($obras as $o) {
    if ($o['codigo'] === $codigo) {
        $obra = $o;
        break;
    }
}

if (!$obra) {
    header('Location: ver_obras.php');
    exit;
}

// Leer personajes
$personajes = [];
if (file_exists('datos/personajes.json')) {
    $personajes = json_decode(file_get_contents('datos/personajes.json'), true) ?? [];
}

// Filtrar personajes de esta obra
$personajesObra = array_filter($personajes, function($p) use ($codigo) {
    return $p['obra_codigo'] === $codigo;
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle: <?= htmlspecialchars($obra['nombre']) ?> - Batman Universe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
        .batman-font { font-family: 'Orbitron', monospace; }
        .batman-gradient { background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%); }
        .batman-card { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border: 1px solid #fbbf24; }
        .batman-btn { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #000; transition: all 0.3s ease; }
        .batman-btn:hover { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); transform: translateY(-2px); }
        
        @media print {
            body { 
                background: white !important; 
                color: black !important; 
                font-size: 12pt;
                line-height: 1.4;
            }
            .no-print { display: none !important; }
            .batman-card { 
                background: white !important; 
                border: 1px solid #000 !important; 
                box-shadow: none !important;
                margin: 0 !important;
            }
            .text-yellow-400 { color: black !important; }
            .text-gray-300 { color: #333 !important; }
            .bg-gray-800 { background: #f9f9f9 !important; border: 1px solid #ddd !important; }
            .border-yellow-400 { border-color: #000 !important; }
            h1, h2, h3, h4, h5 { color: black !important; }
            .batman-font { font-family: Arial, sans-serif !important; }
            .grid { display: block !important; }
            .grid > div { margin-bottom: 10px !important; }
            img { max-width: 150px !important; height: auto !important; }
            .space-y-4 > * + * { margin-top: 10px !important; }
            .gap-4 { gap: 5px !important; }
            .p-8 { padding: 20px !important; }
            .p-4 { padding: 10px !important; }
            .mb-8 { margin-bottom: 20px !important; }
            .mb-4 { margin-bottom: 10px !important; }
            .rounded-lg { border-radius: 5px !important; }
        }
        
        @page {
            margin: 1.5cm;
            size: A4;
        }
        
        .print-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="batman-gradient min-h-screen text-yellow-400">
    <div class="no-print">
        <?php include 'nav.php'; ?>
    </div>
    
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="batman-card p-8 rounded-xl">
            <!-- Header solo para impresión -->
            <div class="print-header" style="display: none;">
                <h1 style="font-size: 24pt; font-weight: bold; margin: 0;">BATMAN UNIVERSE - DETALLE DE OBRA</h1>
                <p style="margin: 5px 0;">Sistema de Gestión CRUD - Reporte Detallado</p>
                <p style="margin: 5px 0; font-size: 10pt;">Generado el <?= date('d/m/Y H:i:s') ?></p>
            </div>
            
            <div class="flex justify-between items-center mb-8 no-print">
                <h2 class="batman-font text-3xl font-bold text-yellow-400">
                    <i class="fas fa-file-alt mr-3"></i>DETALLE DE OBRA
                </h2>
                <div class="flex space-x-2">
                    <button onclick="window.print()" class="batman-btn px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-print mr-2"></i>Imprimir
                    </button>
                    <a href="registrar_obra.php?editar=<?= urlencode($obra['codigo']) ?>" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <a href="ver_obras.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
            
            <!-- Información de la obra -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="md:col-span-1">
                    <img src="<?= htmlspecialchars($obra['foto_url'] ?: 'https://via.placeholder.com/300x400/000000/FFFF00?text=No+Image') ?>" 
                         alt="<?= htmlspecialchars($obra['nombre']) ?>" 
                         class="w-full rounded-lg border border-yellow-400">
                </div>
                <div class="md:col-span-2">
                    <h3 class="batman-font text-2xl font-bold text-yellow-400 mb-4">
                        <?= htmlspecialchars($obra['nombre']) ?>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
                        <div>
                            <p><strong class="text-yellow-400">Código:</strong> <?= htmlspecialchars($obra['codigo']) ?></p>
                        </div>
                        <div>
                            <p><strong class="text-yellow-400">Tipo:</strong> <?= htmlspecialchars($obra['tipo']) ?></p>
                        </div>
                        <div>
                            <p><strong class="text-yellow-400">País:</strong> <?= htmlspecialchars($obra['pais']) ?></p>
                        </div>
                        <div>
                            <p><strong class="text-yellow-400">Autor/Director:</strong> <?= htmlspecialchars($obra['autor']) ?></p>
                        </div>
                        <div>
                            <p><strong class="text-yellow-400">Registrado:</strong> <?= date('d/m/Y H:i', strtotime($obra['fecha_registro'])) ?></p>
                        </div>
                        <div>
                            <p><strong class="text-yellow-400">Total Personajes:</strong> 
                               <span class="bg-yellow-400 text-black px-2 py-1 rounded font-bold"><?= count($personajesObra) ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p><strong class="text-yellow-400">Descripción:</strong></p>
                        <p class="text-gray-300 mt-2"><?= htmlspecialchars($obra['descripcion']) ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Estadísticas de personajes -->
            <?php if (!empty($personajesObra)): 
                $personajes_masculinos = count(array_filter($personajesObra, function($p) { return $p['sexo'] == 'Masculino'; }));
                $personajes_femeninos = count(array_filter($personajesObra, function($p) { return $p['sexo'] == 'Femenino'; }));
                $edad_promedio = array_sum(array_map('calcularEdad', array_column($personajesObra, 'fecha_nacimiento'))) / count($personajesObra);
            ?>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 no-print">
                    <div class="bg-gray-800 p-4 rounded-lg text-center">
                        <i class="fas fa-users text-2xl text-yellow-400 mb-2"></i>
                        <div class="batman-font text-xl font-bold text-yellow-400"><?= count($personajesObra) ?></div>
                        <div class="text-gray-300 text-sm">Total</div>
                    </div>
                    <div class="bg-gray-800 p-4 rounded-lg text-center">
                        <i class="fas fa-mars text-2xl text-yellow-400 mb-2"></i>
                        <div class="batman-font text-xl font-bold text-yellow-400"><?= $personajes_masculinos ?></div>
                        <div class="text-gray-300 text-sm">Masculinos</div>
                    </div>
                    <div class="bg-gray-800 p-4 rounded-lg text-center">
                        <i class="fas fa-venus text-2xl text-yellow-400 mb-2"></i>
                        <div class="batman-font text-xl font-bold text-yellow-400"><?= $personajes_femeninos ?></div>
                        <div class="text-gray-300 text-sm">Femeninos</div>
                    </div>
                    <div class="bg-gray-800 p-4 rounded-lg text-center">
                        <i class="fas fa-birthday-cake text-2xl text-yellow-400 mb-2"></i>
                        <div class="batman-font text-xl font-bold text-yellow-400"><?= round($edad_promedio, 1) ?></div>
                        <div class="text-gray-300 text-sm">Edad Promedio</div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Personajes -->
            <h4 class="batman-font text-xl font-bold text-yellow-400 mb-4">
                <i class="fas fa-users mr-2"></i>PERSONAJES DETALLADOS (<?= count($personajesObra) ?>)
            </h4>
            
            <?php if (empty($personajesObra)): ?>
                <div class="text-center py-8">
                    <i class="fas fa-user-slash text-6xl text-gray-400 mb-4"></i>
                    <p class="text-gray-400 text-xl">No hay personajes registrados para esta obra.</p>
                    <div class="no-print mt-4">
                        <a href="agregar_personaje.php" class="batman-btn px-6 py-3 rounded-lg font-semibold">
                            <i class="fas fa-user-plus mr-2"></i>Agregar Primer Personaje
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($personajesObra as $index => $personaje): 
                        $edad = calcularEdad($personaje['fecha_nacimiento']);
                        $signo = calcularSigno($personaje['fecha_nacimiento']);
                    ?>
                        <div class="bg-gray-800 p-4 rounded-lg border border-yellow-400">
                            <div class="flex items-start space-x-4">
                                <img src="<?= htmlspecialchars($personaje['foto_url'] ?: 'https://via.placeholder.com/80x80/000000/FFFF00?text=No+Image') ?>" 
                                     alt="<?= htmlspecialchars($personaje['nombre']) ?>" 
                                     class="w-16 h-16 object-cover rounded border border-yellow-400">
                                <div class="flex-1">
                                    <h5 class="font-bold text-yellow-400 text-lg">
                                        <?= htmlspecialchars($personaje['nombre'] . ' ' . $personaje['apellido']) ?>
                                    </h5>
                                    <div class="grid grid-cols-2 gap-2 text-sm text-gray-300 mt-2">
                                        <div><strong>ID:</strong> <?= htmlspecialchars($personaje['cedula']) ?></div>
                                        <div><strong>Sexo:</strong> <?= htmlspecialchars($personaje['sexo']) ?></div>
                                        <div><strong>Edad:</strong> <?= $edad ?> años</div>
                                        <div><strong>Signo:</strong> <?= $signo ?></div>
                                        <div><strong>Nacimiento:</strong> <?= date('d/m/Y', strtotime($personaje['fecha_nacimiento'])) ?></div>
                                        <div><strong>Comida favorita:</strong> <?= htmlspecialchars($personaje['comida_favorita']) ?></div>
                                    </div>
                                    <div class="mt-3">
                                        <strong class="text-yellow-400">Habilidades:</strong>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <?php 
                                            $habilidades = explode(',', $personaje['habilidades']);
                                            foreach ($habilidades as $habilidad): 
                                            ?>
                                                <span class="bg-yellow-400 text-black px-2 py-1 rounded text-xs font-semibold">
                                                    <?= htmlspecialchars(trim($habilidad)) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="no-print">
                                    <a href="agregar_personaje.php?editar=<?= urlencode($personaje['cedula']) ?>" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Resumen para impresión -->
                <div class="mt-8 pt-4 border-t border-yellow-400">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <h5 class="font-bold text-yellow-400 mb-2">Resumen por Género:</h5>
                            <p class="text-gray-300">• Masculino: <?= $personajes_masculinos ?> personajes</p>
                            <p class="text-gray-300">• Femenino: <?= $personajes_femeninos ?> personajes</p>
                        </div>
                        <div>
                            <h5 class="font-bold text-yellow-400 mb-2">Estadísticas:</h5>
                            <p class="text-gray-300">• Edad promedio: <?= round($edad_promedio, 1) ?> años</p>
                            <p class="text-gray-300">• Total habilidades únicas: 
                                <?php 
                                $todas_habilidades = [];
                                foreach ($personajesObra as $p) {
                                    $habs = explode(',', $p['habilidades']);
                                    foreach ($habs as $hab) {
                                        $todas_habilidades[] = trim($hab);
                                    }
                                }
                                echo count(array_unique($todas_habilidades));
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Footer para impresión -->
            <div class="mt-8 pt-4 border-t border-yellow-400 text-center text-sm text-gray-400">
                <p><strong>Batman Universe CRUD System</strong></p>
                <p>Reporte generado el <?= date('d/m/Y H:i:s') ?></p>
                <p>Obra: <?= htmlspecialchars($obra['nombre']) ?> (<?= htmlspecialchars($obra['codigo']) ?>)</p>
            </div>
        </div>
    </div>

    <script>
        // Mostrar header solo al imprimir
        window.addEventListener('beforeprint', function() {
            document.querySelector('.print-header').style.display = 'block';
        });
        
        window.addEventListener('afterprint', function() {
            document.querySelector('.print-header').style.display = 'none';
        });
    </script>
</body>
</html>
