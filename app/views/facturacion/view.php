<div class="glass-panel" style="padding: 40px; border-radius: 20px; max-width: 900px; margin: 0 auto;">

    <!-- Action Bar -->
    <div class="no-print"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid rgba(0,0,0,0.1); padding-bottom: 20px;">
        <a href="index.php?controller=Facturacion&action=index"
            style="color: var(--text-secondary); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()"
                style="background: white; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 8px; font-weight: 700; color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button onclick="window.print()"
                style="background: #ef4444; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; color: white; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);">
                <i class="fas fa-file-pdf"></i> Descargar PDF
            </button>
            <a href="index.php?controller=Facturacion&action=enviar&id=<?= $factura['id'] ?>"
                style="text-decoration: none; background: #3b82f6; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; color: white; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);">
                <i class="fas fa-envelope"></i> Enviar
            </a>
        </div>
    </div>

    <!-- Invoice Header -->
    <div style="display: flex; justify-content: space-between; margin-bottom: 40px;">
        <div style="flex: 1;">
            <img src="assets/logo.png" alt="URICA" style="height: 50px; margin-bottom: 15px;">
            <h1 style="font-size: 24px; font-weight: 800; color: var(--text-primary); margin: 0;">FACTURA ELECTRÓNICA
            </h1>
            <p style="color: var(--text-primary); margin: 5px 0; font-weight: 600;">URICA ELÉCTRICA Y CONTROL
                ESPECIALIZADO</p>
            <p style="color: var(--text-secondary); font-size: 12px; margin: 0;">RFC: UEC123456789</p>
            <p style="color: var(--text-secondary); font-size: 12px; margin: 0;">Régimen Fiscal: 601 - General de Ley
                Personas Morales</p>
            <p style="color: var(--text-secondary); font-size: 12px; margin: 0;">Lugar de Expedición: 66450</p>
        </div>
        <div style="text-align: right; flex: 1;">
            <div
                style="background: #f8fafc; padding: 15px; border-radius: 12px; display: inline-block; text-align: left; min-width: 250px;">
                <div style="margin-bottom: 10px;">
                    <span
                        style="display: block; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">Folio
                        Fiscal (UUID)</span>
                    <span
                        style="font-family: monospace; font-size: 11px; font-weight: 600; color: var(--text-primary); word-break: break-all;">
                        <?= $factura['folio_fiscal_uuid'] ?>
                    </span>
                </div>
                <div style="margin-bottom: 10px;">
                    <span
                        style="display: block; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">No.
                        de Serie del CSD</span>
                    <span style="font-size: 12px; font-weight: 600;">00001000000501234567</span>
                </div>
                <div>
                    <span
                        style="display: block; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">Fecha
                        y Hora de Emisión</span>
                    <span style="font-size: 12px; font-weight: 600;">
                        <?= $factura['fecha_emision'] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Info -->
    <div
        style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; padding: 25px; border: 1px solid rgba(0,0,0,0.05); border-radius: 12px;">
        <div>
            <h3
                style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #6366f1; margin: 0 0 10px 0;">
                Receptor</h3>
            <p style="font-weight: 800; font-size: 16px; margin: 0 0 5px 0; color: var(--text-primary);">
                <?= $factura['cliente_nombre'] ?>
            </p>
            <p style="margin: 0; font-size: 13px; color: var(--text-secondary);">RFC: <span
                    style="font-weight: 600; color: var(--text-primary);">
                    <?= $factura['cliente_rfc'] ?>
                </span></p>
            <p style="margin: 2px 0 0 0; font-size: 13px; color: var(--text-secondary);">Uso CFDI: G03 - Gastos en
                general</p>
            <p style="margin: 2px 0 0 0; font-size: 13px; color: var(--text-secondary);">
                <?= $factura['cliente_direccion'] ?>
            </p>
        </div>
        <div>
            <h3
                style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #6366f1; margin: 0 0 10px 0;">
                Datos del Pedido</h3>
            <p style="margin: 0 0 5px 0; font-size: 13px; color: var(--text-secondary);">Referencia: <span
                    style="font-weight: 600; color: var(--text-primary);">
                    <?= $factura['pedido_folio'] ?>
                </span></p>
            <p style="margin: 0 0 5px 0; font-size: 13px; color: var(--text-secondary);">Moneda: <span
                    style="font-weight: 600; color: var(--text-primary);">MXN Peso Mexicano</span></p>
            <p style="margin: 0 0 5px 0; font-size: 13px; color: var(--text-secondary);">Forma de Pago: <span
                    style="font-weight: 600; color: var(--text-primary);">99 - Por definir</span></p>
            <p style="margin: 0 0 5px 0; font-size: 13px; color: var(--text-secondary);">Método de Pago: <span
                    style="font-weight: 600; color: var(--text-primary);">PPD - Pago en parcialidades o diferido</span>
            </p>
        </div>
    </div>

    <!-- Concepts Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                <th
                    style="padding: 12px; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">
                    Clave Prod/Serv</th>
                <th
                    style="padding: 12px; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">
                    Cantidad</th>
                <th
                    style="padding: 12px; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700;">
                    Unidad</th>
                <th
                    style="padding: 12px; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700; width: 40%;">
                    Descripción</th>
                <th
                    style="padding: 12px; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700; text-align: right;">
                    Precio Unitario</th>
                <th
                    style="padding: 12px; font-size: 10px; text-transform: uppercase; color: var(--text-secondary); font-weight: 700; text-align: right;">
                    Importe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($factura['items'] as $item): ?>
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 12px; font-size: 12px; color: var(--text-secondary);">85121500</td>
                    <td style="padding: 12px; font-size: 12px; font-weight: 600;">
                        <?= $item['cantidad'] ?>
                    </td>
                    <td style="padding: 12px; font-size: 12px; color: var(--text-secondary);">H87 - Pieza</td>
                    <td style="padding: 12px;">
                        <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">
                            <?= $item['descripcion'] ?>
                        </div>
                        <div style="font-size: 11px; color: var(--text-secondary);">SKU:
                            <?= $item['sku'] ?>
                        </div>
                    </td>
                    <td style="padding: 12px; text-align: right; font-size: 13px; font-family: monospace;">$
                        <?= number_format($item['precio_unitario'], 2) ?>
                    </td>
                    <td
                        style="padding: 12px; text-align: right; font-size: 13px; font-weight: 700; font-family: monospace;">
                        $
                        <?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Totals & QR -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div style="display: flex; gap: 20px; align-items: center;">
            <div
                style="width: 120px; height: 120px; background: white; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px;">
                <!-- Simulated QR -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $factura['folio_fiscal_uuid'] ?>"
                    style="width: 100%; height: 100%; opacity: 0.8;">
            </div>
            <div style="width: 300px;">
                <p style="font-size: 10px; color: var(--text-secondary); margin: 0 0 5px 0;">Sello Digital del CFDI:</p>
                <div style="font-size: 9px; color: #94a3b8; word-break: break-all; line-height: 1.2;">
                    IIyT+8j7q... (simulado) ...==
                </div>
            </div>
        </div>

        <table style="width: 300px;">
            <tr>
                <td style="padding: 5px; text-align: right; font-size: 13px; color: var(--text-secondary);">Subtotal:
                </td>
                <td style="padding: 5px; text-align: right; font-size: 14px; font-weight: 600;">$
                    <?= number_format($factura['total'] / 1.16, 2) ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 5px; text-align: right; font-size: 13px; color: var(--text-secondary);">IVA (16%):
                </td>
                <td style="padding: 5px; text-align: right; font-size: 14px; font-weight: 600;">$
                    <?= number_format($factura['total'] - ($factura['total'] / 1.16), 2) ?>
                </td>
            </tr>
            <tr style="border-top: 2px solid #e2e8f0;">
                <td style="padding: 10px 5px; text-align: right; font-size: 16px; font-weight: 800; color: #6366f1;">
                    Total:</td>
                <td style="padding: 10px 5px; text-align: right; font-size: 18px; font-weight: 800; color: #6366f1;">$
                    <?= number_format($factura['total'], 2) ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer Disclaimer -->
    <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px; text-align: center;">
        <p style="font-size: 10px; color: var(--text-secondary);">Este documento es una representación impresa de un
            CFDI (Simulado para Demo).</p>
    </div>
</div>

<style>
    @media print {
        .glass-panel {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }

        .no-print,
        header,
        aside {
            display: none !important;
        }

        .app-container {
            display: block !important;
            padding: 0 !important;
        }

        .main-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        body {
            background: white !important;
        }
    }
</style>


<!-- Floating Toast Notification (Enhanced) -->
<div id="toast"
    style="position: fixed; top: -100px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 15px 30px; border-radius: 50px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4); display: flex; align-items: center; gap: 15px; z-index: 10000; transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);">
    <div
        style="background: rgba(255,255,255,0.2); color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px;">
        <i class="fas fa-check"></i>
    </div>
    <div>
        <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: white; letter-spacing: 0.5px;">¡Envío Exitoso!
        </h4>
        <p style="margin: 2px 0 0 0; font-size: 13px; color: rgba(255,255,255,0.9);">El correo se ha enviado al cliente
            correctamente.</p>
    </div>
    <button onclick="hideToast()"
        style="background: none; border: none; color: rgba(255,255,255,0.6); cursor: pointer; margin-left: 10px; font-size: 18px;">
        <i class="fas fa-times"></i>
    </button>
</div>

<?php if (isset($_GET['msg']) && ($_GET['msg'] == 'email_sent' || $_GET['msg'] == 'created')): ?>
    <script>
        function showToast() {
            const toast = document.getElementById('toast');
            if (toast) {
                const title = toast.querySelector('h4');
                const p = toast.querySelector('p');
                if ("<?= $_GET['msg'] ?>" === 'created') {
                    if (title) title.textContent = '¡Facturación Exitosa!';
                    if (p) p.textContent = 'La factura se ha generado y registrado correctamente.';
                }
                toast.style.top = '30px';
            }
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            if (toast) toast.style.top = '-100px';
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(showToast, 500);
            setTimeout(hideToast, 5000);
        });
    </script>
<?php endif; ?>