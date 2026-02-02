<div class="glass-panel" style="padding: 30px; border-radius: 24px;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
        <a href="index.php?controller=Compras&action=index" style="color: var(--text-secondary); font-size: 20px;"><i
                class="fas fa-arrow-left"></i></a>
        <h2 style="font-weight: 800; font-size: 28px; color: var(--text-primary); margin: 0;">Nueva Orden de Compra</h2>
    </div>

    <form action="index.php?controller=Compras&action=save" method="POST" id="formCompra">

        <!-- Datos Generales -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div>
                <label
                    style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Proveedor</label>
                <select name="proveedor_id" required
                    style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; font-size: 14px;">
                    <option value="">Seleccione un proveedor...</option>
                    <?php foreach ($proveedores as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['nombre_razon_social'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label
                    style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Fecha
                    Compra</label>
                <input type="date" name="fecha_compra" value="<?= date('Y-m-d') ?>" required
                    style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; font-size: 14px;">
            </div>
            <div>
                <label
                    style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Referencia
                    / Factura Prov.</label>
                <input type="text" name="referencia" placeholder="Ej. FAC-1234"
                    style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; font-size: 14px;">
            </div>
            <div>
                <label
                    style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Observaciones</label>
                <input type="text" name="observaciones" placeholder="Notas internas..."
                    style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: #f8fafc; font-size: 14px;">
            </div>
        </div>

        <!-- Selección de Productos -->
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 15px;">Productos</h3>
        <div style="background: #f8fafc; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0;">
            <table style="width: 100%;">
                <thead>
                    <tr style="text-align: left; font-size: 12px; color: var(--text-secondary);">
                        <th style="padding-bottom: 10px;">Producto</th>
                        <th style="padding-bottom: 10px; width: 100px;">Cantidad</th>
                        <th style="padding-bottom: 10px; width: 150px;">Costo Unit.</th>
                        <th style="padding-bottom: 10px; width: 150px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="listaProductos">
                    <?php foreach ($productos as $prod): ?>
                        <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                            <td style="padding: 10px 0;">
                                <div style="font-weight: 700;">
                                    <?= $prod['sku'] ?>
                                </div>
                                <div style="font-size: 12px; color: var(--text-secondary);">
                                    <?= $prod['descripcion'] ?>
                                </div>
                            </td>
                            <td style="padding: 10px 0;">
                                <input type="number" name="productos[<?= $prod['id'] ?>]" min="0" value="0" class="inp-cant"
                                    data-id="<?= $prod['id'] ?>"
                                    style="width: 80px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </td>
                            <td style="padding: 10px 0;">
                                <input type="number" name="costos[<?= $prod['id'] ?>]" step="0.01"
                                    value="<?= $prod['costo_promedio'] ?>" class="inp-costo" data-id="<?= $prod['id'] ?>"
                                    style="width: 120px; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                            </td>
                            <td style="padding: 10px 0; font-weight: 700; color: var(--text-primary);">
                                $<span id="sub-<?= $prod['id'] ?>">0.00</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="text-align: right; margin-top: 20px; font-size: 20px; font-weight: 800;">
                Total: $<span id="totalVenta">0.00</span>
            </div>
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit"
                style="background: var(--accent-color); color: white; border: none; padding: 15px 30px; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 15px rgba(41, 56, 135, 0.2);">
                <i class="fas fa-save"></i> Guardar Orden
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.inp-cant, .inp-costo');

        function calcular() {
            let total = 0;
            document.querySelectorAll('.inp-cant').forEach(cantInput => {
                const id = cantInput.dataset.id;
                const cant = parseFloat(cantInput.value) || 0;
                const costoInput = document.querySelector(`.inp-costo[data-id="${id}"]`);
                const costo = parseFloat(costoInput.value) || 0;

                const sub = cant * costo;
                document.getElementById(`sub-${id}`).innerText = sub.toFixed(2);
                total += sub;
            });
            document.getElementById('totalVenta').innerText = total.toFixed(2);
        }

        inputs.forEach(inp => inp.addEventListener('input', calcular));
    });
</script>