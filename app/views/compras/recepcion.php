<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <a href="index.php?controller=Compras&action=index" class="btn"
            style="background: rgba(255,255,255,0.5); padding: 10px 15px;"><i class="fas fa-arrow-left"></i></a>
        <h2>Recepción de Mercancía - Orden #
            <?= $compra['id'] ?>
        </h2>
    </div>

    <div class="card" style="margin-bottom: 20px;">
        <div
            style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--glass-border); padding-bottom: 15px; margin-bottom: 15px;">
            <div>
                <p style="font-size: 12px; color: var(--text-secondary);">Proveedor</p>
                <p style="font-weight: 700; font-size: 18px;">
                    <?= $compra['nombre_razon_social'] ?>
                </p>
            </div>
            <div style="text-align: right;">
                <p style="font-size: 12px; color: var(--text-secondary);">Referencia</p>
                <p style="font-weight: 600;">
                    <?= $compra['referencia'] ?>
                </p>
            </div>
        </div>

        <form action="index.php?controller=Compras&action=process_receiving" method="POST">
            <input type="hidden" name="compra_id" value="<?= $compra['id'] ?>">

            <p style="font-weight: 700; margin-bottom: 15px; color: var(--accent-color);">DETALLE DE ENTRADA</p>

            <div
                style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; background: rgba(99, 102, 241, 0.05); padding: 20px; border-radius: 16px; border: 1px solid var(--accent-glow);">
                <div>
                    <label style="display: block; font-size: 12px; margin-bottom: 5px;">Producto</label>
                    <select name="producto_id" required
                        style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; background: white;">
                        <!-- In a real app we would load items from the order, here we use products for demo -->
                        <?php
                        $prodMod = new Productos();
                        $prods = $prodMod->getAll();
                        foreach ($prods as $p): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= $p['sku'] ?> -
                                <?= $p['descripcion'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; margin-bottom: 5px;">Cantidad Recibida</label>
                    <input type="number" name="cantidad" value="100" required
                        style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                </div>
            </div>

            <div
                style="margin-top: 30px; padding: 25px; background: rgba(255, 255, 255, 0.4); border-radius: 20px; border: 2px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                    <div
                        style="width: 40px; height: 40px; background: #6366f1; color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-passport"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0;">Información Aduanera (Pedimento)</h4>
                        <p style="font-size: 11px; color: var(--text-secondary);">Obligatorio para cumplimiento fiscal
                            de importación</p>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 12px; margin-bottom: 5px; font-weight: 600;">Número de
                            Pedimento (15-21 dígitos)</label>
                        <input type="text" name="numero_pedimento" placeholder="Ej: 24 47 3009 8001234" required
                            style="width: 100%; padding: 15px; border-radius: 12px; border: 2px solid var(--accent-glow); font-family: monospace; font-size: 16px; letter-spacing: 2px;">
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12px; margin-bottom: 5px;">Fecha Pedimento</label>
                            <input type="date" name="fecha_pedimento" required value="<?= date('Y-m-d') ?>"
                                style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-size: 12px; margin-bottom: 5px;">Aduana de
                                Entrada</label>
                            <input type="text" name="nombre_aduana" placeholder="Ej: Aduana de Laredo" required
                                style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 16px;">
                    <i class="fas fa-check-circle"></i> Finalizar Recepción y Crear Lote
                </button>
            </div>
        </form>
    </div>
</div>