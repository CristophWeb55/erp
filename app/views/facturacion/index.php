<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Facturas Generadas (CFDI)</h2>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha Emisión</th>
                <th>Cliente</th>
                <th>UUID (Folio Fiscal)</th>
                <th>Total</th>
                <th>Saldo</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($facturas)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: var(--text-secondary); padding: 40px;">No hay facturas
                        generadas</td>
                </tr>
            <?php else: ?>
                <?php foreach ($facturas as $f): ?>
                    <tr>
                        <td>#FAC-
                            <?= str_pad($f['id'], 5, '0', STR_PAD_LEFT) ?>
                        </td>
                        <td>
                            <?= $f['fecha_emision'] ?>
                        </td>
                        <td style="font-weight: 600;">
                            <?= $f['nombre_razon_social'] ?>
                        </td>
                        <td style="font-family: monospace; font-size: 11px;">
                            <?= $f['folio_fiscal_uuid'] ?>
                        </td>
                        <td style="font-weight: 700;">$
                            <?= number_format($f['total'], 2) ?>
                        </td>
                        <td style="color: #ef4444; font-weight: 600;">$
                            <?= number_format($f['saldo_pendiente'], 2) ?>
                        </td>
                        <td>
                            <span
                                style="padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: <?= ($f['estatus'] == 'Pagada' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)') ?>; color: <?= ($f['estatus'] == 'Pagada' ? '#10b981' : '#f59e0b') ?>;">
                                <?= strtoupper($f['estatus']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?controller=Facturacion&action=show&id=<?= $f['id'] ?>" class="btn"
                                style="background: rgba(99, 102, 241, 0.1); color: #6366f1; padding: 5px 12px; font-size: 12px; text-decoration: none; border-radius: 8px;">
                                <i class="fas fa-eye"></i> Ver PDF
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>