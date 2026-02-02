<div class="glass-panel" style="padding: 30px; border-radius: 24px;">

    <!-- Feedback Messages -->
    <?php if (isset($_GET['msg'])): ?>
        <div
            style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 15px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i>
            <span>
                <?= $_GET['msg'] == 'created' ? 'Orden de compra generada correctamente.' : '' ?>
                <?= $_GET['msg'] == 'received' ? 'Mercancía recibida e inventario actualizado.' : '' ?>
            </span>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div
            style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-circle"></i>
            <span>Error al procesar la solicitud. Intente nuevamente.</span>
        </div>
    <?php endif; ?>

    <!-- Encabezado con Botones -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="index.php?controller=Compras&action=index"
                style="color: var(--text-secondary); font-size: 20px;"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h2 style="font-weight: 800; font-size: 24px; color: var(--text-primary); margin: 0;">Orden #
                    <?= $compra['id'] ?>
                </h2>
                <div style="margin-top: 5px;">
                    <?php
                    $color = $compra['estatus'] == 'Recibida' ? '#10b981' : '#f59e0b';
                    $bg = $compra['estatus'] == 'Recibida' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)';
                    ?>
                    <span
                        style="background: <?= $bg ?>; color: <?= $color ?>; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                        <?= $compra['estatus'] ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if ($compra['estatus'] == 'Pendiente'): ?>
            <button onclick="confirmReception()"
                style="background: #10b981; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">
                <i class="fas fa-check-circle"></i> Recibir Mercancía
            </button>
        <?php endif; ?>
    </div>

    <!-- Info Proveedor -->
    <div
        style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; margin-bottom: 30px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
        <div>
            <label
                style="font-size: 10px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Proveedor</label>
            <p style="margin: 5px 0 0; font-weight: 700; color: var(--text-primary);">
                <?= $compra['proveedor'] ?>
            </p>
            <p style="margin: 2px 0 0; font-size: 12px; color: var(--text-secondary);">
                <?= $compra['rfc'] ?>
            </p>
        </div>
        <div>
            <label
                style="font-size: 10px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Fecha
                Compra</label>
            <p style="margin: 5px 0 0; font-weight: 600; color: var(--text-primary);">
                <?= date('d/m/Y', strtotime($compra['fecha_compra'])) ?>
            </p>
        </div>
        <div>
            <label
                style="font-size: 10px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Referencia</label>
            <p style="margin: 5px 0 0; font-weight: 600; color: var(--text-primary);">
                <?= $compra['referencia'] ?: 'N/A' ?>
            </p>
            <p
                style="margin: 5px 0 0; font-weight: 600; font-size: 12px; font-style: italic; color: var(--text-secondary);">
                <?= $compra['observaciones'] ?>
            </p>
        </div>
    </div>

    <!-- Detalle de Productos -->
    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 15px; color: var(--text-primary);">Productos
        Solicitados</h3>
    <div style="overflow: hidden; border-radius: 16px; border: 1px solid #e2e8f0;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; text-align: left;">
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        SKU</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        Descripción</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; text-align: center;">
                        Cant.</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; text-align: right;">
                        Costo U.</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; text-align: right;">
                        Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($compra['items']) && !empty($compra['items'])): ?>
                    <?php foreach ($compra['items'] as $item): ?>
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.03);">
                            <td style="padding: 15px; font-weight: 700; font-size: 13px;">
                                <?= $item['sku'] ?>
                            </td>
                            <td style="padding: 15px; font-size: 13px; color: var(--text-secondary);">
                                <?= $item['descripcion'] ?>
                            </td>
                            <td style="padding: 15px; text-align: center; font-weight: 700;">
                                <?= $item['cantidad'] ?>
                            </td>
                            <td style="padding: 15px; text-align: right;">$
                                <?= number_format($item['costo_unitario'], 2) ?>
                            </td>
                            <td style="padding: 15px; text-align: right; font-weight: 700;">$
                                <?= number_format($item['subtotal'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center;">No hay detalles disponibles</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr style="background: #f8fafc;">
                    <td colspan="4" style="padding: 15px; text-align: right; font-weight: 700;">TOTAL:</td>
                    <td style="padding: 15px; text-align: right; font-weight: 800; font-size: 16px;">$
                        <?= number_format($compra['total'], 2) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<!-- Modal Confirmación Recepción -->
<div id="modalReceive"
    style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; animation: fadeIn 0.3s ease-out;">
    <div
        style="background: white; width: 100%; max-width: 450px; border-radius: 20px; padding: 30px; text-align: center; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); transform: scale(0.95); animation: zoomIn 0.2s ease-out forwards;">
        <div
            style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px;">
            <i class="fas fa-box-open"></i>
        </div>

        <h3 style="margin: 0 0 10px; font-size: 20px; font-weight: 800; color: var(--text-primary);">Recibir Mercancía
        </h3>
        <p style="margin: 0 0 25px; color: var(--text-secondary); font-size: 14px; line-height: 1.5;">
            ¿Confirmas que has recibido física y correctamente toda la mercancía de esta orden? <br>
            <strong style="color: var(--accent-color);">Esto se agregará automáticamente al inventario.</strong>
        </p>

        <div style="display: flex; gap: 15px; justify-content: center;">
            <button onclick="document.getElementById('modalReceive').style.display='none'"
                style="flex: 1; background: white; border: 1px solid #e2e8f0; color: var(--text-secondary); padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                Cancelar
            </button>
            <a href="index.php?controller=Compras&action=receive&id=<?= $compra['id'] ?>"
                style="flex: 1; background: #10b981; border: none; color: white; padding: 12px; border-radius: 12px; font-weight: 700; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-check"></i> Confirmar
            </a>
        </div>
    </div>
</div>

<script>
    function confirmReception() {
        const modal = document.getElementById('modalReceive');
        modal.style.display = 'flex';
    }
</script>

<style>
    @keyframes zoomIn {
        to {
            transform: scale(1);
        }
    }
</style>