<div style="animation: fadeIn 0.4s ease-out;">

    <!-- 📊 INDICADORES RÁPIDOS (KPIs) -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 35px;">
        <div class="glass-card-kpi" style="border-left: 5px solid var(--accent-color);">
            <div class="kpi-icon" style="background: rgba(41, 56, 135, 0.1); color: var(--accent-color);">
                <i class="fas fa-boxes"></i>
            </div>
            <div>
                <p class="kpi-label">Productos Totales</p>
                <h3 class="kpi-value">
                    <?= $stats['total_productos'] ?>
                </h3>
            </div>
        </div>

        <div class="glass-card-kpi" style="border-left: 5px solid #10b981;">
            <div class="kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div>
                <p class="kpi-label">Valor Estimado</p>
                <h3 class="kpi-value">$
                    <?= number_format($stats['valor_inventario'], 2) ?>
                </h3>
            </div>
        </div>

        <div class="glass-card-kpi" style="border-left: 5px solid #f59e0b;">
            <div class="kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <p class="kpi-label">Stock Bajo</p>
                <h3 class="kpi-value">
                    <?= $stats['productos_bajo_stock'] ?>
                </h3>
            </div>
        </div>

        <div class="glass-card-kpi" style="border-left: 5px solid #ef4444;">
            <div class="kpi-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <p class="kpi-label">Agotados</p>
                <h3 class="kpi-value">
                    <?= $stats['productos_sin_stock'] ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 style="font-weight: 800; font-size: 24px; color: var(--text-primary); margin: 0;">Resumen de Existencias
            </h2>
            <div style="display: flex; gap: 10px;">
                <div class="search-bar" style="position: relative;">
                    <i class="fas fa-search"
                        style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="invSearch" placeholder="Buscar por SKU..."
                        style="padding: 10px 15px 10px 40px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); width: 200px;">
                </div>
                <button class="btn btn-secondary" onclick="exportToExcel()"
                    style="border-radius: 12px; padding: 10px 15px; background: white; border: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-file-excel" style="color: #10b981;"></i> Exportar
                </button>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 8px;">
                <thead>
                    <tr style="text-align: left;">
                        <th
                            style="padding: 15px 20px; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; font-weight: 700;">
                            Producto</th>
                        <th
                            style="padding: 15px 20px; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; font-weight: 700;">
                            Precio</th>
                        <th
                            style="padding: 15px 20px; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; font-weight: 700;">
                            Existencia Actual</th>
                        <th
                            style="padding: 15px 20px; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; font-weight: 700;">
                            Min. Requerido</th>
                        <th
                            style="padding: 15px 20px; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; font-weight: 700;">
                            Estado</th>
                        <th
                            style="padding: 15px 20px; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; font-weight: 700; text-align: right;">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody id="inventoryTable">
                    <?php foreach ($stock as $s):
                        $actual = (int) $s['stock_actual'];
                        $minimo = (int) $s['stock_minimo'];

                        if ($actual <= 0) {
                            $status = ['c' => '#ef4444', 'bg' => 'rgba(239, 68, 68, 0.1)', 't' => 'AGOTADO', 'icon' => 'fa-times'];
                        } elseif ($actual < $minimo) {
                            $status = ['c' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.1)', 't' => 'BAJO STOCK', 'icon' => 'fa-exclamation'];
                        } else {
                            $status = ['c' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.1)', 't' => 'EN STOCK', 'icon' => 'fa-check'];
                        }
                        ?>
                        <tr class="inv-row"
                            style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                            <td style="padding: 20px; border-radius: 12px 0 0 12px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <?php if ($s['imagen_url']): ?>
                                        <img src="<?= $s['imagen_url'] ?>"
                                            style="width: 45px; height: 45px; border-radius: 10px; object-fit: cover; background: #f8fafc;">
                                    <?php else: ?>
                                        <div
                                            style="width: 45px; height: 45px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: var(--accent-color); opacity: 0.3;">
                                            <i class="fas fa-box"></i></div>
                                    <?php endif; ?>
                                    <div>
                                        <h4
                                            style="margin: 0; font-size: 14px; font-weight: 700; color: var(--text-primary);">
                                            <?= $s['sku'] ?>
                                        </h4>
                                        <p style="margin: 0; font-size: 12px; color: var(--text-secondary);">
                                            <?= $s['descripcion'] ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 20px; font-weight: 600; color: var(--text-primary);">$
                                <?= number_format($s['precio_venta'], 2) ?>
                            </td>
                            <td style="padding: 20px;">
                                <div style="font-weight: 800; font-size: 16px; color: <?= $status['c'] ?>;">
                                    <?= $actual ?>
                                </div>
                                <div style="font-size: 10px; color: var(--text-secondary);">
                                    <?= $s['total_lotes'] ?> lotes registrados
                                </div>
                            </td>
                            <td style="padding: 20px; font-weight: 700; color: var(--text-secondary);">
                                <?= $minimo ?>
                            </td>
                            <td style="padding: 20px;">
                                <span
                                    style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 10px; font-size: 10px; font-weight: 800; background: <?= $status['bg'] ?>; color: <?= $status['c'] ?>;">
                                    <i class="fas <?= $status['icon'] ?>"></i>
                                    <?= $status['t'] ?>
                                </span>
                            </td>
                            <td style="padding: 20px; text-align: right; border-radius: 0 12px 12px 0;">
                                <a href="index.php?controller=Inventario&action=detalle&id=<?= $s['id'] ?>" class="btn-icon"
                                    title="Ver Kardex / Lotes">
                                    <i class="fas fa-history"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .glass-card-kpi {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        padding: 25px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--glass-shadow);
        transition: transform 0.3s;
    }

    .glass-card-kpi:hover {
        transform: translateY(-5px);
    }

    .kpi-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .kpi-label {
        margin: 0;
        font-size: 12px;
        color: var(--text-secondary);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .kpi-value {
        margin: 2px 0 0 0;
        font-size: 24px;
        font-weight: 800;
        color: var(--text-primary);
    }

    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(41, 56, 135, 0.05);
        color: var(--accent-color);
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-icon:hover {
        background: var(--accent-color);
        color: white;
        transform: rotate(15deg);
    }

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
</style>

<script>
    document.getElementById('invSearch').addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.inv-row').forEach(row => {
            const sku = row.querySelector('h4').innerText.toLowerCase();
            row.style.display = sku.includes(query) ? 'table-row' : 'none';
        });
    });

    function exportToExcel() {
        alert("Iniciando exportación de inventario...");
        // Simulación de exportación
    }
</script>