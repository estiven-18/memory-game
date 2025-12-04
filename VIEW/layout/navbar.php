<?php

//* NO SE PUEDE ENTRAR SI NO ERES ADMIN

$rol=$_SESSION['rol'];
?>

<?php if ($rol == 'admin') { ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary sticky-top shadow-sm h">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <span class="fw-bold">Juego de Memoria</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link  <?php echo ($pagina == 'Inicio') ? 'active' : ''; ?>" href="index.php">
                        Inicio
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="crear_mazo.php">
                        Crear Mazo
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php } ?>