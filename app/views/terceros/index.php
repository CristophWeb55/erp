<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Los Dioses</h2>
    <button class="btn btn-primary" onclick="openModal()">
        <i class="fas fa-plus"></i> Nuevo Tercero
    </button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Razón Social / Nombre</th>
                <th>RFC</th>
                <th>Tipo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($terceros)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 40px;">No hay
                        registros encontrados</td>
                </tr>
            <?php else: ?>
                <?php foreach ($terceros as $t): ?>
                    <tr>
                        <td>#
                            <?= $t['id'] ?>
                        </td>
                        <td style="font-weight: 600;">
                            <?= $t['nombre_razon_social'] ?>
                        </td>
                        <td><span style="font-family: monospace;">
                                <?= $t['rfc'] ?>
                            </span></td>
                        <td>
                            <span
                                style="padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: <?= ($t['tipo'] == 'Cliente' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)') ?>; color: <?= ($t['tipo'] == 'Cliente' ? '#10b981' : '#f59e0b') ?>;">
                                <?= strtoupper($t['tipo']) ?>
                            </span>
                        </td>
                        <td>
                            <?= $t['email'] ?>
                        </td>
                        <td>
                            <?= $t['telefono'] ?>
                        </td>
                        <td>
                            <button class="btn" style="background: transparent; color: var(--accent-color); padding: 5px;"
                                data-tercero='<?= htmlspecialchars(json_encode($t), ENT_QUOTES, 'UTF-8') ?>'
                                onclick="openModal(JSON.parse(this.dataset.tercero))">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn" style="background: transparent; color: #ef4444; padding: 5px;"
                                onclick="confirmDelete(<?= $t['id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="modalTercero"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 500px; background: white;">
        <h3 id="modalTitle" style="margin-bottom: 20px;">Registrar Nuevo Tercero</h3>
        <form id="formTercero" action="index.php?controller=Terceros&action=create" method="POST">
            <input type="hidden" name="id" id="tercero_id">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <label
                        style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Razón
                        Social / Nombre</label>
                    <input type="text" name="nombre_razon_social" required
                        style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                </div>
                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">RFC</label>
                        <input type="text" name="rfc" required
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                    <div style="flex: 1;">
                        <label
                            style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Tipo</label>
                        <select name="tipo"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <option value="Cliente">Cliente</option>
                            <option value="Proveedor">Proveedor</option>
                            <option value="Ambos">Ambos</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Email</label>
                    <input type="email" name="email"
                        style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Teléfono</label>
                    <input type="text" name="telefono"
                        style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; margin-bottom: 5px; color: var(--text-secondary);">Dirección</label>
                    <textarea name="direccion" rows="3"
                        style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <button type="button" class="btn" style="background: #f1f5f9;"
                        onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Registro</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Confirmar Eliminación -->
<div id="modalDelete"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(5px); z-index: 1000; justify-content: center; align-items: center;">
    <div class="card" style="width: 100%; max-width: 400px; background: white; text-align: center;">
        <div style="margin-bottom: 20px;">
            <div
                style="background: #fee2e2; color: #ef4444; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 24px;"></i>
            </div>
            <h3 style="margin-bottom: 10px;">¿Eliminar Tercero?</h3>
            <p style="color: var(--text-secondary); font-size: 14px;">Esta acción no se puede deshacer. ¿Estás seguro de
                que deseas eliminar este registro?</p>
        </div>
        <div style="display: flex; justify-content: center; gap: 10px;">
            <button class="btn" style="background: #f1f5f9;" onclick="closeDeleteModal()">Cancelar</button>
            <a id="btnConfirmDelete" href="#" class="btn" style="background: #ef4444; color: white;">Eliminar</a>
        </div>
    </div>
</div>

<script>
    function openModal(data = null) {
        const modal = document.getElementById('modalTercero');
        const form = document.getElementById('formTercero');
        const title = document.getElementById('modalTitle');
        const idInput = document.getElementById('tercero_id');

        // Reset sidebar/form states
        if (data) {
            // Edit Mode
            // Parse if it's a string (though PHP usually outputs object here directly in JS context if not quoted)
            // But wait, the PHP output is inside onclick='openModal(...)'. 
            // If I output json_encode($t), it becomes an object literal in JS.
            // Example: openModal({"id":1, ...})

            title.textContent = 'Editar Tercero';
            form.action = 'index.php?controller=Terceros&action=update';
            idInput.value = data.id;

            form.nombre_razon_social.value = data.nombre_razon_social;
            form.rfc.value = data.rfc;
            form.direccion.value = data.direccion || ''; // Handle nulls safely
            form.email.value = data.email;
            form.telefono.value = data.telefono;
            form.tipo.value = data.tipo;
        } else {
            // Create Mode
            title.textContent = 'Registrar Nuevo Tercero';
            form.action = 'index.php?controller=Terceros&action=create';
            form.reset();
            idInput.value = '';
        }

        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalTercero').style.display = 'none';
    }

    function confirmDelete(id) {
        const modal = document.getElementById('modalDelete');
        const btnConfirm = document.getElementById('btnConfirmDelete');
        btnConfirm.href = `index.php?controller=Terceros&action=delete&id=${id}`;
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('modalDelete').style.display = 'none';
    }
</script>