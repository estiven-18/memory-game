<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Juego de Memoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../ASSETS/css/registro.css">

    
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="registro-card">
                    <div class="registro-header">
                        <h2>Registro</h2>
                        <p class="mb-0">Juego de Memoria</p>
                    </div>
                    <div class="registro-body">
                        <form id="registroForm">
                            <input type="hidden" name="rol" value="JUGADOR">

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>

                            <div class="mb-3">
                                <label for="numero_ficha" class="form-label">Número de Ficha</label>
                                <input type="text" class="form-control" id="numero_ficha" name="numero_ficha" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="btnRegistro">
                                Registrarse
                            </button>

                            <div class="text-center mt-3">
                                <a href="login.php" class="text-decoration-none" style="color: #00A86B;">¿Ya tienes cuenta? Inicia sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php require_once './layout/footer.php'; ?>
    <script src="../ASSETS/js/registro.js"></script>
</body>

</html>