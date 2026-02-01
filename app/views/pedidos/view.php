<div style="display: flex; flex-direction: column; gap: 25px;">
    <!-- 🔔 NOTIFICACIONES -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'surtido_ok'): ?>
        <div
            style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 15px 25px; border-radius: 16px; display: flex; align-items: center; gap: 15px; animation: slideDown 0.5s ease-out;">
            <i class="fas fa-check-circle" style="font-size: 20px;"></i>
            <span style="font-weight: 700;">¡Pedido surtido con éxito!</span>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div
            style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 15px 25px; border-radius: 16px; display: flex; align-items: center; gap: 15px; animation: slideDown 0.5s ease-out;">
            <i class="fas fa-exclamation-triangle" style="font-size: 20px;"></i>
            <span style="font-weight: 700;">Error: <?= htmlspecialchars($_GET['error']) ?></span>
        </div>
    <?php endif; ?>

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- 🔝 CABECERA Y ACCIONES -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                <a href="index.php?controller=Pedidos&action=index"
                    style="text-decoration: none; color: var(--text-secondary); font-size: 18px; transition: color 0.2s;"
                    onmouseover="this.style.color='var(--accent-color)'"
                    onmouseout="this.style.color='var(--text-secondary)'">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2
                    style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 24px; letter-spacing: -0.5px;">
                    Pedido
                    <?= $pedido['folio'] ?>
                </h2>
            </div>
            <p style="margin: 0; color: var(--text-secondary); font-size: 13px;">Detalles completos de la orden y
                productos asignados.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button onclick="openPDFViewer(<?= $pedido['id'] ?>)" class="btn"
                style="background: white; border: 1px solid #e2e8f0; color: var(--text-primary); cursor: pointer; display: flex; align-items: center; gap: 8px; border-radius: 12px; padding: 10px 20px;">
                <i class="fas fa-print" style="color: var(--text-secondary);"></i> Imprimir
            </button>
            <?php if (in_array($pedido['estatus'], ['Pendiente', 'En Proceso'])): ?>
                <button onclick="confirmFulfillment(<?= $pedido['id'] ?>, '<?= $pedido['folio'] ?>')"
                    class="btn btn-primary"
                    style="background: #10b981; border: none; border-radius: 12px; padding: 10px 25px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-box-open"></i> Surtir Pedido
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- 🎴 GRID DE INFORMACIÓN GENERAL -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px;">
        <!-- Columna Izquierda: Detalles del Cliente e Items -->
        <div style="display: flex; flex-direction: column; gap: 25px;">
            <!-- Card de Cliente -->
            <div
                style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 24px; padding: 30px; box-shadow: var(--glass-shadow);">
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-primary);">Información
                        del Cliente</h3>
                    <div
                        style="padding: 6px 15px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                        ID: #
                        <?= $pedido['cliente_id'] ?>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div>
                        <p
                            style="margin: 0 0 5px 0; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">
                            Razón Social</p>
                        <p style="margin: 0; font-weight: 700; color: var(--text-primary); font-size: 15px;">
                            <?= $pedido['cliente_nombre'] ?>
                        </p>
                    </div>
                    <div>
                        <p
                            style="margin: 0 0 5px 0; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">
                            RFC</p>
                        <p style="margin: 0; font-weight: 700; color: var(--text-primary); font-size: 15px;">
                            <?= $pedido['cliente_rfc'] ?? 'XAXX010101000' ?>
                        </p>
                    </div>
                    <div style="grid-column: span 2;">
                        <p
                            style="margin: 0 0 5px 0; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">
                            Dirección Fiscal</p>
                        <p
                            style="margin: 0; font-weight: 500; color: var(--text-primary); font-size: 14px; line-height: 1.5;">
                            <?= $pedido['cliente_direccion'] ?? 'Dirección no especificada' ?>
                        </p>
                    </div>
                    <div>
                        <p
                            style="margin: 0 0 5px 0; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">
                            Email</p>
                        <p style="margin: 0; font-weight: 500; color: var(--text-primary); font-size: 14px;">
                            <?= $pedido['cliente_email'] ?? 'No disponible' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabla de Items -->
            <div
                style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: var(--glass-shadow); overflow: hidden;">
                <div style="padding: 25px; border-bottom: 1px solid var(--glass-border);">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-primary);">Detalle de
                        Productos</h3>
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: rgba(248, 250, 252, 0.5);">
                        <tr>
                            <th
                                style="padding: 15px 25px; text-align: left; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); font-weight: 800;">
                                Producto</th>
                            <th
                                style="padding: 15px 25px; text-align: center; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); font-weight: 800;">
                                Cant.</th>
                            <th
                                style="padding: 15px 25px; text-align: right; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); font-weight: 800;">
                                Precio</th>
                            <th
                                style="padding: 15px 25px; text-align: right; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); font-weight: 800;">
                                Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedido['items'] as $item): ?>
                            <tr style="border-bottom: 1px solid rgba(226, 232, 240, 0.5);">
                                <td style="padding: 20px 25px;">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <?php if ($item['imagen_url']): ?>
                                            <img src="<?= $item['imagen_url'] ?>"
                                                style="width: 45px; height: 45px; border-radius: 10px; object-fit: cover; border: 1px solid #e2e8f0;">
                                        <?php else: ?>
                                            <div
                                                style="width: 45px; height: 45px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 20px;">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <p
                                                style="margin: 0; font-weight: 700; color: var(--text-primary); font-size: 14px;">
                                                <?= $item['sku'] ?>
                                            </p>
                                            <p
                                                style="margin: 2px 0 0 0; font-size: 12px; color: var(--text-secondary); line-height: 1.3;">
                                                <?= $item['descripcion'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    style="padding: 20px 25px; text-align: center; font-weight: 700; color: var(--text-primary);">
                                    <?= $item['cantidad'] ?>
                                </td>
                                <td
                                    style="padding: 20px 25px; text-align: right; font-weight: 600; color: var(--text-primary);">
                                    $
                                    <?= number_format($item['precio_unitario'], 2) ?>
                                </td>
                                <td
                                    style="padding: 20px 25px; text-align: right; font-weight: 800; color: var(--accent-color);">
                                    $
                                    <?= number_format($item['subtotal'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Columna Derecha: Resumen de Importes -->
        <div style="display: flex; flex-direction: column; gap: 25px;">
            <!-- Card de Estatus -->
            <div
                style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 24px; padding: 25px; box-shadow: var(--glass-shadow);">
                <p
                    style="margin: 0 0 15px 0; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.5px;">
                    Estado del Pedido</p>
                <?php
                $statusColors = [
                    'Pendiente' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'color' => '#f59e0b', 'icon' => 'fa-clock'],
                    'En Proceso' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'color' => '#3b82f6', 'icon' => 'fa-cog fa-spin'],
                    'Surtido' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'color' => '#10b981', 'icon' => 'fa-check'],
                    'Facturado' => ['bg' => 'rgba(99, 102, 241, 0.1)', 'color' => '#6366f1', 'icon' => 'fa-file-invoice'],
                    'Cancelado' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'color' => '#ef4444', 'icon' => 'fa-times']
                ];
                $st = $statusColors[$pedido['estatus']] ?? $statusColors['Pendiente'];
                ?>
                <div
                    style="padding: 15px; border-radius: 18px; background: <?= $st['bg'] ?>; border: 1px solid <?= $st['color'] ?>30; display: flex; align-items: center; gap: 12px;">
                    <i class="fas <?= $st['icon'] ?>" style="font-size: 24px; color: <?= $st['color'] ?>;"></i>
                    <span style="font-weight: 800; color: <?= $st['color'] ?>; font-size: 18px;">
                        <?= strtoupper($pedido['estatus']) ?>
                    </span>
                </div>
            </div>

            <!-- Card de Totales -->
            <div
                style="background: var(--accent-color); border-radius: 24px; padding: 30px; color: white; box-shadow: 0 15px 35px var(--accent-glow);">
                <div style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 13px; opacity: 0.8; font-weight: 500;">Subtotal</span>
                        <span style="font-weight: 700; font-size: 16px;">$
                            <?= number_format($pedido['subtotal'], 2) ?>
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; opacity: 0.8; font-weight: 500;">IVA (16.00%)</span>
                        <span style="font-weight: 700; font-size: 16px;">$
                            <?= number_format($pedido['iva'], 2) ?>
                        </span>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <p
                            style="margin: 0; font-size: 12px; opacity: 0.8; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                            Importe Total</p>
                        <h2 style="margin: 5px 0 0 0; font-size: 32px; font-weight: 800;">$
                            <?= number_format($pedido['total'], 2) ?>
                        </h2>
                    </div>
                    <span
                        style="font-weight: 800; font-size: 13px; padding: 5px 10px; background: rgba(255,255,255,0.1); border-radius: 8px;">MXN</span>
                </div>
            </div>

            <!-- Card Meta Extra -->
            <div
                style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 24px; padding: 25px; box-shadow: var(--glass-shadow);">
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-user-tag" style="color: var(--text-secondary);"></i>
                        <div>
                            <p
                                style="margin: 0; font-size: 11px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase;">
                                Vendedor</p>
                            <p style="margin: 0; font-size: 14px; color: var(--text-primary); font-weight: 600;">
                                <?= $pedido['vendedor_nombre'] ?? 'Sin asignar' ?>
                            </p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="far fa-calendar-check" style="color: var(--text-secondary);"></i>
                        <div>
                            <p
                                style="margin: 0; font-size: 11px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase;">
                                Fecha Emisión</p>
                            <p style="margin: 0; font-size: 14px; color: var(--text-primary); font-weight: 600;">
                                <?= date('d/m/Y', strtotime($pedido['fecha_pedido'])) ?>
                            </p>
                        </div>
                    </div>
                    <?php if ($pedido['cotizacion_id']): ?>
                        <a href="index.php?controller=Ventas&action=view&id=<?= $pedido['cotizacion_id'] ?>"
                            style="text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; border-left: 4px solid var(--accent-color); transition: background 0.2s;"
                            onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                            <i class="fas fa-link" style="color: var(--accent-color);"></i>
                            <div>
                                <p style="margin: 0; font-size: 11px; color: var(--text-secondary); font-weight: 700;">
                                    Origen: Cotización</p>
                                <p style="margin: 0; font-size: 12px; color: var(--accent-color); font-weight: 700;">Ver
                                    Documento Previo</p>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>

<!-- Modal Visor PDF (Premium Style) -->
<div id="modalPDF" class="edit-overlay" style="display: none; align-items: center; justify-content: center;">
    <div class="edit-panel"
        style="max-width: 90%; width: 1000px; height: 90vh; padding: 0; border-radius: 32px; overflow: hidden; display: flex; flex-direction: column;">
        <div
            style="padding: 20px 30px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div
                    style="width: 40px; height: 40px; background: rgba(227, 81, 86, 0.1); color: #E35156; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 16px; font-weight: 800; color: var(--text-primary);">Vista Previa
                        de Pedido</h3>
                    <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">Generado por URICA ERP</p>
                </div>
            </div>
            <div style="display: flex; gap: 10px;">
                <button onclick="document.getElementById('pdfFrame').contentWindow.print()" class="btn"
                    style="background: var(--primary); color: white; border-radius: 12px; padding: 8px 15px; font-size: 13px; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <button onclick="closePDFViewer()" class="btn"
                    style="background: #f1f5f9; color: var(--text-secondary); border-radius: 12px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div style="flex: 1; background: #525659;">
            <iframe id="pdfFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
    </div>
</div>

<script>
    // Mover modales al final del body
    document.addEventListener('DOMContentLoaded', function () {
        const modalFulfill = document.getElementById('modalFulfill');
        const modalPDF = document.getElementById('modalPDF');
        document.body.appendChild(modalFulfill);
        document.body.appendChild(modalPDF);
    });

    function confirmFulfillment(id, folio) {
        document.getElementById('btnConfirmFulfill').href = `index.php?controller=Pedidos&action=fulfill&id=${id}`;
        const modal = document.getElementById('modalFulfill');
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
        document.body.classList.add('no-scroll');
    }

    function closeFulfillModal() {
        const modal = document.getElementById('modalFulfill');
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.classList.remove('no-scroll');
        }, 300);
    }

    function openPDFViewer(id) {
        const modal = document.getElementById('modalPDF');
        const frame = document.getElementById('pdfFrame');
        frame.src = `index.php?controller=Pedidos&action=pdf&id=${id}`;
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
        document.body.classList.add('no-scroll');
    }

    function closePDFViewer() {
        const modal = document.getElementById('modalPDF');
        modal.classList.remove('active');
        setTimeout(() => {
            modal.style.display = 'none';
            document.getElementById('pdfFrame').src = '';
            document.body.classList.remove('no-scroll');
        }, 300);
    }

    // Cerrar si se hace click fuera del modal (overlay)
    document.addEventListener('click', function (event) {
        if (event.target.id === 'modalFulfill') closeFulfillModal();
        if (event.target.id === 'modalPDF') closePDFViewer();
    });
</script>