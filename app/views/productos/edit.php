<?php
$stockActual = (int) ($producto['stock_actual'] ?? 0);
$stockMinimo = (int) ($producto['stock_minimo'] ?? 10);
$stockMax = $stockMinimo * 2;
$porcentaje = ($stockMax > 0) ? min(100, ($stockActual / $stockMax) * 100) : 0;

// Lógica de colores y estados
if ($stockActual <= 0) {
    $statusColor = '#ef4444';
    $statusText = 'Sin Stock';
    $statusBg = 'rgba(239, 68, 68, 0.1)';
} elseif ($stockActual < $stockMinimo) {
    $statusColor = '#f59e0b';
    $statusText = 'Stock Bajo';
    $statusBg = 'rgba(245, 158, 11, 0.1)';
} else {
    $statusColor = '#10b981';
    $statusText = 'En Stock';
    $statusBg = 'rgba(16, 185, 129, 0.1)';
}
?>

<div style="max-width: 900px; margin: 0 auto; padding-bottom: 50px;">
    <!-- Encabezado con navegación de regreso -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="index.php?controller=Productos&action=index"
                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 12px; color: var(--text-primary); text-decoration: none; transition: all 0.3s ease;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 style="font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; margin: 0;">Editar Producto
            </h2>
        </div>

        <div
            style="display: flex; align-items: center; gap: 10px; padding: 8px 15px; background: <?= $statusBg ?>; border-radius: 12px; border: 1px solid <?= $statusColor ?>20;">
            <div style="width: 8px; height: 8px; border-radius: 50%; background: <?= $statusColor ?>;"></div>
            <span
                style="font-size: 13px; font-weight: 800; color: <?= $statusColor ?>; text-transform: uppercase;"><?= $statusText ?></span>
        </div>
    </div>

    <form action="index.php?controller=Productos&action=update" method="POST">
        <input type="hidden" name="id" value="<?= $producto['id'] ?>">

        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px;">
            <!-- Panel Izquierdo: Datos Principales -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="card"
                    style="padding: 25px; border-radius: 24px; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border);">
                    <h3
                        style="font-size: 14px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 20px;">
                        Información General</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label class="form-label">SKU / Código</label>
                            <input type="text" name="sku" value="<?= $producto['sku'] ?>" required class="form-input"
                                style="font-family: 'Inter', monospace; font-weight: 600;">
                        </div>
                        <div>
                            <label class="form-label">Precio de Venta</label>
                            <div style="position: relative;">
                                <span
                                    style="position: absolute; left: 15px; top: 12px; color: var(--text-secondary); font-weight: 600;">$</span>
                                <input type="number" step="0.01" name="precio_venta"
                                    value="<?= $producto['precio_venta'] ?>" required class="form-input"
                                    style="padding-left: 30px; font-weight: 700; color: var(--accent-color);">
                            </div>
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label">Descripción del Producto</label>
                        <textarea name="descripcion" required rows="4" class="form-input"
                            style="height: auto; font-size: 15px; line-height: 1.5;"><?= $producto['descripcion'] ?></textarea>
                    </div>

                    <div class="pedimento-toggle-field"
                        style="background: rgba(41, 56, 135, 0.05); padding: 20px; border-radius: 18px; display: flex; justify-content: space-between; align-items: center; border: 1px dashed var(--accent-color)20;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div
                                style="width: 45px; height: 45px; border-radius: 12px; background: var(--accent-color); color: white; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; color: var(--text-primary); font-size: 15px;">Control de Pedimento
                                </h4>
                                <p style="margin: 0; font-size: 11px; color: var(--text-secondary);">¿Requiere
                                    trazabilidad aduanal?</p>
                            </div>
                        </div>
                        <label class="switch">
                            <input type="checkbox" name="requiere_pedimento" <?= $producto['requiere_pedimento'] ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <!-- Panel de Stock -->
                <div class="card"
                    style="padding: 25px; border-radius: 24px; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border);">
                    <h3
                        style="font-size: 14px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 20px;">
                        Inventario y Alertas</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <label class="form-label">Configurar Stock Mínimo</label>
                            <input type="number" name="stock_minimo" value="<?= $stockMinimo ?>" required
                                class="form-input" style="font-weight: 700;">
                            <p style="font-size: 11px; color: var(--text-secondary); margin-top: 8px;">
                                <i class="fas fa-info-circle"></i> Define el punto de re-orden para recibir alertas.
                            </p>
                        </div>

                        <div
                            style="background: rgba(255,255,255,0.4); padding: 15px; border-radius: 18px; border: 1px solid var(--glass-border);">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span style="font-size: 12px; font-weight: 600; color: var(--text-secondary);">Stock
                                    Real en Bodega</span>
                                <span
                                    style="font-size: 18px; font-weight: 800; color: var(--text-primary);"><?= $stockActual ?></span>
                            </div>
                            <div class="stock-bar-container" style="height: 8px; margin-bottom: 5px;">
                                <div class="stock-bar-fill"
                                    style="width: <?= $porcentaje ?>%; background: <?= $statusColor ?>;"></div>
                            </div>
                            <div
                                style="display: flex; justify-content: space-between; font-size: 10px; font-weight: 700; color: var(--text-secondary);">
                                <span>DISPONIBLE: <?= $stockActual ?></span>
                                <span>META: <?= $stockMax ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho: Media -->
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="card"
                    style="padding: 25px; border-radius: 24px; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border);">
                    <h3
                        style="font-size: 14px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 20px;">
                        Imagen del Producto</h3>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label">URL de la Imagen</label>
                        <input type="text" name="imagen_url" value="<?= $producto['imagen_url'] ?? '' ?>"
                            placeholder="https://ejemplo.com/motor.jpg" class="form-input" id="imageUrlInput">
                    </div>

                    <div
                        style="width: 100%; aspect-ratio: 1; border-radius: 20px; background: white; border: 1px solid var(--glass-border); overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                        <?php if ($producto['imagen_url']): ?>
                            <img src="<?= $producto['imagen_url'] ?>" id="imagePreview" alt="Preview"
                                style="width: 100%; height: 100%; object-fit: contain;">
                        <?php else: ?>
                            <div id="placeholderPreview"
                                style="text-align: center; color: var(--text-secondary); opacity: 0.3;">
                                <i class="fas fa-image" style="font-size: 60px; margin-bottom: 15px;"></i>
                                <p style="font-size: 12px; font-weight: 600;">Sin vista previa</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 10px;">
                    <button type="submit" class="btn btn-primary"
                        style="width: 100%; padding: 18px; border-radius: 18px; font-weight: 800; font-size: 16px; background: var(--accent-color); box-shadow: 0 10px 25px rgba(41, 56, 135, 0.25); display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fas fa-save"></i>
                        Guardar Cambios
                    </button>
                    <a href="index.php?controller=Productos&action=index" class="btn"
                        style="width: 100%; padding: 15px; border-radius: 18px; font-weight: 700; background: #e2e8f0; color: #475569; text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fas fa-times"></i>
                        Cancelar y Salir
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview de imagen dinámico
    document.getElementById('imageUrlInput').addEventListener('input', function (e) {
        const url = e.target.value;
        const preview = document.getElementById('imagePreview');
        const placeholder = document.getElementById('placeholderPreview');

        if (url) {
            if (!preview) {
                const newImg = document.createElement('img');
                newImg.id = 'imagePreview';
                newImg.style.width = '100%';
                newImg.style.height = '100%';
                newImg.style.objectFit = 'contain';
                newImg.src = url;
                placeholder.parentNode.appendChild(newImg);
                placeholder.style.display = 'none';
            } else {
                preview.src = url;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            }
        } else {
            if (preview) preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'block';
        }
    });
</script>

<style>
    .form-label {
        display: block;
        font-size: 13px;
        margin-bottom: 8px;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: none;
        letter-spacing: 0;
    }

    .form-input {
        width: 100%;
        padding: 14px 18px;
        border-radius: 15px;
        border: 1px solid #e2e8f0;
        font-family: 'Outfit';
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: rgba(255, 255, 255, 0.8);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        background: white;
        box-shadow: 0 0 0 4px rgba(41, 56, 135, 0.1);
        transform: translateY(-2px);
    }

    /* Toggle Switch Premium */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
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
        background-color: #cbd5e1;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    input:checked+.slider {
        background-color: var(--accent-color);
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }

    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        border-color: var(--accent-color)40;
    }
</style>