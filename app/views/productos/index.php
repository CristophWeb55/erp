<!-- Barra superior con búsqueda y filtros -->
<div class="header-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
    <div style="flex: 1; max-width: 500px; position: relative;">
        <i class="fas fa-search" style="position: absolute; left: 18px; top: 18px; color: var(--text-secondary);"></i>
        <input type="text" id="searchInput" placeholder="Buscar productos por SKU o nombre..." 
            style="width: 100%; padding: 15px 15px 15px 50px; border-radius: 15px; border: 1px solid var(--glass-border); background: var(--glass-bg); backdrop-filter: var(--glass-blur); font-family: 'Outfit'; font-size: 15px; box-shadow: var(--glass-shadow);">
    </div>
    
    <div style="display: flex; gap: 12px;">
        <button class="btn btn-primary" onclick="openModal()" style="display: flex; align-items: center; gap: 10px; padding: 12px 25px; border-radius: 15px; background: var(--accent-secondary); box-shadow: 0 8px 20px rgba(227, 81, 86, 0.3);">
            <i class="fas fa-plus"></i>
            <span>Nuevo Producto</span>
        </button>
    </div>
</div>

<h2 style="margin-bottom: 25px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px;">Catálogo de Productos</h2>

<!-- Grid de productos -->
<div class="products-grid" id="productsGrid">
    <?php if (empty($productos)): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; background: var(--glass-bg); border-radius: 30px; border: 1px dashed var(--glass-border);">
            <i class="fas fa-box-open" style="font-size: 60px; margin-bottom: 20px; color: var(--accent-color); opacity: 0.2;"></i>
            <h3 style="color: var(--text-primary); margin-bottom: 10px;">¡Ups! No hay productos</h3>
            <p style="color: var(--text-secondary);">Comienza agregando productos a tu catálogo para verlos aquí.</p>
        </div>
    <?php else: ?>
        <?php foreach ($productos as $p): 
            $stockActual = (int)$p['stock_actual'];
            $stockMinimo = (int)$p['stock_minimo'];
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
            <div class="product-card">
                <?php if ($p['requiere_pedimento']): ?>
                    <div class="pedimento-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Maneja Pedimento</span>
                    </div>
                <?php endif; ?>

                <div class="product-image">
                    <?php if ($p['imagen_url']): ?>
                        <img src="<?= $p['imagen_url'] ?>" alt="<?= $p['sku'] ?>">
                    <?php else: ?>
                        <div style="font-size: 50px; color: var(--accent-color); opacity: 0.2;">
                            <i class="fas fa-box"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-info">
                    <span class="product-sku"><?= $p['sku'] ?></span>
                    <h3 class="product-name"><?= $p['descripcion'] ?></h3>
                    <div class="product-price">$<?= number_format($p['precio_venta'], 2) ?></div>
                </div>

                <div class="stock-info">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 5px;">
                        <div style="font-size: 11px; color: var(--text-secondary); line-height: 1.2;">
                            Stock Disponible: <strong><?= $stockActual ?> / <?= $stockMax ?></strong><br>
                            Stock Mínimo: <?= $stockMinimo ?>
                        </div>
                        <div style="font-size: 12px; font-weight: 800; color: <?= $statusColor ?>;">
                            <?= round($porcentaje) ?>%
                        </div>
                    </div>
                    
                    <div class="stock-bar-container">
                        <div class="stock-bar-fill" style="width: <?= $porcentaje ?>%; background: <?= $statusColor ?>;"></div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                        <span class="stock-badge" style="background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                            <?= $statusText ?>
                        </span>
                    </div>
                </div>

                <div class="product-actions">
                    <a href="index.php?controller=Productos&action=edit&id=<?= $p['id'] ?>" class="btn-action btn-edit-product">
                        <i class="fas fa-edit"></i>
                        <span>Editar</span>
                    </a>
                    <button onclick="confirmDelete(<?= $p['id'] ?>, '<?= addslashes($p['sku']) ?>')" class="btn-action btn-delete-product">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal para nuevo producto -->
<div id="modalProducto" class="modal-overlay">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 style="font-weight: 800; color: var(--accent-color);">📦 Nuevo Producto</h2>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 24px; color: var(--text-secondary); cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="index.php?controller=Productos&action=create" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="grid-column: span 1;">
                    <label class="form-label">SKU / Código Único</label>
                    <input type="text" name="sku" placeholder="Ej: UR-MTR-001" required class="form-input">
                </div>
                <div style="grid-column: span 1;">
                    <label class="form-label">Precio de Venta</label>
                    <input type="number" step="0.01" name="precio_venta" placeholder="0.00" required class="form-input">
                </div>
                <div style="grid-column: span 2;">
                    <label class="form-label">Descripción Detallada</label>
                    <textarea name="descripcion" placeholder="Escribe el nombre y detalles del producto..." required rows="3" class="form-input" style="height: auto;"></textarea>
                </div>
                <div style="grid-column: span 1;">
                    <label class="form-label">Stock Mínimo (Alerta)</label>
                    <input type="number" name="stock_minimo" value="10" required class="form-input">
                </div>
                <div style="grid-column: span 1;">
                    <label class="form-label">URL de Imagen</label>
                    <input type="text" name="imagen_url" placeholder="https://ejemplo.com/imagen.jpg" class="form-input">
                </div>
                
                <div style="grid-column: span 2; background: #f1f5f9; padding: 20px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0; color: var(--text-primary);">¿Requiere Pedimento?</h4>
                        <p style="margin: 0; font-size: 11px; color: var(--text-secondary);">Activar para trazabilidad en importaciones.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="requiere_pedimento">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 35px;">
                <button type="button" class="btn" style="background: #e2e8f0; color: #475569;" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary" style="background: var(--accent-color); padding-left: 40px; padding-right: 40px;">Registrar SKU</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modalProducto').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalProducto').style.display = 'none';
}

// Búsqueda instantánea
document.getElementById('searchInput').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.product-card');
    
    cards.forEach(card => {
        const sku = card.querySelector('.product-sku').innerText.toLowerCase();
        const name = card.querySelector('.product-name').innerText.toLowerCase();
        
        if (sku.includes(query) || name.includes(query)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
});

function confirmDelete(id, sku) {
    if (confirm(`¿Estás seguro de eliminar el producto ${sku}?`)) {
        window.location.href = `index.php?controller=Productos&action=delete&id=${id}`;
    }
}

// Cerrar al click afuera
window.onclick = function(event) {
    const modal = document.getElementById('modalProducto');
    if (event.target == modal) {
        closeModal();
    }
}
</script>