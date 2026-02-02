<div class="glass-panel" style="padding: 30px; border-radius: 24px; animation: fadeIn 0.4s ease-out;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2
                style="font-weight: 800; font-size: 28px; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-shopping-cart" style="color: var(--accent-color);"></i> Gestión de Compras
            </h2>
            <p style="color: var(--text-secondary); margin-top: 5px; font-size: 14px;">Administra tus proveedores y
                órdenes de abastecimiento</p>
        </div>
        <a href="index.php?controller=Compras&action=create" class="btn-primary"
            style="background: var(--accent-color); color: white; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(41, 56, 135, 0.2); transition: all 0.2s;">
            <i class="fas fa-plus"></i> Nueva Orden
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div
            style="padding: 15px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; font-weight: 600; 
            <?= $_GET['msg'] == 'created' ? 'background: rgba(16, 185, 129, 0.1); color: #10b981;' : 'background: rgba(59, 130, 246, 0.1); color: #3b82f6;' ?>">
            <?= $_GET['msg'] == 'created' ? '✓ Orden de compra creada exitosamente.' : '✓ Recepción de mercancía registrada.' ?>
        </div>
    <?php endif; ?>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="text-align: left; background: rgba(0,0,0,0.02);">
                    <th
                        style="padding: 15px; font-weight: 700; color: var(--text-secondary); font-size: 11px; text-transform: uppercase;">
                        ID</th>
                    <th
                        style="padding: 15px; font-weight: 700; color: var(--text-secondary); font-size: 11px; text-transform: uppercase;">
                        Proveedor</th>
                    <th
                        style="padding: 15px; font-weight: 700; color: var(--text-secondary); font-size: 11px; text-transform: uppercase;">
                        Fecha Compra</th>
                    <th
                        style="padding: 15px; font-weight: 700; color: var(--text-secondary); font-size: 11px; text-transform: uppercase;">
                        Total</th>
                    <th
                        style="padding: 15px; font-weight: 700; color: var(--text-secondary); font-size: 11px; text-transform: uppercase;">
                        Estatus</th>
                    <th
                        style="padding: 15px; font-weight: 700; color: var(--text-secondary); font-size: 11px; text-transform: uppercase; text-align: right;">
                        Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $c): ?>
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: background 0.2s;">
                        <td style="padding: 15px; font-weight: 700;">#<?= $c['id'] ?></td>
                        <td style="padding: 15px;"><?= $c['proveedor'] ?></td>
                        <td style="padding: 15px; color: var(--text-secondary);">
                            <?= date('d/m/Y', strtotime($c['fecha_compra'])) ?>
                        </td>
                        <td style="padding: 15px; font-weight: 700;">$<?= number_format($c['total'], 2) ?></td>
                        <td style="padding: 15px;">
                            <?php
                            $bg = $c['estatus'] == 'Recibida' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)';
                            $color = $c['estatus'] == 'Recibida' ? '#10b981' : '#f59e0b';
                            ?>
                            <span
                                style="background: <?= $bg ?>; color: <?= $color ?>; padding: 5px 10px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase;">
                                <?= $c['estatus'] ?>
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: right;">
                            <a href="index.php?controller=Compras&action=detalle&id=<?= $c['id'] ?>"
                                style="color: var(--accent-color); background: rgba(41, 56, 135, 0.05); width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (empty($compras)): ?>
            <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                <i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                <p>No hay órdenes de compra registradas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>