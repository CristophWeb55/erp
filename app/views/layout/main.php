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
                <a href="index.php?controller=Logistica&action=index"
                    class="nav-item <?= ($controller == 'Logistica') ? 'active' : '' ?>">
                    <i class="fas fa-truck"></i>
                    <span>Logística</span>
                </a>
                <a href="index.php?controller=Inventario&action=index"
                    class="nav-item <?= ($controller == 'Inventario') ? 'active' : '' ?>">
                    <i class=" fas fa-warehouse"></i>
                    <span>Inventario</span>
                </a>
                <a href="index.php?controller=Compras&action=index"
                    class="nav-item <?= ($controller == 'Compras') ? 'active' : '' ?>">
                    <i class=" fas fa-shopping-cart"></i>
                    <span>Compras</span>
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


    <!-- Modal Flotante de Impresión Global -->
    <div id="modalPrint"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 2000; align-items: center; justify-content: center; padding: 20px; animation: fadeIn 0.3s ease-out;">
        <div
            style="background: #f8fafc; width: 100%; max-width: 1000px; height: 90vh; border-radius: 20px; display: flex; flex-direction: column; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid rgba(255,255,255,0.5);">

            <!-- Header -->
            <div
                style="background: white; padding: 15px 25px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; z-index: 10;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <button onclick="printFrame()"
                        style="background: #e11d48; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 11px; letter-spacing: 0.5px; box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.2); transition: all 0.2s;">
                        <i class="fas fa-print"></i> IMPRIMIR / PDF
                    </button>
                    <div>
                        <h3 style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 15px;">Vista
                            Previa de Documento</h3>
                        <span
                            style="display: block; font-size: 11px; color: var(--text-secondary); margin-top: 2px;">Formato
                            Oficial para Clientes</span>
                    </div>
                </div>

                <button onclick="document.getElementById('modalPrint').style.display='none'"
                    style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 16px; padding: 5px; display: flex; align-items: center; justify-content: center; transition: color 0.2s;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Contenedor del Preview -->
            <div
                style="flex: 1; padding: 40px; overflow: hidden; display: flex; justify-content: center; background: #e2e8f0; position: relative;">
                <div
                    style="width: 100%; max-width: 800px; height: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.15); border-radius: 4px; overflow: hidden; background: white;">
                    <iframe id="printFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
            </div>

            <!-- Footer -->
            <div
                style="background: white; padding: 15px 25px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; align-items: center; z-index: 10;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <div style="text-align: right; font-size: 10px; color: var(--text-secondary); margin-right: 10px;">
                        <p style="margin: 0;">Los precios no incluyen IVA salvo que se especifique.</p>
                        <p style="margin: 2px 0 0 0;">Verifique los datos antes de imprimir.</p>
                    </div>
                    <button onclick="printFrame()"
                        style="background: #e11d48; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 12px; letter-spacing: 0.5px; box-shadow: 0 4px 6px -1px rgba(225, 29, 72, 0.2); transition: all 0.2s;">
                        <i class="fas fa-file-pdf"></i> IMPRIMIR / GUARDAR PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPrintModal(id) {
            const modal = document.getElementById('modalPrint');
            const iframe = document.getElementById('printFrame');
            // Cache busting with timestamp to force reload
            iframe.src = 'index.php?controller=Logistica&action=print&id=' + id + '&t=' + new Date().getTime();
            modal.style.display = 'flex';
        }

        function printFrame() {
            const iframe = document.getElementById('printFrame');
            if (iframe.contentWindow) {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }
        }
    </script>
    <script src="js/main.js"></script>
</body>

</html>