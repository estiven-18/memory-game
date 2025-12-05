<?php
$pagina = "Seleccionar Dificultad";

session_start();

//* verificar que el usuario este logueado 
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

// $deck_id = isset($_GET['deck_id']) ? $_GET['deck_id'] : null;

$deck_id = $_GET['deck_id'];

//* si no hay mazo en la url redirigir al inicio
if (!$deck_id) {
    header('location: ./index.php');
    exit();
}
?>

<?php
require_once './layout/header.php';
require_once './layout/navbar.php';
?>

<style>
    .dificultad-container {
        max-width: 800px;
        margin: 80px auto;
        padding: 20px;
    }

    .titulo {
        text-align: center;
        margin-bottom: 50px;
    }

    .titulo h1 {
        color: #333;
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .titulo p {
        color: #666;
        font-size: 18px;
    }

    .niveles {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .nivel-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .nivel-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .nivel-card.facil {
        border-top: 5px solid #2ecc71;
    }

    .nivel-card.facil:hover {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: white;
    }

    .nivel-card.medio {
        border-top: 5px solid #f39c12;
    }

    .nivel-card.medio:hover {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
    }

    .nivel-card.dificil {
        border-top: 5px solid #e74c3c;
    }

    .nivel-card.dificil:hover {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .nivel-icono {
        font-size: 60px;
        margin-bottom: 20px;
    }

    .nivel-titulo {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .nivel-descripcion {
        font-size: 14px;
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .nivel-detalles {
        font-size: 16px;
        font-weight: 500;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(0,0,0,0.1);
    }

    .btn-volver {
        display: block;
        max-width: 200px;
        margin: 40px auto 0;
        padding: 12px 30px;
        background: #95a5a6;
        color: white;
        text-align: center;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-volver:hover {
        background: #7f8c8d;
        color: white;
    }
</style>

<div class="dificultad-container">
    <div class="titulo">
        <h1>Selecciona la Dificultad</h1>
        <p>Elige el nivel que prefieras para comenzar a jugar</p>
    </div>
<!--cambiar la cantidad de lad caratssssssssssssssssssssssssssssssssssssssssssssssssssssss -->
    <div class="niveles">
        <!-- Nivel Fácil -->
        <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=facil" class="nivel-card facil">
            <div class="nivel-titulo">Fácil</div>
            <div class="nivel-descripcion">
                Perfecto para principiantes
            </div>
            <div class="nivel-detalles">
                16 cartas<br>
            </div>
        </a>

        <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=medio" class="nivel-card medio">
            <div class="nivel-titulo">Medio</div>
            <div class="nivel-descripcion">
                Un desafío moderado
            </div>
            <div class="nivel-detalles">
                16 cartas<br>
            </div>
        </a>

        <a href="jugar.php?id_mazo=<?php echo $deck_id; ?>&dificultad=dificil" class="nivel-card dificil">
            <div class="nivel-titulo">Difícil</div>
            <div class="nivel-descripcion">
                Solo para expertos
            </div>
            <div class="nivel-detalles">
                36 cartas
            </div>
        </a>
    </div>

    <a href="index.php" class="btn-volver">← Volver al Inicio</a>
</div>

<?php require_once './layout/footer.php'; ?>
