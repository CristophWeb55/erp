<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Órdenes de Compra</h2>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="fas fa-cart-plus"></i> Nueva Orden
    </button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Referencia</th>
                <th>Total</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($compras)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 40px;">No hay compras
                        registradas</td>
                </tr>
            <?php else: ?>
                <?php foreach ($compras as $c): ?>
                    <tr>
                        <td>#
                            <?= $c['id'] ?>
                        </td>
                        <td>
                            <?= $c['fecha_compra'] ?>
                        </td>
                        <td style="font-weight: 600;">
                            <?= $c['nombre_razon_social'] ?>
                        </td>
                        <td>
                            <?= $c['referencia'] ?>
                        </td>
                        <td style="font-weight: 700;">$
                            <?= number_format($c['total'], 2) ?>
                        </td>
                        <td>
                            <span
                                style="padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: <?= ($c['estatus'] == 'Recibida' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(99, 102, 241, 0.1)') ?>; color: <?= ($c['estatus'] == 'Recibida' ? '#10b981' : '#6366f1') ?>;">
                                <?= strtoupper($c['estatus']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($c['estatus'] == 'Pendiente'): ?>
                                <a href="index.php?controller=Compras&action=receiving&id=<?= $c['id'] ?>" class="btn"
                                    style="background: #10b981; color: white; padding: 5px 12px; font-size: 12px; text-decoration: none; border-radius: 8px;">
                                    <i class="fas fa-download"></i> Recibir
                                </a>
                            <?php else: ?>
                                <button class="btn" disabled
                                    style="background: transparent; color: var(--text-secondary); padding: 5px;"><i
                                        class="fas fa-check-double"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="modalCompra"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 600px; background: white;">
        <h3 style="margin-bottom: 20px;">Nueva Orden de Compra</h3>
        <form action="index.php?controller=Compras&action=create" method="POST">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Proveedor</label>
                        <select name="proveedor_id" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <?php foreach ($proveedores as $prov): ?>
                                <?php if ($prov['tipo'] != 'Cliente'): ?>
                                    <option value="<?= $prov['id'] ?>">
                                        <?= $prov['nombre_razon_social'] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Fecha</label>
                        <input type="date" name="fecha_compra" required value="<?= date('Y-m-d') ?>"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                </div>

                <div style="background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <p style="font-weight: 600; font-size: 13px; margin-bottom: 10px;">Producto a Comprar (MVP: 1 Item)
                    </p>
                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 2;">
                            <label style="font-size: 11px;">Producto</label>
                            <select name="producto_id" required
                                style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                <?php foreach ($productos as $prod): ?>
                                    <option value="<?= $prod['id'] ?>">
                                        <?= $prod['sku'] ?> -
                                        <?= $prod['descripcion'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label style="font-size: 11px;">Cantidad</label>
                            <input type="number" name="cantidad" value="1" required
                                style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Referencia
                            / Factura Prov.</label>
                        <input type="text" name="referencia"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Total
                            Compra</label>
                        <input type="number" step="0.01" name="total" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn" style="background: #f1f5f9;"
                        onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Generar Orden</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalCompra').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('modalCompra').style.display = 'none';
    }
</script>