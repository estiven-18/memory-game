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
    </style>
</head>
<body>
