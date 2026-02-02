<div class="glass-panel" style="padding: 25px; border-radius: 24px; animation: fadeIn 0.4s ease-out;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h2 style="font-weight: 800; font-size: 28px; color: var(--text-primary); margin: 0;">Vehículos</h2>
            <p style="color: var(--text-secondary); margin: 5px 0 0 0;">Gestión de la flota de transporte</p>
        </div>
        <button onclick="openModal('modalCreate')" class="btn-generate" style="border: none; cursor: pointer;">
            <i class="fas fa-plus"></i> Nuevo Vehículo
        </button>
    </div>

    <div class="table-container"
        style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: rgba(0,0,0,0.02); border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <th
                        style="padding: 15px 20px; text-align: left; font-size: 12px; color: var(--text-secondary); text-transform: uppercase;">
                        Placas</th>
                    <th
                        style="padding: 15px 20px; text-align: left; font-size: 12px; color: var(--text-secondary); text-transform: uppercase;">
                        Modelo / Marca</th>
                    <th
                        style="padding: 15px 20px; text-align: left; font-size: 12px; color: var(--text-secondary); text-transform: uppercase;">
                        Transportista</th>
                    <th
                        style="padding: 15px 20px; text-align: center; font-size: 12px; color: var(--text-secondary); text-transform: uppercase;">
                        Estatus</th>
                    <th
                        style="padding: 15px 20px; text-align: center; font-size: 12px; color: var(--text-secondary); text-transform: uppercase;">
                        Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehiculos as $item): ?>
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.02); transition: all 0.2s;">
                        <td style="padding: 15px 20px;">
                            <div
                                style="font-weight: 800; color: var(--accent-color); background: rgba(41, 56, 135, 0.05); padding: 5px 12px; border-radius: 8px; display: inline-block;">
                                <?= $item['placas'] ?>
                            </div>
                        </td>
                        <td style="padding: 15px 20px; font-weight: 600; font-size: 13px;">
                            <?= $item['marca_modelo'] ?>
                        </td>
                        <td style="padding: 15px 20px;">
                            <div style="font-size: 13px; font-weight: 500;"><i class="fas fa-truck"
                                    style="font-size: 10px; margin-right: 5px; color: var(--text-secondary);"></i>
                                <?= $item['transportista_nombre'] ?: 'Propio' ?>
                            </div>
                        </td>
                        <td style="padding: 15px 20px; text-align: center;">
                            <span
                                style="padding: 4px 10px; border-radius: 10px; font-size: 10px; font-weight: 800; background: <?= $item['activo'] ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)' ?>; color: <?= $item['activo'] ? '#10b981' : '#ef4444' ?>;">
                                <?= $item['activo'] ? 'ACTIVO' : 'INACTIVO' ?>
                            </span>
                        </td>
                        <td style="padding: 15px 20px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <button onclick="editItem(<?= $item['id'] ?>)"
                                    style="background: none; border: none; color: var(--accent-color); cursor: pointer; font-size: 14px;"><i
                                        class="fas fa-edit"></i></button>
                                <a href="index.php?controller=Vehiculos&action=delete&id=<?= $item['id'] ?>"
                                    onclick="return confirm('¿Eliminar vehículo?')"
                                    style="color: #ef4444; font-size: 14px;"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div id="modalCreate" class="modal"
    style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
    <div class="glass-panel"
        style="position: relative; margin: 10% auto; padding: 30px; width: 500px; border-radius: 24px;">
        <h3 style="margin-top: 0; font-weight: 800; margin-bottom: 25px;">Registrar Vehículo</h3>
        <form action="index.php?controller=Vehiculos&action=create" method="POST">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label
                            style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Placas</label>
                        <input type="text" name="placas" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd; outline: none;">
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Tipo
                            de Vehículo</label>
                        <select name="tipo"
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                            <option value="Camión">Camión</option>
                            <option value="Camioneta">Camioneta</option>
                            <option value="Automóvil">Automóvil</option>
                            <option value="Motocicleta">Motocicleta</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Marca
                        / Modelo</label>
                    <input type="text" name="marca_modelo"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Transportista
                        Asignado</label>
                    <select name="transportista_id"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                        <option value="">Propio / Ninguno</option>
                        <?php foreach ($transportistas as $t): ?>
                            <option value="<?= $t['id'] ?>">
                                <?= $t['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="activo" value="1" checked id="checkActivo">
                    <label for="checkActivo" style="font-size: 14px; font-weight: 600;">Vehículo Activo</label>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px;">
                <button type="button" onclick="closeModal('modalCreate')" class="btn"
                    style="background: #e2e8f0; color: #475569;">Cancelar</button>
                <button type="submit" class="btn"
                    style="background: var(--accent-color); color: white;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal"
    style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
    <div class="glass-panel"
        style="position: relative; margin: 10% auto; padding: 30px; width: 500px; border-radius: 24px;">
        <h3 style="margin-top: 0; font-weight: 800; margin-bottom: 25px;">Editar Vehículo</h3>
        <form action="index.php?controller=Vehiculos&action=update" method="POST">
            <input type="hidden" name="id" id="edit_id">
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label
                            style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Placas</label>
                        <input type="text" name="placas" id="edit_placas" required
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Tipo
                            de Vehículo</label>
                        <select name="tipo" id="edit_tipo"
                            style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                            <option value="Camión">Camión</option>
                            <option value="Camioneta">Camioneta</option>
                            <option value="Automóvil">Automóvil</option>
                            <option value="Motocicleta">Motocicleta</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Marca
                        / Modelo</label>
                    <input type="text" name="marca_modelo" id="edit_marca_modelo"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 700; color: var(--text-secondary); margin-bottom: 5px;">Transportista
                        Asignado</label>
                    <select name="transportista_id" id="edit_transportista_id"
                        style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #ddd;">
                        <option value="">Propio / Ninguno</option>
                        <?php foreach ($transportistas as $t): ?>
                            <option value="<?= $t['id'] ?>">
                                <?= $t['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="activo" value="1" id="edit_activo">
                    <label for="edit_activo" style="font-size: 14px; font-weight: 600;">Vehículo Activo</label>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 30px;">
                <button type="button" onclick="closeModal('modalEdit')" class="btn"
                    style="background: #e2e8f0; color: #475569;">Cancelar</button>
                <button type="submit" class="btn"
                    style="background: var(--accent-color); color: white;">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'block'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    function editItem(id) {
        fetch('index.php?controller=Vehiculos&action=edit&id=' + id)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_id').value = data.id;
                document.getElementById('edit_placas').value = data.placas;
                document.getElementById('edit_marca_modelo').value = data.marca_modelo;
                document.getElementById('edit_tipo').value = data.tipo;
                document.getElementById('edit_transportista_id').value = data.transportista_id || "";
                document.getElementById('edit_activo').checked = data.activo == 1;
                openModal('modalEdit');
            });
    }
</script>