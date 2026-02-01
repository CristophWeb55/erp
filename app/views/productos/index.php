<!-- Barra superior con búsqueda y filtros -->
<div class="header-actions"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
    <div style="flex: 1; max-width: 500px; position: relative;">
        <i class="fas fa-search" style="position: absolute; left: 18px; top: 18px; color: var(--text-secondary);"></i>
        <input type="text" id="searchInput" placeholder="Buscar productos por SKU o nombre..."
            style="width: 100%; padding: 15px 15px 15px 50px; border-radius: 15px; border: 1px solid var(--glass-border); background: var(--glass-bg); backdrop-filter: var(--glass-blur); font-family: 'Outfit'; font-size: 15px; box-shadow: var(--glass-shadow);">
    </div>

    <div style="display: flex; gap: 12px;">
        <button class="btn btn-primary" onclick="openModal()"
            style="display: flex; align-items: center; gap: 10px; padding: 12px 25px; border-radius: 15px; background: var(--accent-secondary); box-shadow: 0 8px 20px rgba(227, 81, 86, 0.3);">
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
            $stockActual = (int) $p['stock_actual'];
            $stockMinimo = (int) $p['stock_minimo'];
            $stockMax = $stockMinimo * 2;
            $porcentaje = ($stockMax > 0) ? min(100, ($stockActual / $stockMax) * 100) : 0;

            if ($stockActual <= 0) {
                $statusColor = '#ef4444'; $statusText = 'Sin Stock'; $statusBg = 'rgba(239, 68, 68, 0.1)';
            } elseif ($stockActual < $stockMinimo) {
                $statusColor = '#f59e0b'; $statusText = 'Stock Bajo'; $statusBg = 'rgba(245, 158, 11, 0.1)';
            } else {
                $statusColor = '#10b981'; $statusText = 'En Stock'; $statusBg = 'rgba(16, 185, 129, 0.1)';
            }
        ?>
            <div class="product-card">
                <?php if ($p['requiere_pedimento']): ?>
                    <div class="pedimento-badge"><i class="fas fa-shield-alt"></i> <span>Maneja Pedimento</span></div>
                <?php endif; ?>

                <div class="product-image">
                    <?php if ($p['imagen_url']): ?>
                        <img src="<?= $p['imagen_url'] ?>" alt="<?= $p['sku'] ?>">
                    <?php else: ?>
                        <div style="font-size: 50px; color: var(--accent-color); opacity: 0.2;"><i class="fas fa-box"></i></div>
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
                            Stock: <strong><?= $stockActual ?> / <?= $stockMax ?></strong>
                        </div>
                        <div style="font-size: 12px; font-weight: 800; color: <?= $statusColor ?>;"><?= round($porcentaje) ?>%</div>
                    </div>
                    <div class="stock-bar-container"><div class="stock-bar-fill" style="width: <?= $porcentaje ?>%; background: <?= $statusColor ?>;"></div></div>
                    <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                        <span class="stock-badge" style="background: <?= $statusBg ?>; color: <?= $statusColor ?>;"><?= $statusText ?></span>
                    </div>
                </div>

                <div class="product-actions">
                    <button onclick="openEditOverlay(<?= $p['id'] ?>)" class="btn-action btn-edit-product">
                        <i class="fas fa-edit"></i> <span>Editar</span>
                    </button>
                    <button onclick="confirmDelete(<?= $p['id'] ?>, '<?= addslashes($p['sku']) ?>')" class="btn-action btn-delete-product">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- 🎭 OVERLAY DE EDICIÓN PREMIUM -->
<div id="editOverlay" class="edit-overlay" onclick="closeEditOverlay(event)">
    <div class="edit-panel" onclick="event.stopPropagation()">
        <div id="editOverlayContent">
            <!-- Cargando... -->
        </div>
    </div>
</div>

<!-- Modal para nuevo producto -->
<div id="modalProducto" class="modal-overlay">
    <div class="modal-content" style="max-width: 800px; padding: 0; overflow: hidden; border-radius: 30px;">
        <div style="background: var(--accent-color); padding: 30px; color: white; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px;"><i class="fas fa-plus-circle"></i></div>
                <div>
                    <h2 style="margin: 0; font-weight: 800; font-size: 20px;">Registrar Nuevo Producto</h2>
                    <p style="margin: 0; font-size: 12px; opacity: 0.8;">Completa los detalles para añadirlo al catálogo.</p>
                </div>
            </div>
            <button onclick="closeModal()" style="background: rgba(255,255,255,0.1); border: none; width: 40px; height: 40px; border-radius: 50%; color: white; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <form action="index.php?controller=Productos&action=create" method="POST" style="padding: 35px;">
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px;">
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div><label class="form-label">SKU / Código</label><input type="text" name="sku" required class="form-input"></div>
                        <div><label class="form-label">Precio</label><input type="number" step="0.01" name="precio_venta" required class="form-input"></div>
                    </div>
                    <div><label class="form-label">Descripción</label><textarea name="descripcion" required rows="3" class="form-input"></textarea></div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div><label class="form-label">Stock Mínimo</label><input type="number" name="stock_minimo" value="10" required class="form-input"></div>
                        <div style="display: flex; align-items: flex-end;">
                            <div style="background: #f1f5f9; padding: 12px 15px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; width: 100%; border: 1px dashed #cbd5e1;">
                                <span style="font-size: 12px; font-weight: 600;">¿Pedimento?</span>
                                <label class="switch" style="transform: scale(0.8);"><input type="checkbox" name="requiere_pedimento"><span class="slider round"></span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div><label class="form-label">URL Imagen</label><input type="text" name="imagen_url" id="modalImageUrl" class="form-input"></div>
                    <div style="flex: 1; border-radius: 20px; border: 2px dashed #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden;"><img id="modalImagePreview" style="width: 100%; height: 100%; object-fit: contain; display: none;"><div id="modalPlaceholder" style="text-align: center; color: #94a3b8;"><i class="fas fa-image" style="font-size: 40px; margin-bottom: 10px; opacity: 0.3;"></i><p style="font-size: 11px;">Vista previa</p></div></div>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 35px; padding-top: 25px; border-top: 1px solid #f1f5f9;"><button type="button" class="btn" onclick="closeModal()">Cancelar</button><button type="submit" class="btn btn-primary">Registrar SKU</button></div>
        </form>
    </div>
</div>

<script>
    function openModal() { 
        const modal = document.getElementById('modalProducto');
        document.body.appendChild(modal); // Portal al body
        modal.style.display = 'flex'; 
        document.body.classList.add('no-scroll');
    }
    function closeModal() { 
        document.getElementById('modalProducto').style.display = 'none'; 
        document.body.classList.remove('no-scroll');
    }

    // Búsqueda instantánea
    document.getElementById('searchInput').addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.product-card').forEach(card => {
            const sku = card.querySelector('.product-sku').innerText.toLowerCase();
            const name = card.querySelector('.product-name').innerText.toLowerCase();
            card.style.display = (sku.includes(query) || name.includes(query)) ? 'flex' : 'none';
        });
    });

    function confirmDelete(id, sku) {
        if (confirm(`¿Estás seguro de eliminar el producto ${sku}?`)) {
            window.location.href = `index.php?controller=Productos&action=delete&id=${id}`;
        }
    }

    // 🎭 LÓGICA DE OVERLAY DE EDICIÓN PREMIUM
    async function openEditOverlay(productId) {
        const overlay = document.getElementById('editOverlay');
        const content = document.getElementById('editOverlayContent');
        
        document.body.appendChild(overlay); // Portal al body para el efecto Glass Lock
        overlay.classList.add('active');
        document.body.classList.add('no-scroll'); 
        
        content.innerHTML = '<div style="text-align: center; padding: 100px;"><i class="fas fa-circle-notch fa-spin" style="font-size: 60px; color: var(--accent-color);"></i><p style="margin-top: 20px; font-weight: 600;">Cargando información premium...</p></div>';

        try {
            const response = await fetch(`index.php?controller=Productos&action=getOne&id=${productId}`);
            const p = await response.json();

            const stockActual = parseInt(p.stock_actual) || 0;
            const stockMinimo = parseInt(p.stock_minimo) || 10;
            const status = stockActual <= 0 ? {c:'#ef4444', t:'Sin Stock'} : (stockActual < stockMinimo ? {c:'#f59e0b', t:'Stock Bajo'} : {c:'#10b981', t:'En Stock'});

            content.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
                    <div>
                        <h2 style="font-weight: 800; color: var(--text-primary); margin: 0; font-size: 26px; letter-spacing: -1px;">Editar Registro: ${p.sku}</h2>
                        <p style="color: var(--text-secondary); margin: 0; font-size: 14px;">Actualiza la información técnica y comercial del producto.</p>
                    </div>
                    <button onclick="closeEditOverlay(null, true)" style="background: #f1f5f9; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
                </div>
                <form action="index.php?controller=Productos&action=update" method="POST">
                    <input type="hidden" name="id" value="${p.id}">
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px;">
                        <div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                                <div><label class="form-label">SKU / CÓDIGO INTERNO</label><input type="text" name="sku" value="${p.sku}" required class="form-input" style="font-weight: 700;"></div>
                                <div><label class="form-label">PRECIO VENTA (MXN)</label><input type="number" step="0.01" name="precio_venta" value="${p.precio_venta}" required class="form-input" style="font-weight: 800; color: var(--accent-secondary);"></div>
                            </div>
                            <div style="margin-bottom: 25px;"><label class="form-label">DESCRIPCIÓN COMERCIAL</label><textarea name="descripcion" required rows="4" class="form-input" style="line-height: 1.6;">${p.descripcion}</textarea></div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; padding: 25px; border-radius: 25px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
                                <div><label class="form-label">STOCK MÍNIMO</label><input type="number" name="stock_minimo" value="${stockMinimo}" required class="form-input"></div>
                                <div><label class="form-label">ESTADO ACTUAL</label><div style="font-size: 24px; font-weight: 900; color: ${status.c}">${stockActual} <span style="font-size: 12px; color: #94a3b8; font-weight: 500;">unidades</span></div></div>
                            </div>

                            <!-- Control de Pedimento Re-incorporado -->
                            <div style="background: rgba(41, 56, 135, 0.05); padding: 22px; border-radius: 25px; border: 1px dashed var(--accent-color); display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div style="width: 45px; height: 45px; background: var(--accent-color); color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 15px; color: var(--text-primary);">Configuración de Pedimento</h4>
                                        <p style="margin: 0; font-size: 11px; color: var(--text-secondary);">Activar para trazabilidad aduanal obligatoria.</p>
                                    </div>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="requiere_pedimento" ${p.requiere_pedimento == 1 ? 'checked' : ''}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 25px;">
                            <div style="background: white; padding: 25px; border-radius: 30px; border: 1px solid #e2e8f0;">
                                <label class="form-label">URL DE IMAGEN</label><input type="text" name="imagen_url" value="${p.imagen_url || ''}" id="editImgUrl" class="form-input" style="margin-bottom: 15px;">
                                <div style="width: 100%; aspect-ratio: 1; border-radius: 20px; border: 1px dashed #cbd5e1; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8fafc;"><img id="editImgPreview" src="${p.imagen_url || ''}" style="width: 100%; height: 100%; object-fit: contain; display: ${p.imagen_url ? 'block' : 'none'}"><i id="editImgPlaceholder" class="fas fa-image" style="font-size: 50px; opacity: 0.1; display: ${p.imagen_url ? 'none' : 'block'}"></i></div>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; border-radius: 20px; font-weight: 800; font-size: 16px;"><i class="fas fa-save"></i> ACTUALIZAR REGISTRO</button>
                            <button type="button" onclick="closeEditOverlay(null, true)" class="btn" style="width: 100%; background: #f1f5f9; padding: 15px; border-radius: 15px; font-weight: 700;">CANCELAR</button>
                        </div>
                    </div>
                </form>
            `;

            document.getElementById('editImgUrl').addEventListener('input', e => {
                const img = document.getElementById('editImgPreview');
                const placeholder = document.getElementById('editImgPlaceholder');
                img.src = e.target.value;
                img.style.display = e.target.value ? 'block' : 'none';
                placeholder.style.display = e.target.value ? 'none' : 'block';
            });

        } catch (e) { console.error(e); closeEditOverlay(null, true); }
    }

    function closeEditOverlay(e, force = false) {
        if (force || (e && e.target.id === 'editOverlay')) {
            document.getElementById('editOverlay').classList.remove('active');
            document.body.classList.remove('no-scroll'); 
        }
    }
</script>