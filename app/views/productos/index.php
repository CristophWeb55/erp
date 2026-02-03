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

<h2 style="margin-bottom: 25px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px;">Catálogo de
    Productos</h2>

<!-- Grid de productos -->
<div class="products-grid" id="productsGrid">
    <?php if (empty($productos)): ?>
        <div
            style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; background: var(--glass-bg); border-radius: 30px; border: 1px dashed var(--glass-border);">
            <i class="fas fa-box-open"
                style="font-size: 60px; margin-bottom: 20px; color: var(--accent-color); opacity: 0.2;"></i>
            <h3 style="color: var(--text-primary); margin-bottom: 10px;">¡Ups! No hay productos</h3>
            <p style="color: var(--text-secondary);">Comienza agregando productos a tu catálogo para verlos aquí.</p>
        </div>
    <?php else: ?>
        <?php foreach ($productos as $p):
            $stockActual = (int) $p['stock_actual'];
            $stockMinimo = (int) $p['stock_minimo'];

            // Lógica de barra dinámica: Stock Base (lotes activos) vs Mínimo
            // Esto permite ver el consumo real (baja del 100%) incluso si estamos arriba del mínimo
            $stockBase = (int) ($p['stock_base'] ?? 0);
            $referencia = max($stockBase, ($stockMinimo > 0 ? $stockMinimo * 2 : 100));

            $porcentaje = ($referencia > 0) ? min(100, ($stockActual / $referencia) * 100) : 0;

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
                            Stock: <strong><?= $stockActual ?> / <?= ($stockMinimo > 0 ? $stockMinimo : '-') ?></strong>
                        </div>
                        <div style="font-size: 12px; font-weight: 800; color: <?= $statusColor ?>;"><?= round($porcentaje) ?>%
                        </div>
                    </div>
                    <div class="stock-bar-container">
                        <div class="stock-bar-fill" style="width: <?= $porcentaje ?>%; background: <?= $statusColor ?>;"></div>
                    </div>
                    <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                        <span class="stock-badge"
                            style="background: <?= $statusBg ?>; color: <?= $statusColor ?>;"><?= $statusText ?></span>
                    </div>
                </div>

                <div class="product-actions">
                    <button onclick="openEditOverlay(<?= $p['id'] ?>)" class="btn-action btn-edit-product">
                        <i class="fas fa-edit"></i> <span>Editar</span>
                    </button>
                    <button onclick="confirmDelete(<?= $p['id'] ?>, '<?= addslashes($p['sku']) ?>')"
                        class="btn-action btn-delete-product">
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

<!-- ⚠️ MODAL DE CONFIRMACIÓN DE CIERRE -->
<div id="confirmCloseOverlay" class="edit-overlay" style="z-index: 30000;">
    <div class="edit-panel" style="max-width: 400px; padding: 30px; text-align: center; border-radius: 30px;"
        onclick="event.stopPropagation()">
        <div
            style="width: 70px; height: 70px; background: rgba(227, 81, 86, 0.1); color: var(--accent-secondary); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 style="font-weight: 800; color: var(--text-primary); margin-bottom: 10px; font-size: 20px;">¿Descartar
            cambios?</h3>
        <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 25px; line-height: 1.6;">Si cierras
            ahora, se perderá cualquier información que hayas ingresado en el formulario. ¿Estás seguro que deseas
            salir?
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button type="button" onclick="hideConfirmModal()" class="btn"
                style="background: #f1f5f9; color: var(--text-primary); border: 1px solid #e2e8f0; font-weight: 700; border-radius: 12px; height: 45px; cursor: pointer;">Seguir
                Editando</button>
            <button type="button" onclick="confirmCloseAction()" class="btn"
                style="background: var(--accent-secondary); color: white; border: none; font-weight: 800; border-radius: 12px; height: 45px; cursor: pointer; box-shadow: 0 8px 20px rgba(227, 81, 86, 0.2);">Sí,
                Salir</button>
        </div>
    </div>
</div>

<!-- Modal Confirmar Eliminación Premium -->
<div id="modalDelete" class="edit-overlay" onclick="closeDeleteModal(event)">
    <div class="edit-panel" style="max-width: 400px; text-align: center;" onclick="event.stopPropagation()">
        <div
            style="width: 70px; height: 70px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px;">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3 style="font-weight: 800; color: var(--text-primary); margin-bottom: 10px;">¿Eliminar Producto?</h3>
        <p id="deleteProductName" style="color: var(--text-secondary); font-size: 14px; margin-bottom: 25px;">Esta
            acción borrará el producto permanentemente. ¿Estás seguro?</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button onclick="closeDeleteModal()" class="btn"
                style="background: #f1f5f9; color: var(--text-primary); border: 1px solid #e2e8f0; font-weight: 700; border-radius: 12px; height: 45px; cursor: pointer;">Cancelar</button>
            <a id="btnConfirmDelete" href="#" class="btn"
                style="background: #ef4444; color: white; border: none; font-weight: 800; text-decoration: none; display: flex; align-items: center; justify-content: center; border-radius: 12px; height: 45px; box-shadow: 0 8px 20px rgba(239, 68, 68, 0.2);">Sí,
                Eliminar</a>
        </div>
    </div>
</div>

<!-- Modal para nuevo producto -->
<div id="modalProducto" class="edit-overlay" onclick="closeModal(event)">
    <div class="edit-panel" style="max-width: 850px; padding: 35px;" onclick="event.stopPropagation()">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div
                    style="width: 50px; height: 50px; background: rgba(41, 56, 135, 0.1); color: var(--accent-color); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div>
                    <h2
                        style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 24px; letter-spacing: -1px;">
                        Registrar Nuevo Producto</h2>
                    <p style="margin: 5px 0 0 0; color: var(--text-secondary); font-size: 13px;">Completa los detalles
                        técnicos para añadirlo al catálogo oficial.</p>
                </div>
            </div>
            <button onclick="closeModal()"
                style="background: #f1f5f9; border: none; width: 40px; height: 40px; border-radius: 50%; color: var(--text-primary); cursor: pointer; transition: all 0.2s;"><i
                    class="fas fa-times"></i></button>
        </div>

        <form action="index.php?controller=Productos&action=create" method="POST" id="productForm"
            enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1.4fr 1fr; gap: 30px;">
                <!-- Columna Izquierda: Datos Técnicos -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div
                        style="background: rgba(41, 56, 135, 0.02); padding: 20px; border-radius: 20px; border: 1px solid var(--glass-border);">
                        <h3
                            style="margin: 0 0 15px 0; font-size: 15px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-info-circle" style="color: var(--accent-color);"></i> Información General
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label class="form-label" style="font-size: 11px; letter-spacing: 0.5px;">SKU /
                                    CÓDIGO</label>
                                <input type="text" name="sku" required class="form-input" placeholder="Ej. SKU-001"
                                    style="font-weight: 700;">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 11px; letter-spacing: 0.5px;">PRECIO
                                    VENTA</label>
                                <div style="position: relative;">
                                    <span
                                        style="position: absolute; left: 12px; top: 10px; font-weight: 700; color: var(--text-secondary);">$</span>
                                    <input type="number" step="0.01" name="precio_venta" required class="form-input"
                                        style="padding-left: 25px; font-weight: 800; color: var(--accent-secondary);">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 11px; letter-spacing: 0.5px;">NOMBRE DEL
                                PRODUCTO</label>
                            <textarea name="descripcion" required rows="3" class="form-input"
                                placeholder="Nombre comercial y detalles..." style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div
                        style="background: rgba(41, 56, 135, 0.02); padding: 20px; border-radius: 20px; border: 1px solid var(--glass-border);">
                        <h3
                            style="margin: 0 0 15px 0; font-size: 15px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-layer-group" style="color: var(--accent-color);"></i> Control de Inventario
                        </h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                            <div>
                                <label class="form-label" style="font-size: 11px; letter-spacing: 0.5px;">STOCK
                                    MÍNIMO</label>
                                <input type="number" name="stock_minimo" value="10" required class="form-input"
                                    style="font-weight: 600;">
                            </div>
                            <div>
                                <label class="form-label" style="font-size: 11px; letter-spacing: 0.5px;">STOCK
                                    INICIAL</label>
                                <input type="number" name="stock_inicial" value="0" class="form-input"
                                    style="font-weight: 800; color: var(--accent-color); background: white;">
                            </div>
                        </div>

                        <div
                            style="background: white; padding: 15px; border-radius: 15px; border: 1px dashed var(--accent-color); display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div
                                    style="width: 35px; height: 35px; background: rgba(41, 56, 135, 0.1); color: var(--accent-color); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <span
                                        style="font-size: 13px; font-weight: 700; color: var(--text-primary); display: block;">Maneja
                                        Pedimento</span>
                                    <span style="font-size: 10px; color: var(--text-secondary);">Requiere trazabilidad
                                        aduanal</span>
                                </div>
                            </div>
                            <label class="switch" style="transform: scale(0.8);">
                                <input type="checkbox" name="requiere_pedimento">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Multimedia -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div
                        style="background: white; padding: 20px; border-radius: 24px; border: 1px solid #e2e8f0; height: 100%; display: flex; flex-direction: column; box-shadow: 0 10px 25px rgba(0,0,0,0.02);">
                        <label class="form-label"
                            style="font-size: 11px; letter-spacing: 0.5px; margin-bottom: 12px;">IMAGEN DEL
                            PRODUCTO</label>

                        <input type="file" name="imagen" id="modalImageInput" class="form-input" accept="image/*"
                            style="margin-bottom: 15px; padding: 10px;">

                        <div
                            style="flex: 1; border-radius: 20px; border: 2px dashed #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                            <img id="modalImagePreview"
                                style="width: 100%; height: 100%; object-fit: contain; display: none;">
                            <div id="modalPlaceholder" style="text-align: center; color: #94a3b8;">
                                <i class="fas fa-cloud-upload-alt"
                                    style="font-size: 50px; margin-bottom: 15px; opacity: 0.2;"></i>
                                <p style="font-size: 12px; font-weight: 600;">Subir imagen</p>
                                <p style="font-size: 10px; opacity: 0.7;">Formatos: JPG, PNG, WEBP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Acciones -->
            <div
                style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 35px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                <button type="button" class="btn" onclick="closeModal(null, true)"
                    style="background: #f1f5f9; color: var(--text-primary); border: 1px solid #e2e8f0; font-weight: 700; padding: 12px 30px; border-radius: 12px;">Cancelar</button>
                <button type="submit" class="btn btn-primary"
                    style="background: var(--accent-secondary); color: white; border: none; font-weight: 800; padding: 12px 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(227, 81, 86, 0.25);">
                    <i class="fas fa-save" style="margin-right: 8px;"></i> Registrar SKU
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let activeOverlayId = null;

    function openModal() {
        const modal = document.getElementById('modalProducto');
        document.body.appendChild(modal); // Portal al body
        modal.classList.add('active');
        document.body.classList.add('no-scroll');
    }

    function closeModal(e, force = false) {
        if (force) {
            execCloseModal('modalProducto');
            return;
        }

        const isClickOutside = e && e.target.id === 'modalProducto';
        const isXButton = !e;

        if (isClickOutside || isXButton) {
            activeOverlayId = 'modalProducto';
            showConfirmModal();
        }
    }

    function showConfirmModal() {
        const overlay = document.getElementById('confirmCloseOverlay');
        document.body.appendChild(overlay);
        overlay.classList.add('active');
    }

    function hideConfirmModal() {
        document.getElementById('confirmCloseOverlay').classList.remove('active');
    }

    function confirmCloseAction() {
        hideConfirmModal();
        if (activeOverlayId) {
            execCloseModal(activeOverlayId);
        }
    }

    function execCloseModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.classList.remove('no-scroll');
        activeOverlayId = null;
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

    // Vista previa de imagen en modal nuevo producto
    document.getElementById('modalImageInput')?.addEventListener('change', function (e) {
        const preview = document.getElementById('modalImagePreview');
        const placeholder = document.getElementById('modalPlaceholder');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    });

    function confirmDelete(id, sku) {
        const modal = document.getElementById('modalDelete');
        const btnConfirm = document.getElementById('btnConfirmDelete');
        const text = document.getElementById('deleteProductName');

        text.innerHTML = `¿Estás seguro de eliminar el producto <strong>${sku}</strong>? Esta acción no se puede deshacer.`;
        btnConfirm.href = `index.php?controller=Productos&action=delete&id=${id}`;

        document.body.appendChild(modal);
        modal.classList.add('active');
        document.body.classList.add('no-scroll');
    }

    function closeDeleteModal(e) {
        if (!e || e.target.id === 'modalDelete' || e.type === 'click') {
            document.getElementById('modalDelete').classList.remove('active');
            document.body.classList.remove('no-scroll');
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
            const status = stockActual <= 0 ? { c: '#ef4444', t: 'Sin Stock' } : (stockActual < stockMinimo ? { c: '#f59e0b', t: 'Stock Bajo' } : { c: '#10b981', t: 'En Stock' });

            content.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 40px;">
                    <div>
                        <h2 style="font-weight: 800; color: var(--text-primary); margin: 0; font-size: 26px; letter-spacing: -1px;">Editar Registro: ${p.sku}</h2>
                        <p style="color: var(--text-secondary); margin: 0; font-size: 14px;">Actualiza la información técnica y comercial del producto.</p>
                    </div>
                    <button onclick="closeEditOverlay()" style="background: #f1f5f9; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
                </div>
                <form action="index.php?controller=Productos&action=update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="${p.id}">
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px;">
                        <div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                                <div><label class="form-label">SKU / CÓDIGO INTERNO</label><input type="text" name="sku" value="${p.sku}" required class="form-input" style="font-weight: 700;"></div>
                                <div><label class="form-label">PRECIO VENTA (MXN)</label><input type="number" step="0.01" name="precio_venta" value="${p.precio_venta}" required class="form-input" style="font-weight: 800; color: var(--accent-secondary);"></div>
                            </div>
                            <div style="margin-bottom: 25px;"><label class="form-label">NOMBRE DEL PRODUCTO</label><textarea name="descripcion" required rows="4" class="form-input" style="line-height: 1.6;">${p.descripcion}</textarea></div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; padding: 25px; border-radius: 25px; border: 1px solid #e2e8f0; margin-bottom: 25px;">
                                <div><label class="form-label">STOCK MÍNIMO</label><input type="number" name="stock_minimo" value="${stockMinimo}" required class="form-input"></div>
                                <div><label class="form-label">STOCK ACTUAL (AJUSTE)</label><input type="number" name="stock_actual" value="${stockActual}" class="form-input" style="font-weight: 900; color: ${status.c}; font-size: 20px;"></div>
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
                                <label class="form-label">IMAGEN DEL PRODUCTO</label>
                                <input type="file" name="imagen" id="editImgInput" class="form-input" accept="image/*" style="margin-bottom: 15px; padding: 10px;">
                                
                                <div style="width: 100%; aspect-ratio: 1; border-radius: 20px; border: 1px dashed #cbd5e1; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8fafc;">
                                    <img id="editImgPreview" src="${p.imagen_url || ''}" style="width: 100%; height: 100%; object-fit: contain; display: ${p.imagen_url ? 'block' : 'none'}">
                                    <i id="editImgPlaceholder" class="fas fa-cloud-upload-alt" style="font-size: 50px; opacity: 0.1; display: ${p.imagen_url ? 'none' : 'block'}"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 20px; border-radius: 20px; font-weight: 800; font-size: 16px;"><i class="fas fa-save"></i> ACTUALIZAR REGISTRO</button>
                            <button type="button" onclick="closeEditOverlay(null, true)" class="btn" style="width: 100%; background: #f1f5f9; padding: 15px; border-radius: 15px; font-weight: 700;">CANCELAR</button>
                        </div>
                    </div>
                </form>
            `;

            document.getElementById('editImgInput').addEventListener('change', e => {
                const img = document.getElementById('editImgPreview');
                const placeholder = document.getElementById('editImgPlaceholder');
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        img.src = event.target.result;
                        img.style.display = 'block';
                        placeholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });

        } catch (e) { console.error(e); closeEditOverlay(null, true); }
    }

    function closeEditOverlay(e, force = false) {
        if (force) {
            execCloseModal('editOverlay');
            return;
        }

        const isClickOutside = e && e.target.id === 'editOverlay';
        const isXButton = !e;

        if (isClickOutside || isXButton) {
            activeOverlayId = 'editOverlay';
            showConfirmModal();
        }
    }
</script>