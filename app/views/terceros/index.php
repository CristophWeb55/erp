<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Listado de Clientes y Proveedores</h2>
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
                            <button class="btn" style="background: transparent; color: var(--accent-color); padding: 5px;"><i
                                    class="fas fa-edit"></i></button>
                            <button class="btn" style="background: transparent; color: #ef4444; padding: 5px;"><i
                                    class="fas fa-trash"></i></button>
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
        <h3 style="margin-bottom: 20px;">Registrar Nuevo Tercero</h3>
        <form action="index.php?controller=Terceros&action=create" method="POST">
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

<script>
    function openModal() {
        document.getElementById('modalTercero').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('modalTercero').style.display = 'none';
    }
</script>