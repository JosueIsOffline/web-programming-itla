<?php
// Cargar datos
$obras = [];
$personajes = [];

if (file_exists('datos/obras.json')) {
    $contenido = file_get_contents('datos/obras.json');
    $obras = json_decode($contenido, true) ?? [];
}

if (file_exists('datos/personajes.json')) {
    $contenido = file_get_contents('datos/personajes.json');
    $personajes = json_decode($contenido, true) ?? [];
}

// Contar personajes por obra
function contarPersonajes($codigoObra, $personajes) {
    $count = 0;
    foreach ($personajes as $personaje) {
        if ($personaje['codigo_obra'] === $codigoObra) {
            $count++;
        }
    }
    return $count;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Obras - Batman Universe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            color: #e4e6ea;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        
        .batman-header {
            background: linear-gradient(90deg, #000000 0%, #1a1a1a 50%, #000000 100%);
            border-bottom: 3px solid #ffd700;
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.3);
        }
        
        .batman-logo {
            font-size: 2.5rem;
            text-shadow: 0 0 20px #ffd700;
        }
        
        .obra-card {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid #ffd700;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.2);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .obra-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(255, 215, 0, 0.4);
            border-color: #ffed4a;
        }
        
        .obra-image {
            height: 200px;
            background: linear-gradient(45deg, #1a1a2e, #16213e);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #ffd700;
        }
        
        .obra-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .obra-image .placeholder-icon {
            font-size: 4rem;
            color: #ffd700;
            opacity: 0.6;
        }
        
        .btn-batman {
            background: linear-gradient(45deg, #ffd700 0%, #ffed4a 100%);
            color: #000;
            border: none;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border-radius: 25px;
        }
        
        .btn-batman:hover {
            background: #ffd700;
            color: #000;
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        }
        
        .obra-type {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 215, 0, 0.9);
            color: #000;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .stats-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4a);
            color: #000;
            border-radius: 20px;
            padding: 5px 15px;
            font-weight: bold;
            display: inline-block;
            margin: 5px;
        }
        
        .no-obras {
            background: rgba(255, 215, 0, 0.1);
            border: 2px solid #ffd700;
            border-radius: 20px;
            padding: 60px;
            text-align: center;
        }
        
        .search-container {
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid #ffd700;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #ffd700;
            color: #e4e6ea;
            border-radius: 10px;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ffd700;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg batman-header">
        <div class="container">
            <a class="navbar-brand text-warning" href="index.php">
                <i class="fab fa-bat batman-logo"></i> Batman Universe
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-light" href="index.php"><i class="fas fa-home"></i> Inicio</a>
                <a class="nav-link text-light" href="registrar_obra.php"><i class="fas fa-plus"></i> Nueva Obra</a>
                <a class="nav-link text-light" href="agregar_personaje.php"><i class="fas fa-user-plus"></i> Nuevo Personaje</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h1 class="display-4 text-warning">
                <i class="fas fa-list"></i> Archivo de la Baticueva
            </h1>
            <p class="lead text-muted">Todas las obras del universo Batman</p>
        </div>

        <!-- Buscador -->
        <div class="search-container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control" id="searchInput" placeholder="🔍 Buscar obras por nombre, tipo o país...">
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="stats-badge">
                        <i class="fas fa-film"></i> <?php echo count($obras); ?> Obras
                    </span>
                    <span class="stats-badge">
                        <i class="fas fa-users"></i> <?php echo count($personajes); ?> Personajes
                    </span>
                </div>
            </div>
        </div>

        <?php if (empty($obras)): ?>
            <div class="no-obras">
                <div class="mb-4">
                    <i class="fas fa-film" style="font-size: 5rem; color: #ffd700; opacity: 0.6;"></i>
                </div>
                <h3 class="text-warning mb-3">La Baticueva está vacía</h3>
                <p class="lead mb-4">No hay obras registradas aún. ¡Comienza agregando la primera obra del universo Batman!</p>
                <a href="registrar_obra.php" class="btn btn-batman btn-lg">
                    <i class="fas fa-plus"></i> Registrar Primera Obra
                </a>
            </div>
        <?php else: ?>
            <div class="row" id="obrasContainer">
                <?php foreach ($obras as $obra): ?>
                    <div class="col-lg-4 col-md-6 mb-4 obra-item" 
                         data-nombre="<?php echo strtolower($obra['nombre']); ?>"
                         data-tipo="<?php echo strtolower($obra['tipo']); ?>"
                         data-pais="<?php echo strtolower($obra['pais']); ?>">
                        <div class="obra-card h-100">
                            <div class="position-relative">
                                <div class="obra-image">
                                    <?php if (!empty($obra['foto_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($obra['foto_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($obra['nombre']); ?>"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="placeholder-icon" style="display:none;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="placeholder-icon">
                                            <i class="fas fa-film"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="obra-type">
                                    <?php 
                                    $iconos = [
                                        'Película' => '🎬',
                                        'Serie' => '📺',
                                        'Cómic' => '📚',
                                        'Videojuego' => '🎮',
                                        'Otro' => '🎭'
                                    ];
                                    echo $iconos[$obra['tipo']] ?? '🎭';
                                    echo ' ' . $obra['tipo'];
                                    ?>
                                </div>
                            </div>
                            
                            <div class="card-body p-4">
                                <h5 class="card-title text-warning mb-3">
                                    <?php echo htmlspecialchars($obra['nombre']); ?>
                                </h5>
                                
                                <p class="card-text text-muted mb-3">
                                    <?php echo htmlspecialchars(substr($obra['descripcion'], 0, 100)) . (strlen($obra['descripcion']) > 100 ? '...' : ''); ?>
                                </p>
                                
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-globe"></i> <?php echo htmlspecialchars($obra['pais']); ?><br>
                                        <i class="fas fa-user-edit"></i> <?php echo htmlspecialchars($obra['autor']); ?><br>
                                        <i class="fas fa-code"></i> <?php echo htmlspecialchars($obra['codigo']); ?>
                                    </small>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-users"></i> 
                                        <?php echo contarPersonajes($obra['codigo'], $personajes); ?> personajes
                                    </span>
                                    
                                    <a href="detalle.php?codigo=<?php echo urlencode($obra['codigo']); ?>" 
                                       class="btn btn-batman btn-sm">
                                        <i class="fas fa-eye"></i> Detalle
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div id="noResults" class="text-center py-5" style="display: none;">
                <i class="fas fa-search" style="font-size: 3rem; color: #ffd700; opacity: 0.6;"></i>
                <h4 class="text-warning mt-3">No se encontraron obras</h4>
                <p class="text-muted">Intenta con otros términos de búsqueda</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad de búsqueda
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const obras = document.querySelectorAll('.obra-item');
            let visibleCount = 0;
            
            obras.forEach(function(obra) {
                const nombre = obra.dataset.nombre;
                const tipo = obra.dataset.tipo;
                const pais = obra.dataset.pais;
                
                if (nombre.includes(searchTerm) || tipo.includes(searchTerm) || pais.includes(searchTerm)) {
                    obra.style.display = 'block';
                    visibleCount++;
                } else {
                    obra.style.display = 'none';
                }
            });
            
            // Mostrar mensaje si no hay resultados
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0 && searchTerm !== '') {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
    </script>
</body>
</html>
