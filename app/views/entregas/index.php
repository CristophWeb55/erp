<div class="glass-panel" style="padding: 30px; border-radius: 24px; animation: fadeIn 0.4s ease-out;">

    <!-- Header del Módulo -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
        <div>
            <h2
                style="font-weight: 800; font-size: 28px; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-truck" style="color: var(--accent-color);"></i>
                Logística y Entregas
            </h2>
            <p style="color: var(--text-secondary); margin-top: 5px; font-size: 14px;">Gestiona el despacho y
                confirmación de mercancía</p>
        </div>

        <div style="display: flex; gap: 12px;">
            <div
                style="background: rgba(41, 56, 135, 0.05); padding: 10px 20px; border-radius: 12px; display: flex; align-items: center; gap: 10px;">
                <div style="text-align: right;">
                    <p
                        style="margin: 0; font-size: 10px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase;">
                        Pendientes</p>
                    <p style="margin: 0; font-size: 18px; font-weight: 800; color: var(--accent-color);">
                        <?= count($pendientes) ?>
                    </p>
                </div>
                <div style="width: 1px; height: 30px; background: rgba(0,0,0,0.1);"></div>
                <div style="text-align: right;">
                    <p
                        style="margin: 0; font-size: 10px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase;">
                        En Ruta</p>
                    <p style="margin: 0; font-size: 18px; font-weight: 800; color: #f59e0b;">
                        <?= count(array_filter($entregas, fn($e) => $e['estatus'] == 'En Tránsito')) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔔 NOTIFICACIONES -->
    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'created'): ?>
            <div
                style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 15px 25px; border-radius: 16px; display: flex; align-items: center; gap: 15px; margin-bottom: 25px; animation: slideDown 0.5s ease-out;">
                <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                <span style="font-weight: 700;">¡Orden de entrega generada con éxito!</span>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- 🚚 SECCIÓN: PEDIDOS POR PROGRAMAR -->
    <?php if (!empty($pendientes)): ?>
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-primary);">Pedidos Listos para
                    Entrega</h3>
                <span
                    style="background: var(--accent-color); color: white; padding: 2px 8px; border-radius: 6px; font-size: 12px; font-weight: 700;"><?= count($pendientes) ?></span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <?php foreach ($pendientes as $p): ?>
                    <div class="pending-card"
                        style="background: white; border: 1px solid rgba(41, 56, 135, 0.1); border-radius: 20px; padding: 20px; display: flex; flex-direction: column; gap: 15px; transition: all 0.3s ease;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <span
                                    style="font-size: 11px; font-weight: 700; color: var(--accent-color); text-transform: uppercase;"><?= $p['folio'] ?></span>
                                <h4 style="margin: 5px 0 0 0; font-size: 15px; font-weight: 800; color: var(--text-primary);">
                                    <?= $p['cliente'] ?>
                                </h4>
                            </div>
                            <div
                                style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 8px; border-radius: 8px; font-size: 10px; font-weight: 800;">
                                SURTIDO</div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                            <div style="font-size: 12px; color: var(--text-secondary);">
                                <i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($p['fecha_pedido'])) ?>
                            </div>
                            <a href="index.php?controller=Logistica&action=generate&pedido_id=<?= $p['id'] ?>"
                                class="btn-generate"
                                style="background: var(--accent-color); color: white; border: none; padding: 8px 15px; border-radius: 10px; font-size: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-plus"></i> Programar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr style="border: none; border-top: 1px solid rgba(0,0,0,0.05); margin-bottom: 40px;">
    <?php endif; ?>

    <!-- Tabla de Entregas ya Programadas -->
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
        <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text-primary);">Historial de Entregas</h3>
        <span
            style="background: #64748b; color: white; padding: 2px 8px; border-radius: 6px; font-size: 12px; font-weight: 700;"><?= count($entregas) ?></span>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="text-align: left; background: rgba(0,0,0,0.02);">
                    <th
                        style="padding: 15px 25px; font-weight: 700; color: var(--text-secondary); font-size: 12px; text-transform: uppercase;">
                        Folio Entrega</th>
                    <th
                        style="padding: 15px 25px; font-weight: 700; color: var(--text-secondary); font-size: 12px; text-transform: uppercase;">
                        Cliente / Pedido</th>
                    <th
                        style="padding: 15px 25px; font-weight: 700; color: var(--text-secondary); font-size: 12px; text-transform: uppercase;">
                        Estado Envío</th>
                    <th
                        style="padding: 15px 25px; font-weight: 700; color: var(--text-secondary); font-size: 12px; text-transform: uppercase;">
                        Estatus</th>
                    <th
                        style="padding: 15px 25px; font-weight: 700; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; text-align: right;">
                        Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($entregas)): ?>
                    <tr>
                        <td colspan="5" style="padding: 50px; text-align: center; color: var(--text-secondary);">
                            <i class="fas fa-box-open" style="font-size: 40px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <p>No hay entregas programadas actualmente.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($entregas as $e):
                        $stMapping = [
                            'Programado' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'text' => '#3b82f6', 'icon' => 'fa-clock'],
                            'En Tránsito' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'text' => '#f59e0b', 'icon' => 'fa-truck-fast'],
                            'Entregado' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981', 'icon' => 'fa-check-double'],
                            'Incidencia' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444', 'icon' => 'fa-exclamation-triangle']
                        ];
                        $st = $stMapping[$e['estatus']] ?? $stMapping['Programado'];
                        ?>
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.3s;"
                            onmouseover="this.style.background='rgba(41, 56, 135, 0.01)'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 20px 25px;">
                                <div style="font-weight: 800; color: var(--text-primary); font-size: 15px;">
                                    <?= $e['folio'] ?>
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary);">Creado:
                                    <?= date('d/m/Y', strtotime($e['fecha_creacion'])) ?>
                                </div>
                            </td>
                            <td style="padding: 20px 25px;">
                                <div style="font-weight: 600; color: var(--text-primary);">
                                    <?= $e['cliente'] ?>
                                </div>
                                <div style="font-size: 11px; color: var(--accent-color); font-weight: 700;">Ref:
                                    <?= $e['folio_pedido'] ?>
                                </div>
                            </td>
                            <td style="padding: 20px 25px;">
                                <div style="font-size: 13px; font-weight: 500;">
                                    <i class="fas fa-map-marker-alt" style="color: #ef4444; margin-right: 5px;"></i>
                                    ZONA METROPOLITANA
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary);">Est. Entrega:
                                    <?= $e['fecha_entrega_estimada'] ? date('d/m/Y', strtotime($e['fecha_entrega_estimada'])) : 'N/A' ?>
                                </div>
                            </td>
                            <td style="padding: 20px 25px;">
                                <span
                                    style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 800; background: <?= $st['bg'] ?>; color: <?= $st['text'] ?>; text-transform: uppercase;">
                                    <i class="fas <?= $st['icon'] ?>"></i>
                                    <?= $e['estatus'] ?>
                                </span>
                            </td>
                            <td style="padding: 20px 25px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a title="Ver Detalle y Firma"
                                        href="index.php?controller=Logistica&action=detalle&id=<?= $e['id'] ?>"
                                        style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: rgba(41, 56, 135, 0.1); color: var(--accent-color); border-radius: 12px; text-decoration: none; transition: all 0.3s;"
                                        onmouseover="this.style.background='var(--accent-color)'; this.style.color='white';"
                                        onmouseout="this.style.background='rgba(41, 56, 135, 0.1)'; this.style.color='var(--accent-color)';">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button onclick="openPrintModal(<?= $e['id'] ?>)" title="Imprimir Nota de Entrega"
                                        style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.05); color: var(--text-secondary); border-radius: 12px; border: none; cursor: pointer; transition: all 0.3s;"
                                        onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                        onmouseout="this.style.background='rgba(0,0,0,0.05)'; this.style.color='var(--text-secondary)';">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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

    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
    }

    .pending-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(41, 56, 135, 0.08);
        border-color: var(--accent-color);
    }

    .btn-generate:hover {
        filter: brightness(1.2);
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(41, 56, 135, 0.3);
    }
</style>