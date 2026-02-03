<style>
    @media print {

        /* Ocultar TODO el sistema ERP al imprimir cuando el modal PDF está abierto */
        body.no-scroll>*:not(#pdfOverlay) {
            display: none !important;
        }

        #pdfOverlay {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: auto !important;
            background: white !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: visible !important;
        }

        #pdfOverlay .edit-panel {
            box-shadow: none !important;
            border: none !important;
            width: 100% !important;
            max-width: none !important;
            height: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
        }

        #pdfOverlay .edit-panel>div:first-child {
            display: none !important;
            /* Ocultar cabecera del modal */
        }

        #pdfFrame {
            height: 1000px !important;
            /* Asegurar que el iframe se vea */
        }
    }
</style>

<!-- 📊 RESUMEN EJECUTIVO PREMIUM -->
<div class="stats-grid"
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card"
        style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 25px; border-radius: 24px; box-shadow: var(--glass-shadow); display: flex; align-items: center; gap: 20px;">
        <div
            style="width: 50px; height: 50px; background: rgba(41, 56, 135, 0.1); color: var(--accent-color); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <div>
            <p
                style="margin: 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Cotizaciones Total</p>
            <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);">
                <?= count($cotizaciones) ?>
            </h3>
        </div>
    </div>
    <div class="stat-card"
        style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 25px; border-radius: 24px; box-shadow: var(--glass-shadow); display: flex; align-items: center; gap: 20px;">
        <div
            style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-check-double"></i>
        </div>
        <div>
            <p
                style="margin: 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Aprobadas</p>
            <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);"><?php
            $aprobadas = array_filter($cotizaciones, fn($c) => $c['estatus'] == 'Aprobada' || $c['estatus'] == 'Convertida');
            echo count($aprobadas);
            ?></h3>
        </div>
    </div>
    <div class="stat-card"
        style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 25px; border-radius: 24px; box-shadow: var(--glass-shadow); display: flex; align-items: center; gap: 20px;">
        <div
            style="width: 50px; height: 50px; background: rgba(227, 81, 86, 0.1); color: var(--accent-secondary); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <p
                style="margin: 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Pendientes</p>
            <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);"><?php
            $pendientes = array_filter($cotizaciones, fn($c) => $c['estatus'] == 'Borrador');
            echo count($pendientes);
            ?></h3>
        </div>
    </div>
</div>

<!-- 🔝 BARRA DE ACCIONES -->
<div class="header-actions"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div>
        <h2 style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 28px; letter-spacing: -1px;">
            Ventas y Cotizaciones</h2>
        <p style="margin: 5px 0 0 0; color: var(--text-secondary); font-size: 14px;">Gestiona tus ofertas comerciales y
            conviértelas en ventas.</p>
    </div>
    <button class="btn btn-primary" onclick="openQuoteOverlay()"
        style="display: flex; align-items: center; gap: 10px; padding: 15px 30px; border-radius: 18px; background: var(--accent-color); box-shadow: 0 10px 25px rgba(41, 56, 135, 0.25);">
        <i class="fas fa-plus-circle" style="font-size: 18px;"></i>
        <span style="font-weight: 700;">Nueva Cotización</span>
    </button>
</div>

<!-- 📋 LISTADO PREMIUM -->
<div class="card"
    style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 28px; box-shadow: var(--glass-shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: rgba(41, 56, 135, 0.03); border-bottom: 1px solid var(--glass-border);">
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Folio / Versión</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Cliente</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Emisión / Vence</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Monto Total</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Estatus</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; text-align: right;">
                    Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($cotizaciones)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 100px 25px;">
                        <i class="fas fa-folder-open"
                            style="font-size: 50px; opacity: 0.1; display: block; margin-bottom: 20px;"></i>
                        Aún no tienes cotizaciones registradas.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($cotizaciones as $c):
                    // Priorizamos la existencia de un pedido vinculado para el estatus visual
                    $rawStatus = ($c['pedido_id']) ? 'Convertida' : ($c['estatus'] ?? 'Borrador');
                    $stKey = strtolower(trim($rawStatus));

                    $estatusMapping = [
                        'borrador' => ['bg' => 'rgba(100, 116, 139, 0.1)', 'text' => '#64748b', 'label' => 'BORRADOR', 'icon' => 'fa-edit'],
                        'enviada' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'text' => '#3b82f6', 'label' => 'ENVIADA', 'icon' => 'fa-paper-plane'],
                        'aprobada' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981', 'label' => 'APROBADA', 'icon' => 'fa-check-circle'],
                        'convertida' => ['bg' => 'rgba(139, 92, 246, 0.1)', 'text' => '#8b5cf6', 'label' => 'PEDIDO', 'icon' => 'fa-rocket'],
                        'cancelada' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444', 'label' => 'CANCELADA', 'icon' => 'fa-times-circle']
                    ];

                    // Fallback dinámico si no hay coincidencia exacta
                    $st = $estatusMapping[$stKey] ?? [
                        'bg' => 'rgba(100, 116, 139, 0.1)',
                        'text' => '#64748b',
                        'label' => strtoupper($rawStatus),
                        'icon' => 'fa-info-circle'
                    ];
                    ?>
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.3s;"
                        onmouseover="this.style.background='rgba(41, 56, 135, 0.01)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px 25px;">
                            <div style="font-weight: 800; color: var(--text-primary); font-size: 15px;"><?= $c['folio'] ?></div>
                            <div style="font-size: 11px; color: var(--text-secondary);">Versión: <?= $c['version'] ?></div>
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="font-weight: 600; color: var(--text-primary);"><?= $c['nombre_razon_social'] ?></div>
                            <div style="font-size: 11px; color: var(--text-secondary);">ID Cliente: #<?= $c['cliente_id'] ?>
                            </div>
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="font-size: 13px; color: var(--text-primary);">
                                <?= date('d/m/Y', strtotime($c['fecha_emision'])) ?>
                            </div>
                            <div style="font-size: 11px; color: var(--accent-secondary); font-weight: 600;">Exp:
                                <?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?>
                            </div>
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="font-weight: 900; color: var(--text-primary); font-size: 16px;">
                                $<?= number_format($c['total'], 2) ?></div>
                            <div style="font-size: 10px; color: #94a3b8;">Incluye IVA</div>
                        </td>
                        <td style="padding: 20px 25px;">
                            <span
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 800; background: <?= $st['bg'] ?>; color: <?= $st['text'] ?>; text-transform: uppercase;">
                                <i class="fas <?= $st['icon'] ?>"></i> <?= $st['label'] ?>
                            </span>
                        </td>
                        <td style="padding: 20px 25px; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <?php if ($c['estatus'] == 'Borrador'): ?>
                                    <a title="Aprobar para Venta"
                                        href="index.php?controller=Ventas&action=approve&id=<?= $c['id'] ?>"
                                        style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #10b981; color: white; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);"><i
                                            class="fas fa-check"></i></a>
                                <?php elseif ($c['estatus'] == 'Aprobada'): ?>
                                    <a title="Convertir a Pedido"
                                        href="index.php?controller=Pedidos&action=create_from_quote&quote_id=<?= $c['id'] ?>"
                                        style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: var(--accent-color); color: white; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 10px rgba(41, 56, 135, 0.2);"><i
                                            class="fas fa-rocket"></i></a>
                                    <a title="Crear Nueva Versión"
                                        href="index.php?controller=Ventas&action=newVersion&id=<?= $c['id'] ?>"
                                        style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #f59e0b; color: white; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);"><i
                                            class="fas fa-layer-group"></i></a>
                                <?php endif; ?>
                                <button onclick="openPdfOverlay(<?= $c['id'] ?>)" title="Vista Previa PDF / Imprimir"
                                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #fff1f2; color: #e35156; border: none; border-radius: 10px; cursor: pointer;"><i
                                        class="fas fa-file-pdf"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<!-- 📋 OVERLAY DE VISTA PREVIA PDF -->
<div id="pdfOverlay" class="edit-overlay" onclick="closePdfOverlay(event)">
    <div class="edit-panel"
        style="max-width: 900px; padding: 0; background: #f1f5f9; height: 90vh; display: flex; flex-direction: column;"
        onclick="event.stopPropagation()">
        <div
            style="padding: 15px 25px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; border-radius: 20px 20px 0 0;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button onclick="document.getElementById('pdfFrame').contentWindow.print()" class="btn"
                    style="background: var(--accent-secondary); color: white; border: none; padding: 8px 15px; border-radius: 10px; font-weight: 700; display: flex; align-items: center; gap: 8px; font-size: 12px; cursor: pointer;">
                    <i class="fas fa-print"></i> IMPRIMIR / PDF
                </button>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: var(--text-primary);">Vista Previa
                        de Cotización</h3>
                    <p style="margin: 0; font-size: 11px; color: var(--text-secondary);">Diseño Premium para Clientes
                    </p>
                </div>
            </div>
            <button onclick="closePdfOverlay(null, true)"
                style="background: #f1f5f9; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer;"><i
                    class="fas fa-times"></i></button>
        </div>
        <iframe id="pdfFrame" style="flex: 1; border: none; width: 100%; border-radius: 0 0 20px 20px;"></iframe>
    </div>
</div>

<!-- ⚠️ MODAL DE CONFIRMACIÓN GLASSMORPHISM -->
<div id="confirmCloseOverlay" class="edit-overlay" style="z-index: 30000;">
    <div class="edit-panel" style="max-width: 400px; padding: 30px; text-align: center; border-radius: 30px;"
        onclick="event.stopPropagation()">
        <div
            style="width: 70px; height: 70px; background: rgba(227, 81, 86, 0.1); color: var(--accent-secondary); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 style="font-weight: 800; color: var(--text-primary); margin-bottom: 10px; font-size: 20px;">¿Cerrar sesión
            de cotización?</h3>
        <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 25px; line-height: 1.6;">Si cierras
            ahora, se descartará cualquier <b>información seleccionada o agregada</b>. ¿Estás seguro que deseas salir?
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button type="button" onclick="hideConfirmModal()" class="btn"
                style="background: #f1f5f9; color: var(--text-primary); border: 1px solid #e2e8f0; font-weight: 700; border-radius: 12px; height: 45px; cursor: pointer;">Seguir
                Editando</button>
            <button type="button" onclick="confirmCloseQuote()" class="btn"
                style="background: var(--accent-secondary); color: white; border: none; font-weight: 800; border-radius: 12px; height: 45px; cursor: pointer; box-shadow: 0 8px 20px rgba(227, 81, 86, 0.2);">Sí,
                Salir</button>
        </div>
    </div>
</div>

<!-- 🎭 OVERLAY DEL CREADOR DE COTIZACIONES DINÁMICO -->
<div id="quoteOverlay" class="edit-overlay" onclick="closeQuoteOverlay(event)">
    <div class="edit-panel" style="max-width: 1000px; padding: 25px;" onclick="event.stopPropagation()">
        <div id="quoteOverlayContent">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div>
                    <h2
                        style="font-weight: 800; color: var(--text-primary); margin: 0; font-size: 22px; letter-spacing: -1px;">
                        Nueva Cotización Premium</h2>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 13px;">Arma tu oferta formal agregando
                        múltiples productos.</p>
                </div>
                <button onclick="closeQuoteOverlay(null, true)"
                    style="background: #f1f5f9; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer;"><i
                        class="fas fa-times"></i></button>
            </div>

            <form action="index.php?controller=Ventas&action=create" method="POST" id="quoteForm">
                <input type="hidden" name="items_json" id="itemsJsonInput">

                <!-- 🏗️ ESTRUCTURA DE CABECERA (Imagen 2) -->
                <div
                    style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 20px; margin-bottom: 20px; background: rgba(255,255,255,0.5); padding: 20px; border-radius: 15px; border: 1px solid var(--glass-border);">
                    <!-- Columna Izquierda: Cliente -->
                    <div>
                        <h3 style="margin: 0 0 10px 0; font-size: 16px; font-weight: 800; color: var(--text-primary);">
                            <i class="fas fa-user-tie" style="margin-right: 8px; color: var(--accent-color);"></i>
                            Cliente
                        </h3>
                        <div style="margin-bottom: 12px;">
                            <label class="form-label"
                                style="font-size: 10px; letter-spacing: 0.5px; margin-bottom: 4px;">Seleccionar
                                Cliente</label>
                            <select name="cliente_id" required class="form-input"
                                style="font-weight: 700; background: white; padding: 10px;">
                                <option value="">🔍 Buscar o seleccionar cliente...</option>
                                <?php foreach ($clientes as $cl): ?>
                                    <option value="<?= $cl['id'] ?>"><?= $cl['nombre_razon_social'] ?> (<?= $cl['rfc'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label"
                                style="font-size: 10px; letter-spacing: 0.5px; margin-bottom: 4px;">Contacto</label>
                            <select name="contacto_id" class="form-input" style="background: white; padding: 10px;">
                                <option value="">Seleccionar contacto...</option>
                            </select>
                        </div>
                    </div>

                    <!-- Columna Derecha: Términos Generales -->
                    <div style="border-left: 1px solid #e2e8f0; padding-left: 20px;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px; font-weight: 800; color: var(--text-primary);">
                            <i class="fas fa-file-contract" style="margin-right: 8px; color: var(--accent-color);"></i>
                            Términos Generales
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 0.6fr; gap: 15px;">
                            <div>
                                <label class="form-label" style="font-size: 10px; margin-bottom: 4px;">Moneda</label>
                                <select name="moneda" id="currencySelect" class="form-input"
                                    onchange="updateCurrencyUI()"
                                    style="font-weight: 800; color: var(--accent-color); background: white; padding: 10px;">
                                    <option value="MXN">MXN - Peso Mexicano</option>
                                    <option value="USD">USD - Dólar Estadounidense</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 10px; margin-bottom: 4px;">T. Cambio</label>
                                <input type="number" step="0.01" id="exchangeRate" value="20.00" class="form-input"
                                    onchange="updateCurrencyUI()"
                                    style="padding: 10px; font-weight: 700; text-align: center;">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                            <div>
                                <label class="form-label" style="font-size: 10px; margin-bottom: 4px;">Validez</label>
                                <select name="vigencia" class="form-input" style="background: white; padding: 10px;">
                                    <option value="15">15 Días</option>
                                    <option value="30" selected>30 Días</option>
                                    <option value="60">60 Días</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 10px; margin-bottom: 4px;">Fecha de
                                    Cotización</label>
                                <input type="date" name="fecha_emision" value="<?= date('Y-m-d') ?>" class="form-input"
                                    style="background: white; padding: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🛒 SELECTOR DE PRODUCTOS (Imagen 2) -->
                <div
                    style="background: white; padding: 15px; border-radius: 15px; border: 1px solid #e2e8f0; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-primary);">Productos
                        </h3>
                    </div>

                    <table style="width: 100%; border-collapse: collapse;" id="itemsTable">
                        <thead>
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <th
                                    style="padding: 10px; text-align: left; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                    Producto</th>
                                <th
                                    style="padding: 10px; text-align: left; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                    SKU</th>
                                <th
                                    style="padding: 10px; text-align: center; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                    Cantidad</th>
                                <th
                                    style="padding: 10px; text-align: right; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                    Precio Unitario</th>
                                <th
                                    style="padding: 10px; text-align: center; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                    Descuento</th>
                                <th
                                    style="padding: 10px; text-align: right; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                    Subtotal</th>
                                <th style="padding: 10px;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Items se cargan aquí -->
                        </tbody>
                    </table>

                    <!-- BARRA DE AGREGAR RÁPIDA -->
                    <div
                        style="display: grid; grid-template-columns: 2fr 0.8fr 1fr 0.5fr; gap: 12px; margin-top: 12px; align-items: flex-end; padding-top: 12px; border-top: 1px dashed #e2e8f0;">
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 700; color: var(--text-secondary); margin-bottom: 4px;">PRODUCTO
                                A
                                AGREGAR</label>
                            <select id="productSelect" class="form-input" onchange="updatePriceHint()"
                                style="height: 38px; font-size: 12px; padding: 0 10px;">
                                <option value="">Selecciona un item...</option>
                                <?php foreach ($productos as $prod): ?>
                                    <option value="<?= $prod['id'] ?>" data-price="<?= $prod['precio_venta'] ?>"
                                        data-sku="<?= $prod['sku'] ?>">
                                        <?= $prod['sku'] ?> - <?= $prod['descripcion'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 700; color: var(--text-secondary); margin-bottom: 4px;">CANT.</label>
                            <input type="number" id="itemQty" value="1" min="1" class="form-input"
                                style="height: 38px; font-size: 12px;">
                        </div>
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 700; color: var(--text-secondary); margin-bottom: 4px;">PRECIO
                                UNIT.
                                (<span class="currency-symbol">$</span>)</label>
                            <input type="number" id="itemPrice" step="0.01" class="form-input"
                                style="height: 38px; font-size: 12px;">
                        </div>
                        <button type="button" onclick="addItem()" class="btn btn-primary"
                            style="height: 38px; width: 100%; border-radius: 10px;"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <!-- 💰 FOOTER: RESUMEN Y ACCIONES (Imagen 2) -->
                <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px; align-items: flex-start;">
                    <div>
                        <!-- Espacio para notas o comentarios adicionales si se desea -->
                    </div>
                    <div
                        style="background: white; border-radius: 15px; border: 1px solid #e2e8f0; padding: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                        <h3 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 800; color: var(--text-primary);">
                            Resumen</h3>
                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 8px; color: var(--text-secondary); font-size: 13px;">
                            <span style="font-weight: 600;">Subtotal:</span>
                            <span id="lblSubtotal" style="font-weight: 700; color: var(--text-primary);">$0.00</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 8px; color: var(--text-secondary); font-size: 13px;">
                            <span style="font-weight: 600;">IVA (16%):</span>
                            <span id="lblIva" style="font-weight: 700; color: var(--text-primary);">$0.00</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 2px solid #f1f5f9; margin-top: 10px;">
                            <span style="font-weight: 800; color: var(--text-primary); font-size: 16px;">Total:</span>
                            <span id="lblTotal"
                                style="font-weight: 900; color: var(--accent-color); font-size: 20px;">$0.00</span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">
                            <button type="button" onclick="closeQuoteOverlay(null, true)" class="btn"
                                style="border: 1px solid #e2e8f0; background: #f8fafc; font-weight: 700; height: 40px; font-size: 13px;">Cancelar</button>
                            <button type="submit" class="btn btn-primary"
                                style="background: var(--accent-secondary); border: none; font-weight: 800; padding: 0; height: 40px; font-size: 13px;">Guardar
                                y Enviar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    let quoteItems = [];
    let currentCurrency = 'MXN';

    function openPdfOverlay(id) {
        const overlay = document.getElementById('pdfOverlay');
        const frame = document.getElementById('pdfFrame');
        document.body.appendChild(overlay);
        frame.src = `index.php?controller=Ventas&action=exportPDF&id=${id}`;
        overlay.classList.add('active');
        document.body.classList.add('no-scroll');
    }

    function closePdfOverlay(e, force = false) {
        if (force || (e && e.target.id === 'pdfOverlay')) {
            const overlay = document.getElementById('pdfOverlay');
            const frame = document.getElementById('pdfFrame');
            overlay.classList.remove('active');
            document.body.classList.remove('no-scroll');
            frame.src = "about:blank"; // Limpiar recursos
        }
    }

    function openQuoteOverlay() {
        const overlay = document.getElementById('quoteOverlay');
        document.body.appendChild(overlay); // Mover al body para evitar el blur del contenedor
        overlay.classList.add('active');
        document.body.classList.add('no-scroll');
        updateCurrencyUI();
    }

    function closeQuoteOverlay(e, force = false) {
        // DETENER TODO: Si el usuario intenta cerrar (clic fuera o X)
        const isClickOutside = e && e.target.id === 'quoteOverlay';

        if (force || isClickOutside) {
            // Siempre mostrar modal premium de confirmación una vez abierto
            showConfirmModal();
            return false;
        }
    }

    function showConfirmModal() {
        const overlay = document.getElementById('confirmCloseOverlay');
        document.body.appendChild(overlay);
        overlay.classList.add('active');
    }

    function hideConfirmModal() {
        document.getElementById('confirmCloseOverlay').classList.remove('active');
    }

    function confirmCloseQuote() {
        hideConfirmModal();
        execCloseQuote();
    }

    function execCloseQuote() {
        document.getElementById('quoteOverlay').classList.remove('active');
        document.body.classList.remove('no-scroll');
        quoteItems = [];
        renderItems();
    }

    function updateCurrencyUI() {
        const prevCurrency = currentCurrency;
        currentCurrency = document.getElementById('currencySelect').value;
        const rate = parseFloat(document.getElementById('exchangeRate').value) || 1;

        const symbols = document.querySelectorAll('.currency-symbol');
        const symbol = currentCurrency === 'USD' ? 'USD $' : '$';
        symbols.forEach(s => s.innerText = symbol);

        // Convertir items existentes
        if (prevCurrency !== currentCurrency) {
            quoteItems.forEach(item => {
                if (currentCurrency === 'USD') {
                    item.precio_unitario = item.precio_unitario / rate;
                } else {
                    item.precio_unitario = item.precio_unitario * rate;
                }
                item.total = item.cantidad * item.precio_unitario;
            });
            renderItems();
        }

        updatePriceHint();
        calculateTotals();
    }

    function updatePriceHint() {
        const select = document.getElementById('productSelect');
        const selectedOption = select.options[select.selectedIndex];
        const rate = parseFloat(document.getElementById('exchangeRate').value) || 1;

        if (selectedOption.value) {
            let basePrice = parseFloat(selectedOption.dataset.price);
            if (currentCurrency === 'USD') {
                document.getElementById('itemPrice').value = (basePrice / rate).toFixed(2);
            } else {
                document.getElementById('itemPrice').value = basePrice.toFixed(2);
            }
        }
    }

    function addItem() {
        const select = document.getElementById('productSelect');
        const qty = parseInt(document.getElementById('itemQty').value);
        const price = parseFloat(document.getElementById('itemPrice').value);
        const selected = select.options[select.selectedIndex];

        if (!selected.value || isNaN(qty) || isNaN(price)) {
            alert("Por favor selecciona un producto, cantidad y precio válido.");
            return;
        }

        quoteItems.push({
            producto_id: selected.value,
            sku: selected.dataset.sku,
            descripcion: selected.text.split(' - ')[1],
            cantidad: qty,
            precio_unitario: price,
            descuento: 0,
            total: qty * price
        });

        renderItems();
        select.value = "";
        document.getElementById('itemQty').value = 1;
        document.getElementById('itemPrice').value = "";
    }

    function removeItem(index) {
        quoteItems.splice(index, 1);
        renderItems();
    }

    function renderItems() {
        const body = document.getElementById('itemsBody');
        body.innerHTML = "";
        const symbol = currentCurrency === 'USD' ? 'USD $' : '$';

        quoteItems.forEach((item, index) => {
            const row = `
                <tr style="border-bottom: 1px solid #f1f5f9;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 8px 10px;">
                        <div style="font-weight: 700; color: var(--text-primary); text-transform: uppercase; font-size: 12px;">${item.descripcion}</div>
                    </td>
                    <td style="padding: 8px 10px; color: var(--text-secondary); font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600;">${item.sku}</td>
                    <td style="padding: 8px 10px; text-align: center;">
                        <input type="number" value="${item.cantidad}" onchange="updateItemQty(${index}, this.value)" style="width: 55px; padding: 4px; border: 1px solid #e2e8f0; border-radius: 6px; text-align: center; font-weight: 700; color: var(--accent-color); font-size: 12px;">
                    </td>
                    <td style="padding: 8px 10px; text-align: right; font-weight: 600; color: var(--text-primary); font-size: 12px;">${symbol}${item.precio_unitario.toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                    <td style="padding: 8px 10px; text-align: center;"><span style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; color: #64748b;">${item.descuento}%</span></td>
                    <td style="padding: 8px 10px; text-align: right; font-weight: 800; color: var(--accent-secondary); font-size: 13px;">${symbol}${item.total.toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                    <td style="padding: 8px 10px; text-align: right;">
                        <button type="button" onclick="removeItem(${index})" style="background: #fff1f2; border: none; color: #ef4444; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; transition: all 0.2s;"><i class="fas fa-trash-alt" style="font-size: 12px;"></i></button>
                    </td>
                </tr>
            `;
            body.innerHTML += row;
        });

        calculateTotals();
    }

    function updateItemQty(index, val) {
        const qty = parseInt(val);
        if (qty > 0) {
            quoteItems[index].cantidad = qty;
            quoteItems[index].total = qty * quoteItems[index].precio_unitario;
            renderItems();
        }
    }

    function calculateTotals() {
        let subtotal = quoteItems.reduce((acc, item) => acc + item.total, 0);
        let iva = subtotal * 0.16;
        let total = subtotal + iva;
        const symbol = currentCurrency === 'USD' ? 'USD $' : '$';

        document.getElementById('lblSubtotal').innerText = `${symbol}${subtotal.toLocaleString('es-MX', { minimumFractionDigits: 2 })}`;
        document.getElementById('lblIva').innerText = `${symbol}${iva.toLocaleString('es-MX', { minimumFractionDigits: 2 })}`;
        document.getElementById('lblTotal').innerText = `${symbol}${total.toLocaleString('es-MX', { minimumFractionDigits: 2 })}`;

        // Guardar en el input oculto para el enviarlo al backend
        document.getElementById('itemsJsonInput').value = JSON.stringify(quoteItems);
    }

    // Buscador en tiempo real para la tabla de items ya agregados
    document.getElementById('productSearch')?.addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#itemsBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>