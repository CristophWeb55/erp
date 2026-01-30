<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ERP Genesis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            box-shadow: var(--glass-shadow);
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-logo {
            font-size: 40px;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-secondary);
            padding-left: 5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border-radius: 12px;
            border: 1px solid var(--glass-border);
            background: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            background: white;
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: var(--accent-color);
            color: white;
            border: none;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 10px 20px var(--accent-glow);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px var(--accent-glow);
            filter: brightness(1.1);
        }

        .error-msg {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 10px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
    </style>
</head>

<body>
    <div class="bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="login-card">
        <div class="login-logo">
            <img src="assets/logo.png" alt="URICA" style="width: 250px; margin-bottom: 20px;">
        </div>
        <h1 class="login-title">URICA ERP</h1>
        <p class="login-subtitle">Gestión Eléctrica y Trazabilidad de Pedimentos</p>


        <?php if (isset($error)): ?>
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=Auth&action=login" method="POST">
            <div class="form-group">
                <label>Usuario</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" class="form-control" placeholder="Ingresa tu usuario" required
                        autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                Iniciar Sesión <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
            </button>
        </form>

        <div style="margin-top: 30px; font-size: 12px; color: var(--text-secondary);">
            <p>Acceso Demo: <b>admin</b> / <b>admin123</b></p>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>