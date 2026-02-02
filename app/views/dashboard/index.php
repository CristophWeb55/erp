<div style="display: flex; flex-direction: column; gap: 30px; animation: fadeIn 0.5s ease-out;">
    
    <!-- Welcome Section (Compact) -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: var(--text-primary); margin: 0;">Resumen Operativo</h1>
            <p style="color: var(--text-secondary); margin: 5px 0 0; font-size: 14px;">Panorama general del estado de la empresa.</p>
        </div>
        <div style="background: white; padding: 10px 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 10px;">
            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);"></div>
            <span style="font-weight: 600; font-size: 13px; color: var(--text-primary);">Sistema Actualizado</span>
        </div>
    </div>

    <!-- KPI Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
        
        <!-- Card 1: Ventas -->
        <div class="glass-panel" style="padding: 25px; border-radius: 20px; position: relative; overflow: hidden; transition: transform 0.2s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="position: absolute; top: -10px; right: -10px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);">
                    <i class="fas fa-chart-line" style="font-size: 18px;"></i>
                </div>
                <span style="background: rgba(99, 102, 241, 0.1); color: #6366f1; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">Este Mes</span>
            </div>
            
            <div style="font-size: 28px; font-weight: 800; color: var(--text-primary); margin-bottom: 5px;">
                $<?= number_format($kpis['cotizaciones_mes_monto'], 2) ?>
            </div>
            <p style="color: var(--text-secondary); font-size: 13px; font-weight: 500; margin: 0;">
                <?= $kpis['cotizaciones_mes_count'] ?> Cotizaciones generadas
            </p>
        </div>

        <!-- Card 2: Logística -->
        <div class="glass-panel" style="padding: 25px; border-radius: 20px; position: relative; overflow: hidden; transition: transform 0.2s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="position: absolute; top: -10px; right: -10px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);">
                    <i class="fas fa-truck-fast" style="font-size: 18px;"></i>
                </div>
                 <span style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">Activos</span>
            </div>
            
            <div style="font-size: 28px; font-weight: 800; color: var(--text-primary); margin-bottom: 5px;">
                <?= $kpis['entregas_ruta'] ?>
            </div>
            <p style="color: var(--text-secondary); font-size: 13px; font-weight: 500; margin: 0;">
                Envíos en ruta actualmente
            </p>
        </div>

        <!-- Card 3: Compras/Abasto -->
        <div class="glass-panel" style="padding: 25px; border-radius: 20px; position: relative; overflow: hidden; transition: transform 0.2s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
             <div style="position: absolute; top: -10px; right: -10px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(0,0,0,0) 70%); border-radius: 50%;"></div>

            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-dolly" style="font-size: 18px;"></i>
                </div>
                 <a href="index.php?controller=Compras&action=index" style="text-decoration: none; background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700;">Ver Todo</a>
            </div>
            
            <div style="display: flex; align-items: baseline; gap: 5px; margin-bottom: 5px;">
                <span style="font-size: 28px; font-weight: 800; color: var(--text-primary);"><?= $kpis['compras_pendientes'] ?></span>
                <span style="font-size: 16px; color: var(--text-secondary); font-weight: 600;">/ <?= $kpis['pedidos_pendientes'] ?></span>
            </div>
            <p style="color: var(--text-secondary); font-size: 13px; font-weight: 500; margin: 0;">
                Compras Pend. / Pedidos por Surtir
            </p>
        </div>

        <!-- Card 4: Alertas (Stock) -->
        <div class="glass-panel" style="padding: 25px; border-radius: 20px; position: relative; overflow: hidden; border: 1px solid rgba(239, 68, 68, 0.3); transition: transform 0.2s; cursor: default;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="position: absolute; top: -10px; right: -10px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(239, 68, 68, 0.1) 0%, rgba(0,0,0,0) 70%); border-radius: 50%;"></div>
            
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);">
                    <i class="fas fa-triangle-exclamation" style="font-size: 18px;"></i>
                </div>
                <span style="background: #fef2f2; color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid rgba(239,68,68,0.2);">Acción Req.</span>
            </div>
            
            <div style="font-size: 28px; font-weight: 800; color: #ef4444; margin-bottom: 5px;">
                <?= $kpis['productos_stock_bajo'] ?> Items
            </div>
            <p style="color: var(--text-secondary); font-size: 13px; font-weight: 500; margin: 0;">
                Con stock crítico o agotado
            </p>
            <a href="index.php?controller=Inventario&action=index" style="position: absolute; inset: 0;" title="Ir al inventario"></a>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-clock-rotate-left" style="color: var(--accent-color);"></i>
                Actividad Reciente
            </h3>
            <div style="display: flex; gap: 5px;">
                <span style="font-size: 10px; font-weight: 700; padding: 4px 12px; background: #f1f5f9; border-radius: 20px; color: var(--text-secondary); border: 1px solid #e2e8f0;">Tiempo Real</span>
            </div>
        </div>
        
        <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="text-align: left; color: var(--text-secondary); font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                    <th style="padding: 15px; font-weight: 700;">Movimiento</th>
                    <th style="padding: 15px; font-weight: 700;">Referencia</th>
                    <th style="padding: 15px; font-weight: 700;">Cliente / Proveedor</th>
                    <th style="padding: 15px; font-weight: 700;">Detalles</th>
                    <th style="padding: 15px; font-weight: 700;">Monto</th>
                    <th style="padding: 15px; font-weight: 700;">Estatus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activity as $act): ?>
                    <tr style="transition: background 0.2s; cursor: default;" onmouseover="this.style.background='rgba(0,0,0,0.01)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; border-bottom: 1px solid rgba(0,0,0,0.03);">
                            <?php
                            $icon = 'fa-file';
                            $color = '#64748b';
                            $bg = '#f1f5f9';
                            if ($act['tipo'] == 'Cotización') {
                                $icon = 'fa-file-invoice';
                                $color = '#6366f1';
                                $bg = 'rgba(99, 102, 241, 0.1)';
                            }
                            if ($act['tipo'] == 'Pedido') {
                                $icon = 'fa-box';
                                $color = '#f59e0b';
                                $bg = 'rgba(245, 158, 11, 0.1)';
                            }
                            if ($act['tipo'] == 'Compra') {
                                $icon = 'fa-shopping-bag';
                                $color = '#10b981';
                                $bg = 'rgba(16, 185, 129, 0.1)';
                            }
                            ?>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: <?= $bg ?>; display: flex; align-items: center; justify-content: center; color: <?= $color ?>;">
                                    <i class="fas <?= $icon ?>" style="font-size: 14px;"></i>
                                </div>
                                <span style="font-weight: 700; font-size: 13px; color: var(--text-primary);"><?= $act['tipo'] ?></span>
                            </div>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid rgba(0,0,0,0.03); font-family: 'Courier New', monospace; font-weight: 600; font-size: 13px; color: var(--text-primary);">
                            <?= $act['referencia'] ?: 'S/N' ?>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid rgba(0,0,0,0.03); font-size: 13px; color: var(--text-secondary); font-weight: 500;">
                            <?= $act['tercero'] ?>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid rgba(0,0,0,0.03); color: var(--text-secondary); font-size: 12px;">
                            <i class="far fa-calendar" style="margin-right: 5px; opacity: 0.7;"></i><?= date('d M', strtotime($act['created_at'])) ?>
                            <span style="opacity: 0.5; margin-left: 5px;"><?= date('H:i', strtotime($act['created_at'])) ?></span>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid rgba(0,0,0,0.03); font-weight: 800; color: var(--text-primary);">
                            $<?= number_format($act['total'], 2) ?>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid rgba(0,0,0,0.03);">
                            <span style="padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
                        <?php
                        $st = strtoupper($act['estatus']);
                        if (in_array($st, ['APROBADA', 'ENTREGADO', 'RECIBIDA', 'PAGADA']))
                            echo 'background: rgba(16, 185, 129, 0.1); color: #10b981;';
                        elseif (in_array($st, ['PENDIENTE', 'EN PROCESO', 'EN TRÁNSITO']))
                            echo 'background: rgba(59, 130, 246, 0.1); color: #3b82f6;';
                        elseif (in_array($st, ['BORRADOR']))
                            echo 'background: rgba(148, 163, 184, 0.1); color: #64748b;';
                        elseif (in_array($st, ['CANCELADA']))
                            echo 'background: rgba(239, 68, 68, 0.1); color: #ef4444;';
                        else
                            echo 'background: rgba(245, 158, 11, 0.1); color: #f59e0b;';
                        ?>
                        ">
                                <?= $act['estatus'] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($activity)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 50px; color: var(--text-secondary);">
                            <div style="width: 60px; height: 60px; background: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                <i class="fas fa-inbox" style="font-size: 24px; opacity: 0.3;"></i>
                            </div>
                            <p style="margin: 0;">No hay actividad reciente registrada.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>