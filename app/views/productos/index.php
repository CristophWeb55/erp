<div class="module-perspective" id="modulePerspective">
    <div class="module-flipper">
        <!-- VISTA FRONTAL: CATÁLOGO -->
        <div class="view-front">
            <!-- Barra superior con búsqueda y filtros -->
            <div class="header-actions"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
                <div style="flex: 1; max-width: 500px; position: relative;">
                    <i class="fas fa-search"
                        style="position: absolute; left: 18px; top: 18px; color: var(--text-secondary);"></i>
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

            <h2 style="margin-bottom: 25px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px;">
                Catálogo de
                Productos</h2>

            <!-- Grid de productos -->
            <div class="products-grid" id="productsGrid">
                <?php if (empty($productos)): ?>
                    <div
                        style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; background: var(--glass-bg); border-radius: 30px; border: 1px dashed var(--glass-border);">
                        <i class="fas fa-box-open"
                            style="font-size: 60px; margin-bottom: 20px; color: var(--accent-color); opacity: 0.2;"></i>
                        <h3 style="color: var(--text-primary); margin-bottom: 10px;">¡Ups! No hay productos</h3>
                        <p style="color: var(--text-secondary);">Comienza agregando productos a tu catálogo para verlos
                            aquí.
                        </p>
                    </div>
                <?php else: ?>
                    <?php foreach ($productos as $p):
                        $stockActual = (int) $p['stock_actual'];
                        $stockMinimo = (int) $p['stock_minimo'];
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
                                <div
                                    style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 5px;">
                                    <div style="font-size: 11px; color: var(--text-secondary); line-height: 1.2;">
                                        Stock Disponible: <strong><?= $stockActual ?> / <?= $stockMax ?></strong><br>
                                        Stock Mínimo: <?= $stockMinimo ?>
                                    </div>
                                    <div style="font-size: 12px; font-weight: 800; color: <?= $statusColor ?>;">
                                        <?= round($porcentaje) ?>%
                                    </div>
                                </div>

                                <div class="stock-bar-container">
                                    <div class="stock-bar-fill"
                                        style="width: <?= $porcentaje ?>%; background: <?= $statusColor ?>;">
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: flex-end; margin-top: 5px;">
                                    <span class="stock-badge" style="background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                        <?= $statusText ?>
                                    </span>
                                </div>
                            </div>

                            <div class="product-actions">
                                <button onclick="triggerFlip(<?= $p['id'] ?>)" class="btn-action btn-edit-product">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
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
        </div>

        <!-- VISTA TRASERA: EDITOR PREMIUM -->
        <div class="view-back" id="editorView">
            <div id="editorContent">
                <!-- Se llenará dinámicamente vía JS -->
                <div style="text-align: center; padding: 100px;">
                    <i class="fas fa-circle-notch fa-spin" style="font-size: 50px; color: var(--accent-color);"></i>
                    <p style="margin-top: 20px; color: var(--text-secondary);">Cargando editor...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nuevo producto -->
<div id="modalProducto" class="modal-overlay">
    <div class="modal-content" style="max-width: 800px; padding: 0; overflow: hidden; border-radius: 30px;">
        <div
            style="background: var(--accent-color); padding: 30px; color: white; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div
                    style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div>
                    <h2 style="margin: 0; font-weight: 800; font-size: 20px;">Registrar Nuevo Producto</h2>
                    <p style="margin: 0; font-size: 12px; opacity: 0.8;">Completa los detalles para añadirlo al
                        catálogo.</p>
                </div>
            </div>
            <button onclick="closeModal()"
                style="background: rgba(255,255,255,0.1); border: none; width: 40px; height: 40px; border-radius: 50%; color: white; cursor: pointer; transition: all 0.3s ease;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="index.php?controller=Productos&action=create" method="POST" style="padding: 35px;">
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 30px;">
                <!-- Columna Datos -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label class="form-label">SKU / Código Único</label>
                            <input type="text" name="sku" placeholder="Ej: UR-MTR-001" required class="form-input"
                                style="font-family: 'Inter', monospace; font-weight: 600;">
                        </div>
                        <div>
                            <label class="form-label">Precio de Venta</label>
                            <input type="number" step="0.01" name="precio_venta" placeholder="0.00" required
                                class="form-input" style="font-weight: 700;">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Descripción del Producto</label>
                        <textarea name="descripcion" placeholder="Nombre y detalles técnicos..." required rows="3"
                            class="form-input" style="height: auto; resize: none;"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label class="form-label">Stock Mínimo (Alerta)</label>
                            <input type="number" name="stock_minimo" value="10" required class="form-input">
                        </div>
                        <div style="display: flex; align-items: flex-end;">
                            <div
                                style="background: #f1f5f9; padding: 12px 15px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; width: 100%; border: 1px dashed #cbd5e1;">
                                <span
                                    style="font-size: 12px; font-weight: 600; color: var(--text-secondary);">¿Pedimento?</span>
                                <label class="switch" style="transform: scale(0.8);">
                                    <input type="checkbox" name="requiere_pedimento">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Media -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label class="form-label">URL de Imagen</label>
                        <input type="text" name="imagen_url" id="modalImageUrl" placeholder="https://..."
                            class="form-input">
                    </div>

                    <div
                        style="flex: 1; border-radius: 20px; border: 2px dashed #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                        <img id="modalImagePreview" src="" alt="Vista previa"
                            style="width: 100%; height: 100%; object-fit: contain; display: none;">
                        <div id="modalPlaceholder" style="text-align: center; color: #94a3b8;">
                            <i class="fas fa-image" style="font-size: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                            <p style="font-size: 11px; font-weight: 600;">Vista previa de imagen</p>
                        </div>
                    </div>
                </div>
            </div>

            <div
                style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 35px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                <button type="button" class="btn"
                    style="background: #f1f5f9; color: #475569; padding: 12px 25px; border-radius: 12px; font-weight: 600;"
                    onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary"
                    style="background: var(--accent-color); padding: 12px 40px; border-radius: 12px; font-weight: 800; box-shadow: 0 8px 20px rgba(41, 56, 135, 0.2);">
                    Finalizar Registro
                </button>
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
    document.getElementById('searchInput').addEventListener('input', function (e) {
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
    window.onclick = function (event) {
        const modal = document.getElementById('modalProducto');
        if (event.target == modal) {
            closeModal();
        }
    }

    // Vista previa de imagen en Modal
    document.getElementById('modalImageUrl').addEventListener('input', function (e) {
        const url = e.target.value;
        const preview = document.getElementById('modalImagePreview');
        const placeholder = document.getElementById('modalPlaceholder');

        if (url) {
            preview.src = url;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    });

    // 🔄 Lógica de Flipping para el Editor
    async function triggerFlip(productId) {
        const perspective = document.getElementById('modulePerspective');
        const editorContent = document.getElementById('editorContent');

        // 1. Mostrar carga
        editorContent.innerHTML = `
            <div style="text-align: center; padding: 150px; background: var(--glass-bg); border-radius: 30px; border: 1px solid var(--glass-border);">
                <i class="fas fa-circle-notch fa-spin" style="font-size: 60px; color: var(--accent-color);"></i>
                <p style="margin-top: 25px; font-weight: 600; color: var(--text-primary);">Preparando Editor de Producto...</p>
            </div>
        `;

        // 2. Girar la página
        perspective.classList.add('is-flipped');

        try {
            // 3. Obtener datos mediante AJAX
            const response = await fetch(`index.php?controller=Productos&action=getOne&id=${productId}`);
            const p = await response.json();

            // 4. Renderizar el editor directamente aquí
            const stockActual = parseInt(p.stock_actual) || 0;
            const stockMinimo = parseInt(p.stock_minimo) || 10;
            const stockMax = stockMinimo * 2;
            const porcentaje = stockMax > 0 ? Math.min(100, (stockActual / stockMax) * 100) : 0;

            let statusColor, statusText, statusBg;
            if (stockActual <= 0) {
                statusColor = '#ef4444'; statusText = 'Sin Stock'; statusBg = 'rgba(239, 68, 68, 0.1)';
            } else if (stockActual < stockMinimo) {
                statusColor = '#f59e0b'; statusText = 'Stock Bajo'; statusBg = 'rgba(245, 158, 11, 0.1)';
            } else {
                statusColor = '#10b981'; statusText = 'En Stock'; statusBg = 'rgba(16, 185, 129, 0.1)';
            }

            // Construir el HTML del editor interior (basado en el diseño que te gustó)
            editorContent.innerHTML = `
                <div style="max-width: 900px; margin: 0 auto; padding-bottom: 50px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <button onclick="reverseFlip()" style="width: 40px; height: 40px; border: none; display: flex; align-items: center; justify-content: center; background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 12px; color: var(--text-primary); cursor: pointer; transition: all 0.3s ease;">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h2 style="font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; margin: 0;">Editar Producto</h2>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px; padding: 8px 15px; background: ${statusBg}; border-radius: 12px; border: 1px solid ${statusColor}20;">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: ${statusColor};"></div>
                            <span style="font-size: 13px; font-weight: 800; color: ${statusColor}; text-transform: uppercase;">${statusText}</span>
                        </div>
                    </div>

                    <form action="index.php?controller=Productos&action=update" method="POST">
                        <input type="hidden" name="id" value="${p.id}">
                        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px;">
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="card" style="padding: 25px; border-radius: 24px; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border);">
                                    <h3 style="font-size: 14px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 20px;">Información General</h3>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                        <div>
                                            <label class="form-label">SKU / Código</label>
                                            <input type="text" name="sku" value="${p.sku}" required class="form-input" style="font-family: 'Inter', monospace; font-weight: 600;">
                                        </div>
                                        <div>
                                            <label class="form-label">Precio de Venta</label>
                                            <div style="position: relative;">
                                                <span style="position: absolute; left: 15px; top: 12px; color: var(--text-secondary); font-weight: 600;">$</span>
                                                <input type="number" step="0.01" name="precio_venta" value="${p.precio_venta}" required class="form-input" style="padding-left: 30px; font-weight: 700; color: var(--accent-color);">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 20px;">
                                        <label class="form-label">Descripción del Producto</label>
                                        <textarea name="descripcion" required rows="4" class="form-input" style="height: auto; font-size: 15px; line-height: 1.5;">${p.descripcion}</textarea>
                                    </div>
                                    <div class="pedimento-toggle-field" style="background: rgba(41, 56, 135, 0.05); padding: 20px; border-radius: 18px; display: flex; justify-content: space-between; align-items: center; border: 1px dashed var(--accent-color)20;">
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 45px; height: 45px; border-radius: 12px; background: var(--accent-color); color: white; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                                <i class="fas fa-shield-alt"></i>
                                            </div>
                                            <div>
                                                <h4 style="margin: 0; color: var(--text-primary); font-size: 15px;">Control de Pedimento</h4>
                                                <p style="margin: 0; font-size: 11px; color: var(--text-secondary);">¿Requiere trazabilidad aduanal?</p>
                                            </div>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox" name="requiere_pedimento" ${p.requiere_pedimento == 1 ? 'checked' : ''}>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card" style="padding: 25px; border-radius: 24px; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border);">
                                    <h3 style="font-size: 14px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 20px;">Inventario y Alertas</h3>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                                        <div>
                                            <label class="form-label">Configurar Stock Mínimo</label>
                                            <input type="number" name="stock_minimo" value="${stockMinimo}" required class="form-input" style="font-weight: 700;">
                                        </div>
                                        <div style="background: rgba(255,255,255,0.4); padding: 15px; border-radius: 18px; border: 1px solid var(--glass-border);">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                <span style="font-size: 12px; font-weight: 600; color: var(--text-secondary);">Stock Real</span>
                                                <span style="font-size: 18px; font-weight: 800; color: var(--text-primary);">${stockActual}</span>
                                            </div>
                                            <div class="stock-bar-container" style="height: 8px; margin-bottom: 5px;">
                                                <div class="stock-bar-fill" style="width: ${porcentaje}%; background: ${statusColor};"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 20px;">
                                <div class="card" style="padding: 25px; border-radius: 24px; background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border);">
                                    <h3 style="font-size: 14px; text-transform: uppercase; color: var(--text-secondary); letter-spacing: 1px; margin-bottom: 20px;">Imagen</h3>
                                    <input type="text" name="imagen_url" value="${p.imagen_url || ''}" id="editorImageUrl" placeholder="URL..." class="form-input" style="margin-bottom: 15px;">
                                    <div style="width: 100%; aspect-ratio: 1; border-radius: 20px; background: white; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                        <img id="editorImagePreview" src="${p.imagen_url || ''}" style="width: 100%; height: 100%; object-fit: contain; display: ${p.imagen_url ? 'block' : 'none'}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; border-radius: 18px; font-weight: 800; font-size: 16px;">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <button type="button" onclick="reverseFlip()" class="btn" style="width: 100%; background: #e2e8f0; color: #475569; padding: 15px; border-radius: 18px; font-weight: 700; border: none; cursor: pointer;">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            `;

            // Re-vincular eventos para el editor dinámico
            document.getElementById('editorImageUrl').addEventListener('input', function (e) {
                const img = document.getElementById('editorImagePreview');
                img.src = e.target.value;
                img.style.display = e.target.value ? 'block' : 'none';
            });

        } catch (error) {
            console.error("Error cargando producto:", error);
            reverseFlip();
            alert("No se pudo cargar la información del producto.");
        }
    }

    function reverseFlip() {
        document.getElementById('modulePerspective').classList.remove('is-flipped');
    }
</script>