<div class="glass-panel" style="padding: 30px; border-radius: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2 style="margin: 0; font-weight: 800; font-size: 24px; color: var(--text-primary);">Facturas Emitidas
            </h2>
            <p style="margin: 5px 0 0; color: var(--text-secondary); font-size: 14px;">Administra y descarga tus CFDI
                timbrados.</p>
        </div>
        <div
            style="background: rgba(99, 102, 241, 0.1); color: #6366f1; padding: 10px 20px; border-radius: 12px; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-bolt"></i> Timbrado 4.0 Activo
        </div>
    </div>

    <div style="overflow-x: auto; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: rgba(255,255,255,0.5); text-align: left;">
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        UUID / Folio</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        Cliente</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        Fecha Emisión</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        Monto Total</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">
                        Estatus</th>
                    <th
                        style="padding: 15px; font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; text-align: center;">
                        Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($facturas)): ?>
                    <?php foreach ($facturas as $f): ?>
                        <tr style="background: white; transition: background 0.2s; border-bottom: 1px solid #f1f5f9;">
                            <td
                                style="padding: 15px; font-family: monospace; font-size: 12px; font-weight: 600; color: var(--text-primary);">
                                <span style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-file-invoice-dollar" style="color: #6366f1;"></i>
                                    <?= substr($f['folio_fiscal_uuid'], 0, 8) ?>...
                                </span>
                            </td>
                            <td style="padding: 15px;">
                                <div style="font-weight: 600; font-size: 13px; color: var(--text-primary);"><?= $f['cliente'] ?>
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary);"><?= $f['rfc'] ?></div>
                            </td>
                            <td style="padding: 15px; font-size: 13px; color: var(--text-secondary);">
                                <?= date('d/m/Y H:i', strtotime($f['fecha_emision'])) ?>
                            </td>
                            <td style="padding: 15px; font-weight: 700; font-size: 14px;">
                                $<?= number_format($f['total'], 2) ?>
                            </td>
                            <td style="padding: 15px;">
                                <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;
                                <?php
                                if ($f['estatus'] == 'Pagada')
                                    echo 'background: rgba(16, 185, 129, 0.1); color: #10b981;';
                                elseif ($f['estatus'] == 'Cancelada')
                                    echo 'background: rgba(239, 68, 68, 0.1); color: #ef4444;';
                                else
                                    echo 'background: rgba(245, 158, 11, 0.1); color: #f59e0b;';
                                ?>">
                                    <?= $f['estatus'] ?>
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="index.php?controller=Facturacion&action=ver&id=<?= $f['id'] ?>"
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #f8fafc; border-radius: 8px; color: var(--text-secondary); transition: all 0.2s;"
                                    onmouseover="this.style.background='#eef2ff'; this.style.color='#6366f1'"
                                    onmouseout="this.style.background='#f8fafc'; this.style.color='var(--text-secondary)'">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-secondary);">
                            <div
                                style="width: 60px; height: 60px; background: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <i class="fas fa-receipt" style="font-size: 24px; opacity: 0.3;"></i>
                            </div>
                            <p style="margin: 0; font-weight: 500;">No has emitido facturas todavía.</p>
                            <p style="font-size: 12px; margin: 5px 0 15px 0; color: var(--text-secondary);">Las facturas se
                                generan a partir de los pedidos para evitar errores.</p>
                            <a href="index.php?controller=Pedidos&action=index" class="btn"
                                style="background: #6366f1; color: white; padding: 8px 20px; border-radius: 12px; text-decoration: none; font-size: 13px; font-weight: 700;">Ir
                                a Pedidos</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>