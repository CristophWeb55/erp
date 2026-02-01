<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URICA ERP - Sistema de Gestión Eléctrica</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css?v=<?= time() ?>">
</head>

<body>
    <div class="bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="assets/logo.png" alt="URICA" style="height: 35px; width: auto;">
            </div>


            <nav>
                <a href="index.php?controller=Dashboard&action=index"
                    class="nav-item <?= ($controller == 'Dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <p
                    style="margin: 20px 0 10px 10px; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px;">
                    Catálogos</p>
                <a href="index.php?controller=Terceros&action=index"
                    class="nav-item <?= ($controller == 'Terceros') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
                    <span>Terceros</span>
                </a>
                <a href="index.php?controller=Productos&action=index"
                    class="nav-item <?= ($controller == 'Productos') ? 'active' : '' ?>">
                    <i class="fas fa-box"></i>
                    <span>Productos</span>
                </a>

                <p
                    style="margin: 20px 0 10px 10px; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px;">
                    Ventas</p>
                <a href="index.php?controller=Ventas&action=index"
                    class="nav-item <?= ($controller == 'Ventas') ? 'active' : '' ?>">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Cotizaciones</span>
                </a>
                <a href="index.php?controller=Pedidos&action=index"
                    class="nav-item <?= ($controller == 'Pedidos') ? 'active' : '' ?>">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Pedidos</span>
                </a>

                <p
                    style="margin: 20px 0 10px 10px; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px;">
                    Operaciones</p>
                <a href="index.php?controller=Compras&action=index"
                    class="nav-item <?= ($controller == 'Compras') ? 'active' : '' ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Compras</span>
                </a>
                <a href="index.php?controller=Inventario&action=index"
                    class="nav-item <?= ($controller == 'Inventario') ? 'active' : '' ?>">
                    <i class="fas fa-warehouse"></i>
                    <span>Inventario</span>
                </a>

                <p
                    style="margin: 20px 0 10px 10px; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px;">
                    Finanzas</p>
                <a href="index.php?controller=Facturacion&action=index"
                    class="nav-item <?= ($controller == 'Facturacion') ? 'active' : '' ?>">
                    <i class="fas fa-receipt"></i>
                    <span>Facturación</span>
                </a>
                <a href="index.php?controller=Tesoreria&action=index"
                    class="nav-item <?= ($controller == 'Tesoreria') ? 'active' : '' ?>">
                    <i class="fas fa-wallet"></i>
                    <span>Cobranza</span>
                </a>

                <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid var(--glass-border);">
                    <a href="index.php?controller=Auth&action=logout" class="nav-item" style="color: #ef4444;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Header -->
            <header class="header">
                <div class="header-title">
                    <?= $pageTitle ?? 'Panel de Control' ?>
                </div>

                <div class="user-profile">
                    <div style="text-align: right;">
                        <p style="font-weight: 600; font-size: 14px;"><?= $_SESSION['user_name'] ?? 'Usuario' ?></p>
                        <p style="font-size: 11px; color: var(--text-secondary);"><?= $_SESSION['user_role'] ?? 'Rol' ?>
                        </p>
                    </div>
                    <div class="user-avatar"></div>
                </div>

            </header>

            <!-- Content -->
            <main class="content-area">
                <?= $content ?>
            </main>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>