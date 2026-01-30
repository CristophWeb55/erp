<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Catálogo de Productos</h2>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="fas fa-plus"></i> Nuevo Producto
    </button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Descripción</th>
                <th>Precio Venta</th>
                <th>Maneja Pedimento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 40px;">No hay
                        productos registrados</td>
                </tr>
            <?php else: ?>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td style="font-family: monospace; font-weight: 700; color: var(--accent-color);">
                            <?= $p['sku'] ?>
                        </td>
                        <td>
                            <?= $p['descripcion'] ?>
                        </td>
                        <td style="font-weight: 600;">$
                            <?= number_format($p['precio_venta'], 2) ?>
                        </td>
                        <td>
                            <?php if ($p['requiere_pedimento']): ?>
                                <span
                                    style="padding: 4px 10px; border-radius: 20px; font-size: 11px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 700;">
                                    <i class="fas fa-shield-alt"></i> SÍ REQUIERE
                                </span>
                            <?php else: ?>
                                <span style="color: var(--text-secondary); font-size: 11px;">No requiere</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn" style="background: transparent; color: var(--accent-color); padding: 5px;"><i
                                    class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="modalProducto"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 500px; background: white;">
        <h3 style="margin-bottom: 20px;">Nuevo Producto</h3>
        <form action="index.php?controller=Productos&action=create" method="POST">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">SKU
                            / Código</label>
                        <input type="text" name="sku" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Precio
                            Venta</label>
                        <input type="number" step="0.01" name="precio_venta" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Descripción</label>
                    <textarea name="descripcion" required rows="3"
                        style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;"></textarea>
                </div>

                <!-- Toggle switch for Pedimento -->
                <div
                    style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <div>
                        <p style="font-weight: 600; font-size: 14px;">¿Requiere Pedimento Aduanal?</p>
                        <p style="font-size: 11px; color: var(--text-secondary);">Activar para productos de importación
                            que requieren trazabilidad fiscal.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="requiere_pedimento">
                        <span class="slider round"></span>
                    </label>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn" style="background: #f1f5f9;"
                        onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar SKU</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Simple Toggle Switch Style */
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: var(--accent-color);
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }
</style>

<script>
    function openModal() {
        document.getElementById('modalProducto').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('modalProducto').style.display = 'none';
    }
</script>