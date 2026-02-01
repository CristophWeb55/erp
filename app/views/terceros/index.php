<!-- 🔝 CABECERA Y BUSCADOR (Imagen 2) -->
<div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2
                style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 24px; letter-spacing: -0.5px;">
                Gestión de Terceros</h2>
            <p style="margin: 5px 0 0 0; color: var(--text-secondary); font-size: 13px;">Administra tus clientes,
                proveedores y contactos comerciales.</p>
        </div>
        <button class="btn btn-primary" onclick="openModal()"
            style="background: var(--accent-secondary); border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(227, 81, 86, 0.2);">
            <i class="fas fa-plus"></i> Nuevo Tercero
        </button>
    </div>

    <!-- Barra de Búsqueda Glassmorphism -->
    <div style="position: relative; max-width: 500px;">
        <i class="fas fa-search"
            style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 16px;"></i>
        <input type="text" id="terceroSearch" placeholder="Buscar por nombre, RFC o ID..."
            style="width: 100%; padding: 15px 15px 15px 50px; border-radius: 50px; border: 1px solid var(--glass-border); background: var(--glass-bg); backdrop-filter: var(--glass-blur); font-size: 14px; font-weight: 500; outline: none; transition: all 0.3s ease; box-shadow: var(--glass-shadow);">
    </div>
</div>

<!-- 📦 CUADRÍCULA DE TARJETAS (Imagen 2) -->
<div id="tercerosGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
    <?php if (empty($terceros)): ?>
        <div
            style="grid-column: 1 / -1; text-align: center; padding: 60px; background: var(--glass-bg); border-radius: 24px; border: 1px dashed var(--glass-border);">
            <i class="fas fa-users"
                style="font-size: 40px; color: var(--text-secondary); opacity: 0.3; margin-bottom: 15px;"></i>
            <p style="color: var(--text-secondary); font-weight: 600;">No se encontraron registros de terceros.</p>
        </div>
    <?php else: ?>
        <?php foreach ($terceros as $t):
            $initials = strtoupper(substr($t['nombre_razon_social'], 0, 1));
            $typeColor = ($t['tipo'] == 'Cliente' ? '#10b981' : ($t['tipo'] == 'Proveedor' ? '#f59e0b' : '#3b82f6'));
            $typeBg = ($t['tipo'] == 'Cliente' ? 'rgba(16, 185, 129, 0.1)' : ($t['tipo'] == 'Proveedor' ? 'rgba(245, 158, 11, 0.1)' : 'rgba(59, 130, 246, 0.1)'));
            ?>
            <div class="tercero-card"
                data-search="<?= strtolower($t['nombre_razon_social'] . ' ' . $t['rfc'] . ' ' . $t['id']) ?>"
                style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 24px; box-shadow: var(--glass-shadow); padding: 25px; transition: all 0.3s ease; display: flex; flex-direction: column; gap: 15px;">

                <div style="display: flex; align-items: center; gap: 15px;">
                    <!-- Avatar Dinámico / Imagen -->
                    <?php if (!empty($t['imagen_url'] ?? null)): ?>
                        <div
                            style="width: 55px; height: 55px; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 15px rgba(41, 56, 135, 0.2); border: 2px solid white; flex-shrink: 0;">
                            <img src="<?= $t['imagen_url'] ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php else: ?>
                        <div
                            style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--accent-color) 0%, #4a5da9 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 24px; box-shadow: 0 8px 15px rgba(41, 56, 135, 0.2); flex-shrink: 0;">
                            <?= $initials ?>
                        </div>
                    <?php endif; ?>
                    <div style="flex: 1; min-width: 0;">
                        <h4
                            style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 16px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?= $t['nombre_razon_social'] ?>
                        </h4>
                        <p
                            style="margin: 2px 0 0 0; font-size: 12px; font-family: 'Inter', sans-serif; color: var(--text-secondary); letter-spacing: 0.5px;">
                            RFC: <?= $t['rfc'] ?>
                        </p>
                        <div style="margin-top: 5px;">
                            <span
                                style="padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase; background: <?= $typeBg ?>; color: <?= $typeColor ?>;">
                                <?= $t['tipo'] ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div style="background: rgba(255,255,255,0.3); border-radius: 15px; padding: 12px; margin-top: 5px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                        <i class="fas fa-envelope" style="font-size: 12px; color: var(--text-secondary); width: 15px;"></i>
                        <span
                            style="font-size: 12px; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $t['email'] ?: 'Sin email' ?></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-phone-alt" style="font-size: 12px; color: var(--text-secondary); width: 15px;"></i>
                        <span
                            style="font-size: 12px; color: var(--text-primary);"><?= $t['telefono'] ?: 'Sin teléfono' ?></span>
                    </div>
                </div>

                <!-- Botones de Acción Estilo Imagen 2 -->
                <div
                    style="display: flex; justify-content: center; gap: 12px; margin-top: auto; padding-top: 15px; border-top: 1px solid var(--glass-border);">
                    <button title="Editar" class="action-btn"
                        data-tercero='<?= htmlspecialchars(json_encode($t), ENT_QUOTES, 'UTF-8') ?>'
                        onclick="openModal(JSON.parse(this.dataset.tercero))">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button title="Ver Detalles" class="action-btn" style="color: #6366f1; background: rgba(99, 102, 241, 0.1);"
                        onclick="viewTercero(<?= $t['id'] ?>)">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button title="Eliminar" class="action-btn" style="color: #ef4444; background: rgba(239, 68, 68, 0.1);"
                        onclick="confirmDelete(<?= $t['id'] ?>)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<style>
    .tercero-card:hover {
        transform: translateY(-8px);
        border-color: var(--accent-color);
        box-shadow: 0 15px 35px rgba(41, 56, 135, 0.15);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: rgba(41, 56, 135, 0.08);
        color: var(--accent-color);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 15px;
    }

    .action-btn:hover {
        transform: scale(1.1);
        filter: brightness(0.95);
    }
</style>

<!-- Modal Registro/Edición -->
<div id="modalTercero" class="edit-overlay" onclick="closeModal(event)">
    <div class="edit-panel" style="max-width: 550px;" onclick="event.stopPropagation()">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px;">
            <div>
                <h3 id="modalTitle" style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 20px;">
                    Registrar Tercero</h3>
                <p style="margin: 5px 0 0 0; color: var(--text-secondary); font-size: 12px;">Completa la información
                    legal y de contacto.</p>
            </div>
            <button onclick="closeModal()"
                style="background: #f1f5f9; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer;"><i
                    class="fas fa-times"></i></button>
        </div>

        <form id="formTercero" action="index.php?controller=Terceros&action=create" method="POST"
            enctype="multipart/form-data">
            <input type="hidden" name="id" id="tercero_id">
            <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <div id="imagePreviewContainer"
                        style="width: 80px; height: 80px; border-radius: 15px; background: #f1f5f9; border: 2px dashed #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <i class="fas fa-camera" style="color: #94a3b8; font-size: 20px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Imagen de Perfil</label>
                        <input type="file" name="imagen" id="imagenInput" accept="image/*" class="form-input"
                            style="padding: 8px;">
                    </div>
                </div>

                <div>
                    <label class="form-label">Razón Social o Nombre Completo</label>
                    <input type="text" name="nombre_razon_social" required placeholder="Ej. URICA Eléctrica y Control"
                        class="form-input">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">RFC</label>
                        <input type="text" name="rfc" required placeholder="XXXX000000XXX" class="form-input"
                            style="font-family: monospace;">
                    </div>
                    <div>
                        <label class="form-label">Tipo de Tercero</label>
                        <select name="tipo" class="form-input" style="background: white;">
                            <option value="Cliente">Cliente</option>
                            <option value="Proveedor">Proveedor</option>
                            <option value="Ambos">Ambos</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" placeholder="ejemplo@correo.com" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" placeholder="55 0000 0000" class="form-input">
                    </div>
                </div>

                <div>
                    <label class="form-label">Dirección Fiscal / Entrega</label>
                    <textarea name="direccion" rows="3" placeholder="Calle, Número, Colonia, CP..."
                        class="form-input"></textarea>
                </div>

                <div
                    style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn" style="background: #f1f5f9; font-weight: 700;"
                        onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: var(--accent-secondary);">Guardar
                        Registro</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Confirmar Eliminación Premium -->
<div id="modalDelete" class="edit-overlay" onclick="closeDeleteModal(event)">
    <div class="edit-panel" style="max-width: 400px; text-align: center;" onclick="event.stopPropagation()">
        <div
            style="width: 70px; height: 70px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 style="font-weight: 800; color: var(--text-primary); margin-bottom: 10px;">¿Eliminar Registro?</h3>
        <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 25px;">Esta acción borrará al tercero
            permanentemente. ¿Estás seguro?</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <button onclick="closeDeleteModal()" class="btn"
                style="background: #f1f5f9; font-weight: 700;">Cancelar</button>
            <a id="btnConfirmDelete" href="#" class="btn"
                style="background: #ef4444; color: white; border: none; font-weight: 800; text-decoration: none; display: flex; align-items: center; justify-content: center;">Sí,
                Eliminar</a>
        </div>
    </div>
</div>

<script>
    // Buscador en tiempo real
    document.getElementById('terceroSearch').addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.tercero-card');

        cards.forEach(card => {
            const searchText = card.dataset.search;
            if (searchText.includes(term)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });

    function openModal(data = null) {
        const modal = document.getElementById('modalTercero');
        const form = document.getElementById('formTercero');
        const title = document.getElementById('modalTitle');
        const idInput = document.getElementById('tercero_id');

        const imagePreview = document.getElementById('imagePreviewContainer');

        if (data) {
            title.textContent = 'Editar Tercero';
            form.action = 'index.php?controller=Terceros&action=update';
            idInput.value = data.id;
            form.nombre_razon_social.value = data.nombre_razon_social;
            form.rfc.value = data.rfc;
            form.direccion.value = data.direccion || '';
            form.email.value = data.email;
            form.telefono.value = data.telefono;
            form.tipo.value = data.tipo;

            if (data.imagen_url) {
                imagePreview.innerHTML = `<img src="${data.imagen_url}" style="width: 100%; height: 100%; object-fit: cover;">`;
            } else {
                imagePreview.innerHTML = `<i class="fas fa-camera" style="color: #94a3b8; font-size: 20px;"></i>`;
            }
        } else {
            title.textContent = 'Registrar Nuevo Tercero';
            form.action = 'index.php?controller=Terceros&action=create';
            form.reset();
            idInput.value = '';
            imagePreview.innerHTML = `<i class="fas fa-camera" style="color: #94a3b8; font-size: 20px;"></i>`;
        }

        document.body.appendChild(modal);
        modal.classList.add('active');
        document.body.classList.add('no-scroll');
    }

    // Preview de imagen al seleccionar
    document.getElementById('imagenInput')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('imagePreviewContainer').innerHTML = `<img src="${event.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
            }
            reader.readAsDataURL(file);
        }
    });

    function closeModal(e) {
        if (!e || e.target.id === 'modalTercero') {
            document.getElementById('modalTercero').classList.remove('active');
            document.body.classList.remove('no-scroll');
        }
    }

    function confirmDelete(id) {
        const modal = document.getElementById('modalDelete');
        const btnConfirm = document.getElementById('btnConfirmDelete');
        btnConfirm.href = `index.php?controller=Terceros&action=delete&id=${id}`;
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

    function viewTercero(id) {
        alert('Cargando expediente del tercero #' + id + '...');
    }
</script>