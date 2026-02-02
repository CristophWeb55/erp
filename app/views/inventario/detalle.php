<div style="animation: fadeIn 0.4s ease-out;">
    <div style="margin-bottom: 25px;">
        <a href="index.php?controller=Inventario&action=index"
            style="text-decoration: none; color: var(--text-secondary); font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Volver al Inventario
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
        <!-- Columna Izquierda: Info Producto -->
        <div>
            <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
                <div style="text-align: center; margin-bottom: 25px;">
                    <?php if ($producto['imagen_url']): ?>
                        <img src="<?= $producto['imagen_url'] ?>"
                            style="width: 150px; height: 150px; border-radius: 20px; object-fit: contain; background: white; padding: 10px; border: 1px solid rgba(0,0,0,0.05);">
                    <?php else: ?>
                        <div
                            style="width: 150px; height: 150px; border-radius: 20px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: var(--accent-color); font-size: 60px; margin: 0 auto;">
                            <i class="fas fa-box"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <h3
                    style="margin: 0; font-size: 22px; font-weight: 800; color: var(--text-primary); text-align: center;">
                    <?= $producto['sku'] ?>
                </h3>
                <p style="margin: 5px 0 25px 0; font-size: 14px; color: var(--text-secondary); text-align: center;">
                    <?= $producto['descripcion'] ?>
                </p>

                <div
                    style="background: rgba(0,0,0,0.02); border-radius: 16px; padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Existencia
                            Total</label>
                        <p style="margin: 0; font-weight: 800; font-size: 24px; color: var(--accent-color);">
                            <?= (int) $producto['stock_actual'] ?>
                        </p>
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 10px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; margin-bottom: 5px;">Mínimo
                            Ideal</label>
                        <p style="margin: 0; font-weight: 800; font-size: 24px; color: #64748b;">
                            <?= (int) $producto['stock_minimo'] ?>
                        </p>
                    </div>
                </div>

                <div style="margin-top: 25px;">
                    <button onclick="openAdjustModal()" class="btn btn-primary"
                        style="width: 100%; border-radius: 12px; padding: 12px; font-weight: 800; background: var(--accent-secondary); border: none; cursor: pointer;">
                        <i class="fas fa-plus"></i> Ajuste de Inventario
                    </button>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Kardex (Lotes/Pedimentos) -->
        <div>
            <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
                <h3 style="margin: 0 0 25px 0; font-weight: 800; color: var(--text-primary);">Historial de Lotes y
                    Pedimentos</h3>

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'adjusted'): ?>
                    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #10b981; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                        <i class="fas fa-check-circle"></i> Stock actualizado correctamente.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600;">
                        <i class="fas fa-times-circle"></i> Hubo un error al realizar el ajuste.
                    </div>
                <?php endif; ?>

                <?php if (empty($lotes)): ?>
                    <div style="text-align: center; padding: 50px; color: var(--text-secondary);">
                        <i class="fas fa-history" style="font-size: 40px; margin-bottom: 15px; opacity: 0.1;"></i>
                        <p>No se han registrado movimientos de entrada para este producto.</p>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php foreach ($lotes as $l): ?>
                            <div
                                style="background: white; border: 1px solid rgba(0,0,0,0.05); padding: 20px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div
                                        style="width: 45px; height: 45px; border-radius: 12px; background: <?= $l['cantidad_actual'] >= 0 ? 'rgba(59, 130, 246, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; color: <?= $l['cantidad_actual'] >= 0 ? '#3b82f6' : '#ef4444' ?>; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                        <i class="fas <?= $l['cantidad_actual'] >= 0 ? 'fa-barcode' : 'fa-minus-circle' ?>"></i>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 14px; font-weight: 800; color: var(--text-primary);">
                                            <?= $l['numero_pedimento'] ?: 'NO ASIGNADO' ?>
                                        </h4>
                                        <p
                                            style="margin: 3px 0 0 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">
                                            Ref: <?= $l['ref_compra'] ?: 'AJUSTE MANUAL' ?> •
                                            <?= date('d/m/Y', strtotime($l['created_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div
                                        style="font-size: 11px; color: var(--text-secondary); font-weight: 700; margin-bottom: 4px;">
                                        <?= $l['cantidad_actual'] >= 0 ? 'ENTRADA' : 'SALIDA' ?></div>
                                    <span
                                        style="background: <?= $l['cantidad_actual'] >= 0 ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; color: <?= $l['cantidad_actual'] >= 0 ? '#10b981' : '#ef4444' ?>; padding: 4px 12px; border-radius: 8px; font-weight: 800; font-size: 16px;">
                                        <?= $l['cantidad_actual'] >= 0 ? '+' . $l['cantidad_actual'] : $l['cantidad_actual'] ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Ajuste Premium -->
<div id="modalAdjust" class="modal-overlay" onclick="closeAdjustModal(event)">
    <div class="modal-content glass-panel" style="max-width: 450px; padding: 35px; border-radius: 30px;"
        onclick="event.stopPropagation()">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px;">
            <h3 style="margin:0; font-weight: 800; color: var(--text-primary); font-size: 20px;">Ajuste de Stock</h3>
            <button onclick="closeAdjustModal()"
                style="background: #f1f5f9; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer;"><i
                    class="fas fa-times"></i></button>
        </div>

        <form action="index.php?controller=Inventario&action=adjust" method="POST">
            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">

            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; font-size: 11px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Tipo
                    de Ajuste</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <label style="cursor: pointer;">
                        <input type="radio" name="tipo_ajuste" value="entrada" checked style="display: none;">
                        <div class="adjust-type-btn" data-type="entrada">
                            <i class="fas fa-arrow-up"></i> Entrada
                        </div>
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="tipo_ajuste" value="salida" style="display: none;">
                        <div class="adjust-type-btn" data-type="salida">
                            <i class="fas fa-arrow-down"></i> Salida
                        </div>
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; font-size: 11px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Cantidad</label>
                <input type="number" name="cantidad" required min="1" class="form-input"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); font-weight: 700; font-size: 18px; color: var(--accent-color);"
                    value="1">
            </div>

            <div style="margin-bottom: 30px;">
                <label
                    style="display: block; font-size: 11px; color: var(--text-secondary); font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Pedimento
                    / Referencia</label>
                <input type="text" name="pedimento" placeholder="Ej: PED-2024-001" class="form-input"
                    style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1);">
            </div>

            <button type="submit" class="btn btn-primary"
                style="width: 100%; padding: 15px; border-radius: 15px; font-weight: 800; background: var(--accent-color); color: white; border: none; box-shadow: 0 10px 20px rgba(41, 56, 135, 0.2);">
                Confirmar Movimiento
            </button>
        </form>
    </div>
</div>

<style>
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeInModal 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes fadeInModal {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .adjust-type-btn {
        padding: 12px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(0, 0, 0, 0.1);
        font-weight: 700;
        color: var(--text-secondary);
        transition: 0.3s;
    }

    input[type="radio"]:checked+.adjust-type-btn[data-type="entrada"] {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: #10b981;
    }

    input[type="radio"]:checked+.adjust-type-btn[data-type="salida"] {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-color: #ef4444;
    }

    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
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
function openAdjustModal() {
    document.getElementById('modalAdjust').classList.add('active');
}
function closeAdjustModal(e) {
    if (!e || e.target.id === 'modalAdjust') {
        document.getElementById('modalAdjust').classList.remove('active');
    }
}
</script>