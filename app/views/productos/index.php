<div style="margin-bottom: 30px;">
    <!-- Barra de búsqueda y botón -->
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 25px;">
        <div style="flex: 1; max-width: 500px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
            <input type="text" id="searchInput" placeholder="Buscar productos por SKU o nombre..."
                style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid var(--glass-border); background: rgba(255,255,255,0.5); font-family: 'Outfit';">
        </div>
        <button class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> Nuevo Producto
        </button>
    </div>

    <h2 style="margin-bottom: 20px;">Catálogo de Productos</h2>
</div>

<!-- Grid de productos -->
<div class="products-grid" id="productsGrid">
    <?php if (empty($productos)): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-secondary);">
            <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
            <p style="font-size: 16px;">No hay productos registrados</p>
            <p style="font-size: 14px; margin-top: 5px;">Comienza agregando tu primer producto</p>
        </div>
    <?php else: ?>
        <?php foreach ($productos as $p):
            $stockActual = (int) $p['stock_actual'];
            $stockMinimo = (int) $p['stock_minimo'];
            $stockMax = $stockMinimo * 2; // Máximo para la barra
            $porcentaje = min(100, ($stockActual / $stockMax) * 100);

            // Determinar color de la barra y estado
            if ($stockActual == 0) {
                $barColor = '#ef4444'; // Rojo
                $estadoTexto = 'Sin Stock';
                $estadoColor = '#ef4444';
                $estadoBg = 'rgba(239, 68, 68, 0.1)';
            } elseif ($stockActual < $stockMinimo) {
                $barColor = '#f59e0b'; // Amarillo
                $estadoTexto = 'Stock Bajo';
                $estadoColor = '#f59e0b';
                $estadoBg = 'rgba(245, 158, 11, 0.1)';
            } else {
                $barColor = '#10b981'; // Verde
                $estadoTexto = 'En Stock';
                $estadoColor = '#10b981';
                $estadoBg = 'rgba(16, 185, 129, 0.1)';
            }
            ?>
            <div class="product-card">
                <!-- Badge de Pedimento -->
                <?php if ($p['requiere_pedimento']): ?>
                    <div class="pedimento-badge">
                        <i class="fas fa-shield-alt"></i> Maneja Pedimento
                    </div>
                <?php endif; ?>

                <!-- Imagen del producto -->
                <div class="product-image">
                    <?php if ($p['imagen_url']): ?>
                        <img src="<?= $p['imagen_url'] ?>" alt="<?= $p['sku'] ?>">
                    <?php else: ?>
                        <div class="product-placeholder">
                            <i class="fas fa-box"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Información del producto -->
                <div class="product-info">
                    <div class="product-sku"><?= $p['sku'] ?></div>
                    <div class="product-name"><?= $p['descripcion'] ?></div>
                    <div class="product-price">$<?= number_format($p['precio_venta'], 2) ?></div>
                </div>

                <!-- Stock info -->
                <div class="stock-info">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="font-size: 12px; color: var(--text-secondary);">
                            Stock Disponible: <?= $stockActual ?> / <?= $stockMax ?>
                        </span>
                        <span style="font-size: 12px; font-weight: 700; color: <?= $barColor ?>;">
                            <?= round($porcentaje) ?>%
                        </span>
                    </div>

                    <!-- Barra de progreso -->
                    <div class="stock-bar-container">
                        <div class="stock-bar-fill" style="width: <?= $porcentaje ?>%; background: <?= $barColor ?>;"></div>
                    </div>

                    <!-- Estado y acciones -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 11px; color: var(--text-secondary);">Stock Mínimo:</span>
                            <span style="font-size: 12px; font-weight: 600;"><?= $stockMinimo ?></span>
                        </div>
                        <span class="stock-badge" style="background: <?= $estadoBg ?>; color: <?= $estadoColor ?>;">
                            <?= $estadoTexto ?>
                        </span>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="product-actions">
                    <a href="index.php?controller=Productos&action=edit&id=<?= $p['id'] ?>" class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button onclick="confirmDelete(<?= $p['id'] ?>, '<?= addslashes($p['sku']) ?>')"
                        class="btn-action btn-delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal Crear Producto -->
<div id="modalProducto" class="modal-overlay">
    <div class="modal-content">
        <h3 style="margin-bottom: 20px;">Nuevo Producto</h3>
        <form action="index.php?controller=Productos&action=create" method="POST">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label class="form-label">SKU / Código</label>
                        <input type="text" name="sku" required class="form-input">
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Precio Venta</label>
                        <input type="number" step="0.01" name="precio_venta" required class="form-input">
                    </div>
                </div>

                <div>
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" required rows="3" class="form-input"></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label class="form-label">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" value="10" required class="form-input">
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">URL de Imagen (opcional)</label>
                        <input type="text" name="imagen_url" placeholder="https://..." class="form-input">
                    </div>
                </div>

                <!-- Toggle switch for Pedimento -->
                <div class="pedimento-toggle">
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
                    <button type="submit" class="btn btn-primary">Registrar Producto</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Grid de productos */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* Tarjeta de producto */
    .product-card {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 16px;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(41, 56, 135, 0.15);
    }

    /* Badge de pedimento */
    .pedimento-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #3b82f6;
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Imagen del producto */
    .product-image {
        width: 100%;
        height: 180px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-placeholder {
        font-size: 48px;
        color: var(--text-secondary);
        opacity: 0.3;
    }

    /* Info del producto */
    .product-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .product-sku {
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        color: var(--accent-color);
    }

    .product-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1.3;
        min-height: 36px;
    }

    .product-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: 4px;
    }

    /* Stock info */
    .stock-info {
        padding-top: 12px;
        border-top: 1px solid var(--glass-border);
    }

    .stock-bar-container {
        width: 100%;
        height: 8px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    .stock-bar-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    .stock-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
    }

    /* Acciones */
    .product-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .btn-action {
        flex: 1;
        padding: 8px 12px;
        border-radius: 8px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-family: 'Outfit';
    }

    .btn-edit {
        background: var(--accent-color);
        color: white;
    }

    .btn-edit:hover {
        filter: brightness(1.1);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        flex: 0;
        padding: 8px 12px;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(5px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 30px;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .form-label {
        display: block;
        font-size: 12px;
        margin-bottom: 5px;
        color: var(--text-secondary);
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-family: 'Outfit';
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

<script>
    // Modal functions
    function openModal() {
        document.getElementById('modalProducto').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalProducto').style.display = 'none';
    }

    // Búsqueda en tiempo real
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function (e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        if (query.length === 0) {
            location.reload();
            return;
        }

        searchTimeout = setTimeout(() => {
            // Aquí podrías implementar búsqueda AJAX
            // Por ahora, filtrado simple del lado del cliente
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const sku = card.querySelector('.product-sku').textContent.toLowerCase();
                const name = card.querySelector('.product-name').textContent.toLowerCase();
                const searchLower = query.toLowerCase();

                if (sku.includes(searchLower) || name.includes(searchLower)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }, 300);
    });

    // Confirmación de eliminación
    function confirmDelete(id, sku) {
        if (confirm(`¿Estás seguro de eliminar el producto ${sku}?\n\nEsta acción no se puede deshacer.`)) {
            window.location.href = `index.php?controller=Productos&action=delete&id=${id}`;
        }
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('modalProducto').addEventListener('click', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>