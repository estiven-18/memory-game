<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria - <?php echo isset($pagina) ? $pagina : 'Inicio'; ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #00A86B;
            --secondary-color: #ffffff;
        }
        
        body {
            background: #ffffff;
            min-height: 100vh;
        }
        
        .bg-gradient-primary {
            background: #00A86B !important;
        }
        
        .card-deck-item {
            position: relative;
            overflow: hidden;
            border: 2px solid #00A86B;
        }
        
        .card-deck-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: #00A86B;
        }
        
        .memory-card {
            aspect-ratio: 3/4;
            position: relative;
            cursor: pointer;
            transform-style: preserve-3d;
            transition: transform 0.6s;
        }
        
        .memory-card.flipped {
            transform: rotateY(180deg);
        }
        
        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .card-front {
            background: white;
            transform: rotateY(180deg);
        }
        
        .card-front img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }
        
        .card-back {
            background: #00A86B;
            font-size: 4em;
            color: white;
        }
        
        .memory-card.matched {
            opacity: 5.0;
            pointer-events: none;
        }
        
        /* Estilos para navbar más grande */
        .navbar {
            padding: 2rem 0 !important;
            min-height: 90px;
        }
        
        .navbar-brand {
            font-size: 2.2rem !important;
        }
        
        .nav-link {
            font-size: 1.5rem !important;
            padding: 0.75rem 1.25rem !important;
        }
        
        /* Responsive para móviles */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 0 !important;
                min-height: 60px;
            }
            
            .navbar-brand {
                font-size: 1.3rem !important;
            }
            
            .nav-link {
                font-size: 1.1rem !important;
                padding: 0.5rem 1rem !important;
            }
        }
        
        /* Hover para botones verdes */
        .btn[style*="background: #00A86B"]:hover {
            background: #008557 !important;
            transition: background 0.3s ease;
        }
        
        /* Hacer las tarjetas de mazos más grandes */
        .card-deck-item {
            border-radius: 15px;
        }
        .logout{
            color: white !important;
            background-color: #dc3545 !important;
            border-radius: 10px;
        }

        .logout:hover{
            background-color: #bb2d3b !important;
            color: white !important;
        }
        
        .card-deck-item .card-body {
            padding: 2rem;
        }
        
        .card-deck-item .card-title {
            font-size: 1.8rem !important;
            margin-bottom: 1rem !important;
        }
        
        .card-deck-item .card-text {
            font-size: 1.2rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        .card-deck-item .bg-light h4 {
            font-size: 2.5rem !important;
        }
        
        .card-deck-item .bg-light small {
            font-size: 1rem !important;
        }
        
        .card-deck-item .bg-light {
            padding: 1.5rem !important;
        }
        
        .card-deck-item .btn {
            font-size: 1.3rem !important;
            padding: 0.75rem !important;
        }
        
        .card-deck-item .btn-sm {
            font-size: 1.1rem !important;
            padding: 0.6rem 1rem !important;
        }
        
        .drop-zone {
            border: 3px dashed #00A86B;
            border-radius: 15px;
            padding: 60px 20px;
            text-align: center;
            background: #f9f9f9;
            cursor: pointer;
        }
        
        .drop-zone.dragover {
            background: #e8ffe8;
            border-color: #00A86B;
        }
        
        .card-preview-item {
            aspect-ratio: 3/4;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        
        .card-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Estilos para stat-box grande en ver_mazo */
        .stat-box-large {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 2.5rem 4rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 3px solid #00A86B;
        }
        
        .stat-value-large {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .stat-label-large {
            font-size: 1.3rem;
            font-weight: 500;
        }
        
        /* Hover para botones outline */
        .btn-outline-success:hover {
            background: #00A86B !important;
            border-color: #00A86B !important;
            color: white !important;
        }
        
        /* Hover para tarjetas de dificultad */
        .dificultad-facil:hover {
            border-color: #00A86B !important;
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 168, 107, 0.15) !important;
        }
        
        .dificultad-medio:hover {
            border-color: #ffc107 !important;
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15) !important;
        }
        
        .dificultad-dificil:hover {
            border-color: #dc3545 !important;
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15) !important;
        }
        
        /* Responsive para móviles - dificultad */
        @media (max-width: 768px) {
            .dificultad-facil, .dificultad-medio, .dificultad-dificil {
                margin-bottom: 1rem;
            }
            
            .dificultad-facil .card-body,
            .dificultad-medio .card-body,
            .dificultad-dificil .card-body {
                padding: 2rem !important;
            }
            
            .dificultad-facil h3,
            .dificultad-medio h3,
            .dificultad-dificil h3 {
                font-size: 1.5rem !important;
            }
            
            .dificultad-facil .mb-4,
            .dificultad-medio .mb-4,
            .dificultad-dificil .mb-4 {
                font-size: 2rem !important;
                margin-bottom: 1rem !important;
            }
            
            .dificultad-facil .fs-4,
            .dificultad-medio .fs-4,
            .dificultad-dificil .fs-4 {
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>
<body>
