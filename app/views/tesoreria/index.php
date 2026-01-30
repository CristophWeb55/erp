<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Cuentas por Cobrar</h2>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Factura</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Saldo Pendiente</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($facturas)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 40px;">No hay facturas
                        pendientes de cobro</td>
                </tr>
            <?php else: ?>
                <?php foreach ($facturas as $f): ?>
                    <tr>
                        <td>#FAC-
                            <?= str_pad($f['id'], 5, '0', STR_PAD_LEFT) ?>
                        </td>
                        <td style="font-weight: 600;">
                            <?= $f['nombre_razon_social'] ?>
                        </td>
                        <td style="font-weight: 700;">$
                            <?= number_format($f['total'], 2) ?>
                        </td>
                        <td style="color: #ef4444; font-weight: 800;">$
                            <?= number_format($f['saldo_pendiente'], 2) ?>
                        </td>
                        <td>
                            <span
                                style="padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: <?= ($f['estatus'] == 'Pagada' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)') ?>; color: <?= ($f['estatus'] == 'Pagada' ? '#10b981' : '#ef4444') ?>;">
                                <?= strtoupper($f['estatus']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($f['estatus'] != 'Pagada'): ?>
                                <button class="btn btn-primary" style="padding: 5px 12px; font-size: 12px;"
                                    onclick="openPaymentModal(<?= $f['id'] ?>, <?= $f['saldo_pendiente'] ?>, '<?= $f['nombre_razon_social'] ?>')">
                                    <i class="fas fa-hand-holding-usd"></i> Registrar Pago
                                </button>
                            <?php else: ?>
                                <span style="color: #10b981; font-size: 12px; font-weight: 600;">Saldada <i
                                        class="fas fa-check-circle"></i></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Pago -->
<div id="modalPago"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 500px; background: white;">
        <h3 style="margin-bottom: 20px;">Registrar Pago Recibido</h3>
        <form action="index.php?controller=Tesoreria&action=pay" method="POST">
            <input type="hidden" name="factura_id" id="pago_factura_id">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="background: #f1f5f9; padding: 15px; border-radius: 12px;">
                    <p style="font-size: 12px; color: var(--text-secondary);">Cliente</p>
                    <p style="font-weight: 700;" id="pago_cliente_nombre"></p>
                    <p style="font-size: 12px; color: var(--text-secondary); margin-top: 5px;">Saldo Pendiente</p>
                    <p style="font-weight: 800; color: #ef4444; font-size: 20px;" id="pago_saldo_display"></p>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 12px; margin-bottom: 5px;">Monto a Pagar</label>
                        <input type="number" step="0.01" name="monto" id="pago_monto_input" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 700; font-size: 16px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 12px; margin-bottom: 5px;">Fecha Pago</label>
                        <input type="date" name="fecha_pago" required value="<?= date('Y-m-d') ?>"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 12px; margin-bottom: 5px;">Forma de Pago</label>
                        <select name="forma_pago"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <option value="Transferencia">Transferencia</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-size: 12px; margin-bottom: 5px;">Referencia / Banco</label>
                        <input type="text" name="referencia"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn" style="background: #f1f5f9;"
                        onclick="closePaymentModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar Pago</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openPaymentModal(id, saldo, cliente) {
        document.getElementById('pago_factura_id').value = id;
        document.getElementById('pago_cliente_nombre').innerText = cliente;
        document.getElementById('pago_saldo_display').innerText = '$' + saldo.toLocaleString();
        document.getElementById('pago_monto_input').value = saldo;
        document.getElementById('modalPago').style.display = 'flex';
    }
    function closePaymentModal() {
        document.getElementById('modalPago').style.display = 'none';
    }
</script>