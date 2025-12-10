<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Juego de Memoria</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../ASSETS/css/login.css">

    <!-- <style>

        body {
            background: linear-gradient(135deg, #f5f5f5ff 0%, #ffffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .login-header {
            background: #00A86B;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body {
            padding: 40px;
        }
        .btn-primary {
            background: #00A86B;
            border-color: #00A86B;
        }
        .btn-primary:hover {
            background: #00774d;
            border-color: #00774d;
        }
        .role-selector {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .role-option {
            flex: 1;
            text-align: center;
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .role-option:hover {
            border-color: #00A86B;
        }
        .role-option.active {
            border-color: #00A86B;
            background: #f0fff8;
        }
        .role-option input[type="radio"] {
            display: none;
        }
        .role-option h5 {
            margin: 0;
            color: #333;
        }
    </style> -->
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