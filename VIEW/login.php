<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juego de Memoria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../ASSETS/css/login.css">

   
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <h2>Iniciar Sesión</h2>
                        <p class="mb-0">Juego de Memoria</p>
                    </div>
                    <div class="login-body">
                        <form id="loginForm">
                            <div class="role-selector">
                                <label class="role-option active">
                                    <input type="radio" name="rol" value="JUGADOR" checked>
                                    <h5>Jugador</h5>
                                </label>
                                <label class="role-option">
                                    <input type="radio" name="rol" value="ADMIN">
                                    <h5>Admin</h5>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>

                            <div class="mb-3" id="numeroFichaGroup">
                                <label for="numero_ficha" class="form-label">Número de Ficha</label>
                                <input type="text" class="form-control" id="numero_ficha" name="numero_ficha" required>
                            </div>

                            <div class="mb-3 d-none" id="passwordGroup">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <button type="submit" class="btn btn-primary w-100" id="btnLogin">
                                Iniciar Sesión
                            </button>


                            <div class="text-center mt-3" id="linkRegistro">
                                <a href="registro.php" class="text-decoration-none" style="color: #00A86B;">¿No tienes cuenta? Regístrate</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once './layout/footer.php'; ?>
    <script src="../ASSETS/js/login.js"></script>
</body>

</html>