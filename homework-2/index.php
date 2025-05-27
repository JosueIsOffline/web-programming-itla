<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman Universe - CRUD System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap');
        .batman-font { font-family: 'Orbitron', monospace; }
        .batman-gradient { background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%); }
        .batman-card { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); border: 1px solid #fbbf24; }
        .batman-btn { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #000; transition: all 0.3s ease; }
        .batman-btn:hover { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); transform: translateY(-2px); }
        .batman-logo { filter: drop-shadow(0 0 10px #fbbf24); }
        @keyframes batmanFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: batmanFadeIn 0.6s ease-out; }
    </style>
</head>
<body class="batman-gradient min-h-screen text-yellow-400">
    <?php include 'nav.php'; ?>
    
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center mb-12 fade-in">
            <i class="fas fa-mask text-8xl text-yellow-400 batman-logo mb-6"></i>
            <h2 class="batman-font text-5xl font-black text-yellow-400 mb-4">BATMAN UNIVERSE</h2>
            <p class="text-xl text-gray-300 mb-8">Sistema de Gestión Completo para el Universo de Batman</p>
            <p class="text-lg text-gray-400 mb-12">Gestiona obras, personajes y toda la información del universo Batman con operaciones CRUD completas</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="batman-card p-6 rounded-xl text-center hover:scale-105 transition-transform">
                    <i class="fas fa-film text-4xl text-yellow-400 mb-4"></i>
                    <h3 class="batman-font text-xl font-bold mb-2">Gestionar Obras</h3>
                    <p class="text-gray-400 mb-4">Crear, leer, actualizar y eliminar obras</p>
                    <a href="registrar_obra.php" class="batman-btn px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-plus mr-1"></i>Crear
                    </a>
                </div>
                
                <div class="batman-card p-6 rounded-xl text-center hover:scale-105 transition-transform">
                    <i class="fas fa-users text-4xl text-yellow-400 mb-4"></i>
                    <h3 class="batman-font text-xl font-bold mb-2">Gestionar Personajes</h3>
                    <p class="text-gray-400 mb-4">Agregar y administrar personajes</p>
                    <a href="agregar_personaje.php" class="batman-btn px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-user-plus mr-1"></i>Agregar
                    </a>
                </div>
                
                <div class="batman-card p-6 rounded-xl text-center hover:scale-105 transition-transform">
                    <i class="fas fa-list text-4xl text-yellow-400 mb-4"></i>
                    <h3 class="batman-font text-xl font-bold mb-2">Ver Obras</h3>
                    <p class="text-gray-400 mb-4">Listado completo con personajes</p>
                    <a href="ver_obras.php" class="batman-btn px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-eye mr-1"></i>Ver Todo
                    </a>
                </div>
                
                <div class="batman-card p-6 rounded-xl text-center hover:scale-105 transition-transform">
                    <i class="fas fa-print text-4xl text-yellow-400 mb-4"></i>
                    <h3 class="batman-font text-xl font-bold mb-2">Reportes</h3>
                    <p class="text-gray-400 mb-4">Vistas optimizadas para imprimir</p>
                    <a href="ver_obras.php" class="batman-btn px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-file-pdf mr-1"></i>Generar
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="batman-card p-8 rounded-xl fade-in">
            <h3 class="batman-font text-2xl font-bold text-yellow-400 mb-6 text-center">
                <i class="fas fa-chart-bar mr-3"></i>ESTADÍSTICAS DEL SISTEMA
            </h3>
            
            <?php
            // Leer estadísticas
            $total_obras = 0;
            $total_personajes = 0;
            
            if (file_exists('datos/obras.json')) {
                $obras = json_decode(file_get_contents('datos/obras.json'), true) ?? [];
                $total_obras = count($obras);
            }
            
            if (file_exists('datos/personajes.json')) {
                $personajes = json_decode(file_get_contents('datos/personajes.json'), true) ?? [];
                $total_personajes = count($personajes);
            }
            ?>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="bg-yellow-400 text-black rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-film text-2xl"></i>
                    </div>
                    <h4 class="batman-font text-3xl font-bold text-yellow-400"><?= $total_obras ?></h4>
                    <p class="text-gray-300">Obras Registradas</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-yellow-400 text-black rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h4 class="batman-font text-3xl font-bold text-yellow-400"><?= $total_personajes ?></h4>
                    <p class="text-gray-300">Personajes Creados</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-yellow-400 text-black rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-database text-2xl"></i>
                    </div>
                    <h4 class="batman-font text-3xl font-bold text-yellow-400"><?= $total_obras > 0 ? round($total_personajes / $total_obras, 1) : 0 ?></h4>
                    <p class="text-gray-300">Promedio Personajes/Obra</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
