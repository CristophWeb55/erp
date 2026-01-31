<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <a href="index.php?controller=Productos&action=index"
            style="color: var(--text-secondary); text-decoration: none;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2>Editar Producto</h2>
    </div>

    <div class="card" style="padding: 30px;">
        <form action="index.php?controller=Productos&action=update" method="POST">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <!-- SKU y Precio -->
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label class="form-label">SKU / Código</label>
                        <input type="text" name="sku" value="<?= $producto['sku'] ?>" required class="form-input">
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Precio Venta</label>
                        <input type="number" step="0.01" name="precio_venta" value="<?= $producto['precio_venta'] ?>"
                            required class="form-input">
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" required rows="4"
                        class="form-input"><?= $producto['descripcion'] ?></textarea>
                </div>

                <!-- Stock Mínimo e Imagen -->
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label class="form-label">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" value="<?= $producto['stock_minimo'] ?? 10 ?>" required
                            class="form-input">
                        <p style="font-size: 11px; color: var(--text-secondary); margin-top: 5px;">
                            Stock actual: <strong>
                                <?= $producto['stock_actual'] ?? 0 ?>
                            </strong> unidades
                        </p>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">URL de Imagen (opcional)</label>
                        <input type="text" name="imagen_url" value="<?= $producto['imagen_url'] ?? '' ?>"
                            placeholder="https://..." class="form-input">
                    </div>
                </div>

                <!-- Preview de imagen -->
                <?php if ($producto['imagen_url']): ?>
                    <div>
                        <label class="form-label">Vista previa de imagen</label>
                        <div
                            style="width: 200px; height: 200px; border-radius: 12px; overflow: hidden; border: 1px solid var(--glass-border);">
                            <img src="<?= $producto['imagen_url'] ?>" alt="Preview"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Toggle Pedimento -->
                <div class="pedimento-toggle">
                    <div>
                        <p style="font-weight: 600; font-size: 14px;">¿Requiere Pedimento Aduanal?</p>
                        <p style="font-size: 11px; color: var(--text-secondary);">Activar para productos de importación
                            que requieren trazabilidad fiscal.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="requiere_pedimento" <?= $producto['requiere_pedimento'] ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>

                <!-- Botones -->
                <div
                    style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--glass-border);">
                    <a href="index.php?controller=Productos&action=index" class="btn"
                        style="background: #f1f5f9; text-decoration: none;">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label {
        display: block;
        font-size: 12px;
        margin-bottom: 5px;
        color: var(--text-secondary);
        font-weight: 600;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-family: 'Outfit';
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
    }

    .pedimento-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        border: 1px dashed #cbd5e1;
    }

    /* Toggle Switch */
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