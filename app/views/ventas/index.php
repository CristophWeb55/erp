<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Cotizaciones / Órdenes de Venta</h2>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="fas fa-file-signature"></i> Nueva Cotización
    </button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($cotizaciones)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 40px;">No hay
                        cotizaciones registradas</td>
                </tr>
            <?php else: ?>
                <?php foreach ($cotizaciones as $c): ?>
                    <tr>
                        <td>#
                            <?= $c['id'] ?>
                        </td>
                        <td>
                            <?= $c['fecha_emision'] ?>
                        </td>
                        <td style="font-weight: 600;">
                            <?= $c['nombre_razon_social'] ?>
                        </td>
                        <td style="font-weight: 700;">$
                            <?= number_format($c['total'], 2) ?>
                        </td>
                        <td>
                            <span
                                style="padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: <?= ($c['estatus'] == 'Aprobada' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(99, 102, 241, 0.1)') ?>; color: <?= ($c['estatus'] == 'Aprobada' ? '#10b981' : '#6366f1') ?>;">
                                <?= strtoupper($c['estatus']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($c['estatus'] == 'Borrador'): ?>
                                <a href="index.php?controller=Ventas&action=approve&id=<?= $c['id'] ?>" class="btn"
                                    style="background: #6366f1; color: white; padding: 5px 12px; font-size: 12px; text-decoration: none; border-radius: 8px;">
                                    <i class="fas fa-check"></i> Convertir a Pedido
                                </a>
                            <?php elseif ($c['estatus'] == 'Aprobada'): ?>
                                <a href="index.php?controller=Facturacion&action=generate&cotizacion_id=<?= $c['id'] ?>" class="btn"
                                    style="background: #10b981; color: white; padding: 5px 12px; font-size: 12px; text-decoration: none; border-radius: 8px;">
                                    <i class="fas fa-file-invoice"></i> Facturar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="modalVenta"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 600px; background: white;">
        <h3 style="margin-bottom: 20px;">Nueva Cotización</h3>
        <form action="index.php?controller=Ventas&action=create" method="POST">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Cliente</label>
                        <select name="cliente_id" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <?php foreach ($clientes as $cl): ?>
                                <?php if ($cl['tipo'] != 'Proveedor'): ?>
                                    <option value="<?= $cl['id'] ?>">
                                        <?= $cl['nombre_razon_social'] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Fecha</label>
                        <input type="date" name="fecha_emision" required value="<?= date('Y-m-d') ?>"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                </div>

                <div style="background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <p style="font-weight: 600; font-size: 13px; margin-bottom: 10px;">Producto a Cotizar (MVP: 1 Item)
                    </p>
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 10px;">
                        <div>
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
                        <div>
                            <label style="font-size: 11px;">Cantidad</label>
                            <input type="number" name="cantidad" value="1" required
                                style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;">
                        </div>
                        <div>
                            <label style="font-size: 11px;">P. Unitario</label>
                            <input type="number" step="0.01" name="precio_unitario" required
                                style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn" style="background: #f1f5f9;"
                        onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Crear Cotización</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalVenta').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('modalVenta').style.display = 'none';
    }
</script>