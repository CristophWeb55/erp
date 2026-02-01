<!-- 🔝 CABECERA Y ACCIONES -->
<div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2
                style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 24px; letter-spacing: -0.5px;">
                Pedidos de Venta</h2>
            <p style="margin: 5px 0 0 0; color: var(--text-secondary); font-size: 13px;">Gestiona el flujo de ventas,
                surtido y facturación.</p>
        </div>
        <!-- Botón de Acción Principal (Opcional, la entrada principal es desde Cotizaciones) -->
        <a href="index.php?controller=Ventas&action=index" class="btn btn-primary"
            style="background: white; color: var(--text-primary); border: 1px solid #e2e8f0; padding: 12px 24px; border-radius: 12px; font-weight: 800; display: flex; align-items: center; gap: 8px; box-shadow: var(--glass-shadow); text-decoration: none;">
            <i class="fas fa-file-invoice-dollar" style="color: var(--accent-color);"></i> Ver Cotizaciones
        </a>
    </div>

    <!-- Stats Rapidos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div
            style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 20px; border-radius: 20px; box-shadow: var(--glass-shadow);">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div
                    style="width: 45px; height: 45px; border-radius: 12px; background: rgba(59, 130, 246, 0.1); color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-box-open"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);">
                        <?= count(array_filter($pedidos, function ($p) {
                            return $p['estatus'] == 'Pendiente'; })) ?>
                    </h3>
                    <p style="margin: 0; font-size: 12px; color: var(--text-secondary); font-weight: 600;">Por Surtir
                    </p>
                </div>
            </div>
        </div>

        <div
            style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 20px; border-radius: 20px; box-shadow: var(--glass-shadow);">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div
                    style="width: 45px; height: 45px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);">
                        <?= count(array_filter($pedidos, function ($p) {
                            return $p['estatus'] == 'Surtido'; })) ?>
                    </h3>
                    <p style="margin: 0; font-size: 12px; color: var(--text-secondary); font-weight: 600;">Completados
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 📋 TABLA DE PEDIDOS -->
<div class="card"
    style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: var(--glass-shadow); overflow: hidden; padding: 0;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: rgba(248, 250, 252, 0.5);">
            <tr>
                <th
                    style="text-align: left; padding: 20px 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); font-weight: 800;">
                    Pedido</th>
                <th
                    style="text-align: left; padding: 20px 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); font-weight: 800;">
                    Cliente</th>
                <th
                    style="text-align: left; padding: 20px 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); font-weight: 800;">
                    Fecha / Entrega</th>
                <th
                    style="text-align: right; padding: 20px 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); font-weight: 800;">
                    Importe</th>
                <th
                    style="text-align: center; padding: 20px 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); font-weight: 800;">
                    Estatus</th>
                <th
                    style="text-align: center; padding: 20px 25px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-secondary); font-weight: 800;">
                    Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pedidos)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px;">
                        <div
                            style="width: 80px; height: 80px; background: rgba(59, 130, 246, 0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-clipboard-list"
                                style="font-size: 30px; color: var(--accent-color); opacity: 0.5;"></i>
                        </div>
                        <h3 style="margin: 0; color: var(--text-primary); font-size: 18px; font-weight: 700;">No hay pedidos
                            activos</h3>
                        <p style="margin: 5px 0 0; color: var(--text-secondary); font-size: 14px;">Convierte cotizaciones
                            para
                            generar pedidos.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($pedidos as $p): ?>
                    <tr style="border-bottom: 1px solid rgba(226, 232, 240, 0.6); transition: all 0.2s;"
                        onmouseover="this.style.background='rgba(241, 245, 249, 0.4)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px 25px;">
                            <div style="font-weight: 800; color: var(--text-primary); font-size: 14px;">
                                <?= $p['folio'] ?>
                            </div>
                            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 3px;">
                                <?= $p['total_items'] ?> Items • Vendedor:
                                <?= $p['vendedor_nombre'] ?? 'N/A' ?>
                            </div>
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 35px; height: 35px; border-radius: 10px; background: linear-gradient(135deg, var(--accent-color), #4f46e5); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px;">
                                    <?= strtoupper(substr($p['cliente_nombre'], 0, 1)) ?>
                                </div>
                                <div style="font-weight: 700; color: var(--text-primary); font-size: 14px;">
                                    <?= $p['cliente_nombre'] ?>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 20px 25px;">
                            <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">
                                <i class="far fa-calendar-alt" style="color: var(--text-secondary); margin-right: 5px;"></i>
                                <?= date('d M, Y', strtotime($p['fecha_pedido'])) ?>
                            </div>
                            <?php if ($p['fecha_entrega_estimada']): ?>
                                <div style="font-size: 11px; color: #f59e0b; margin-top: 4px; font-weight: 600;">
                                    <i class="fas fa-truck" style="margin-right: 4px;"></i> Entrega:
                                    <?= date('d M', strtotime($p['fecha_entrega_estimada'])) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 20px 25px; text-align: right;">
                            <div style="font-weight: 800; color: var(--text-primary); font-size: 15px;">
                                $
                                <?= number_format($p['total'], 2) ?>
                            </div>
                            <div style="font-size: 11px; color: var(--text-secondary); font-weight: 600;">
                                <?= $p['moneda'] ?>
                            </div>
                        </td>
                        <td style="padding: 20px 25px; text-align: center;">
                            <?php
                            $statusColors = [
                                'Pendiente' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'color' => '#f59e0b', 'icon' => 'fa-clock'],
                                'En Proceso' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'color' => '#3b82f6', 'icon' => 'fa-cog fa-spin'],
                                'Surtido' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'color' => '#10b981', 'icon' => 'fa-check'],
                                'Facturado' => ['bg' => 'rgba(99, 102, 241, 0.1)', 'color' => '#6366f1', 'icon' => 'fa-file-invoice'],
                                'Cancelado' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'color' => '#ef4444', 'icon' => 'fa-times']
                            ];
                            $st = $statusColors[$p['estatus']] ?? $statusColors['Pendiente'];
                            ?>
                            <span
                                style="padding: 6px 12px; border-radius: 12px; font-size: 11px; font-weight: 800; background: <?= $st['bg'] ?>; color: <?= $st['color'] ?>; border: 1px solid <?= $st['color'] ?>20; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas <?= $st['icon'] ?>"></i>
                                <?= strtoupper($p['estatus']) ?>
                            </span>
                        </td>
                        <td style="padding: 20px 25px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <?php if ($p['estatus'] == 'Pendiente'): ?>
                                    <button title="Surtir Pedido (Descontar Inventario)" class="action-btn"
                                        onclick="confirmFulfillment(<?= $p['id'] ?>, '<?= $p['folio'] ?>')"
                                        style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                                        <i class="fas fa-box"></i>
                                    </button>
                                <?php endif; ?>

                                <button title="Ver Detalle" class="action-btn" onclick="alert('Detalle en construcción')"
                                    style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Confirmación Surtido -->
<div id="modalFulfill"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 2000; justify-content: center; align-items: center;">
    <div
        style="background: white; width: 100%; max-width: 400px; padding: 30px; border-radius: 24px; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
        <div
            style="width: 70px; height: 70px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px;">
            <i class="fas fa-box-open"></i>
        </div>
        <h3 style="margin: 0 0 10px 0; color: var(--text-primary); font-weight: 800;">¿Surtir Pedido?</h3>
        <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 25px;">
            Se descontarán los productos del inventario usando FIFO (Primeras entradas, primeras salidas). Esta acción
            no se puede deshacer.
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button onclick="document.getElementById('modalFulfill').style.display = 'none'" class="btn"
                style="background: #f1f5f9; color: var(--text-secondary); font-weight: 700;">Cancelar</button>
            <a id="btnConfirmFulfill" href="#" class="btn btn-primary"
                style="background: #10b981; text-decoration: none; display: flex; align-items: center; justify-content: center;">Sí,
                Surtir</a>
        </div>
    </div>
</div>

<script>
    function confirmFulfillment(id, folio) {
        document.getElementById('btnConfirmFulfill').href = `index.php?controller=Pedidos&action=fulfill&id=${id}`;
        document.getElementById('modalFulfill').style.display = 'flex';
    }
</script>