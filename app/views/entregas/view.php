<div style="display: flex; gap: 25px; animation: fadeIn 0.4s ease-out;">

    <!-- Lado Izquierdo: Información y Detalles -->
    <div style="flex: 2; display: flex; flex-direction: column; gap: 25px;">
        <!-- Card Encabezado Principal -->
        <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                <div>
                    <span
                        style="background: rgba(41, 56, 135, 0.1); color: var(--accent-color); padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; text-transform: uppercase;">Orden
                        de Logística</span>
                    <h2 style="font-weight: 800; font-size: 32px; color: var(--text-primary); margin: 10px 0 0 0;">
                        <?= $entrega['folio'] ?></h2>
                    <div style="margin-top: 15px; display: flex; align-items: center; gap: 15px;">
                        <span style="font-size: 13px; color: var(--text-secondary);">
                            <i class="fas fa-file-invoice" style="margin-right: 5px;"></i> Pedido:
                            <strong><?= $entrega['folio_pedido'] ?></strong>
                        </span>
                        <span style="width: 4px; height: 4px; background: #cbd5e1; border-radius: 50%;"></span>
                        <span style="font-size: 13px; color: #f59e0b; font-weight: 700;">
                            <i class="fas fa-calendar-alt" style="margin-right: 5px;"></i>
                            <?= date('d/m/Y', strtotime($entrega['fecha_entrega_estimada'])) ?>
                        </span>
                    </div>
                </div>
                <div style="text-align: right;">
                    <?php
                    $stMapping = [
                        'Programado' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'text' => '#3b82f6', 'icon' => 'fa-clock'],
                        'En Tránsito' => ['bg' => 'rgba(245, 158, 11, 0.1)', 'text' => '#f59e0b', 'icon' => 'fa-truck-fast'],
                        'Entregado' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981', 'icon' => 'fa-check-double']
                    ];
                    $st = $stMapping[$entrega['estatus']] ?? $stMapping['Programado'];
                    ?>
                    <span
                        style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 14px; font-size: 13px; font-weight: 800; background: <?= $st['bg'] ?>; color: <?= $st['text'] ?>;">
                        <i class="fas <?= $st['icon'] ?>"></i> <?= strtoupper($entrega['estatus']) ?>
                    </span>
                </div>
            </div>

            <div
                style="background: rgba(41, 56, 135, 0.02); border-radius: 20px; padding: 25px; border: 1px solid rgba(41, 56, 135, 0.05);">
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
                    <div>
                        <label
                            style="display: block; font-size: 10px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 5px;">Cliente
                            / Destinatario</label>
                        <p style="margin: 0; font-weight: 700; color: var(--text-primary);"><?= $entrega['cliente'] ?>
                        </p>
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 10px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 5px;">Dirección
                            de Entrega</label>
                        <p
                            style="margin: 0; font-weight: 500; font-size: 14px; color: var(--text-primary); line-height: 1.4;">
                            <?= $entrega['direccion'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila de Información Profesional -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
            <!-- Transporte -->
            <div class="glass-panel"
                style="padding: 20px; border-radius: 20px; border-left: 4px solid var(--accent-color);">
                <h4
                    style="margin: 0 0 15px 0; font-size: 13px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-truck-pickup"></i> Transporte
                </h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div>
                        <span
                            style="display: block; font-size: 9px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Vehículo
                            / Placas</span>
                        <p style="margin: 0; font-size: 13px; font-weight: 600;">
                            <?= $entrega['placas_vehiculo'] ?: 'Pendiente' ?></p>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 9px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Número
                            de Guía</span>
                        <p style="margin: 0; font-size: 13px; font-weight: 600; color: var(--accent-color);">
                            <?= $entrega['guia_seguimiento'] ?: 'N/A' ?></p>
                    </div>
                </div>
            </div>

            <!-- Carga -->
            <div class="glass-panel" style="padding: 20px; border-radius: 20px; border-left: 4px solid #f59e0b;">
                <h4
                    style="margin: 0 0 15px 0; font-size: 13px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-boxes"></i> Paquetería
                </h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <span
                            style="display: block; font-size: 9px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Bultos</span>
                        <p style="margin: 0; font-size: 15px; font-weight: 800;"><?= $entrega['bultos'] ?></p>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 9px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Peso
                            KG</span>
                        <p style="margin: 0; font-size: 15px; font-weight: 800;">
                            <?= number_format($entrega['peso_total'], 2) ?></p>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="glass-panel" style="padding: 20px; border-radius: 20px; border-left: 4px solid #10b981;">
                <h4
                    style="margin: 0 0 15px 0; font-size: 13px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-check"></i> Recepción Sitio
                </h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div>
                        <span
                            style="display: block; font-size: 9px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Persona
                            Destino</span>
                        <p style="margin: 0; font-size: 13px; font-weight: 600;">
                            <?= $entrega['persona_recibe'] ?: 'No especificado' ?></p>
                    </div>
                    <div>
                        <span
                            style="display: block; font-size: 9px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Teléfono</span>
                        <p style="margin: 0; font-size: 13px; font-weight: 600;">
                            <?= $entrega['telefono_contacto'] ?: 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Productos -->
        <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
            <h3 style="font-weight: 800; font-size: 18px; color: var(--text-primary); margin-bottom: 20px;">Mercancía en
                Tránsito</h3>
            <div style="background: white; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: rgba(0,0,0,0.02);">
                        <tr>
                            <th
                                style="padding: 12px 20px; text-align: left; font-size: 12px; color: var(--text-secondary);">
                                Producto</th>
                            <th
                                style="padding: 12px 20px; text-align: center; font-size: 12px; color: var(--text-secondary);">
                                Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entrega['items'] as $item): ?>
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.03);">
                                <td style="padding: 15px 20px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if ($item['imagen_url']): ?>
                                            <img src="<?= $item['imagen_url'] ?>"
                                                style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;">
                                        <?php else: ?>
                                            <div
                                                style="width: 40px; height: 40px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                                <i class="fas fa-box"></i></div>
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 700; font-size: 14px;"><?= $item['sku'] ?></div>
                                            <div style="font-size: 11px; color: var(--text-secondary);">
                                                <?= $item['descripcion'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    style="padding: 15px 20px; text-align: center; font-weight: 800; font-size: 16px; color: var(--accent-color);">
                                    <?= $item['cantidad_a_entregar'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Lado Derecho: Formulario de Confirmación -->
    <div style="flex: 1;">
        <div class="glass-panel" style="padding: 30px; border-radius: 24px; position: sticky; top: 20px;">
            <h3
                style="font-weight: 800; font-size: 18px; color: var(--text-primary); margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-file-signature" style="color: var(--accent-secondary);"></i> Finalizar Entrega
            </h3>

            <?php if ($entrega['estatus'] == 'Entregado'): ?>
                <!-- Vista de Entrega Completada -->
                <div style="text-align: center;">
                    <div
                        style="background: rgba(16, 185, 129, 0.1); border: 2px solid #10b981; border-radius: 20px; padding: 25px; margin-bottom: 25px;">
                        <i class="fas fa-check-circle" style="font-size: 45px; color: #10b981; margin-bottom: 10px;"></i>
                        <h4 style="margin: 0; color: #10b981; font-weight: 800;">PEDIDO ENTREGADO</h4>
                        <p style="font-size: 12px; color: #10b981; margin: 5px 0 0 0;">Certificado por Firma y Foto</p>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <?php if ($entrega['evidencia_foto']): ?>
                            <div>
                                <label
                                    style="display: block; font-size: 10px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 10px; text-align: left;">Evidencia
                                    Fotográfica</label>
                                <img src="<?= $entrega['evidencia_foto'] ?>"
                                    style="width: 100%; border-radius: 16px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            </div>
                        <?php endif; ?>

                        <?php if ($entrega['evidencia_firma']): ?>
                            <div>
                                <label
                                    style="display: block; font-size: 10px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 10px; text-align: left;">Firma
                                    del Destinatario</label>
                                <img src="<?= $entrega['evidencia_firma'] ?>"
                                    style="width: 100%; background: #f8fafc; border-radius: 16px; border: 1px solid #e2e8f0;">
                                <p style="font-size: 11px; color: var(--text-secondary); margin-top: 10px;">Recibió:
                                    <strong><?= $entrega['persona_recibe'] ?: 'N/A' ?></strong></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Formulario Progresivo -->
                <form id="formConfirm" action="index.php?controller=Logistica&action=confirm" method="POST">
                    <input type="hidden" name="id" value="<?= $entrega['id'] ?>">
                    <input type="hidden" name="signature_data" id="signature_data">
                    <input type="hidden" name="photo_data" id="photo_data">

                    <!-- Sección: Datos del Chofer y Envío (Solo si están vacíos) -->
                    <div
                        style="background: rgba(41, 56, 135, 0.05); padding: 15px; border-radius: 16px; margin-bottom: 20px;">
                        <span
                            style="display: block; font-size: 11px; font-weight: 800; color: var(--accent-color); margin-bottom: 12px; text-transform: uppercase;">Detalles
                            de Despacho</span>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <input type="text" name="placas_vehiculo" placeholder="Placas"
                                style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; font-size: 12px;">
                            <input type="text" name="persona_recibe" placeholder="Persona recibe"
                                style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; font-size: 12px;">
                            <input type="number" name="bultos" placeholder="Bultos" value="1"
                                style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; font-size: 12px;">
                            <input type="number" step="0.01" name="peso_total" placeholder="Peso KG" value="0"
                                style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid #ddd; font-size: 12px;">
                        </div>
                    </div>

                    <!-- Evidencia Fotográfica (Cámara) -->
                    <div style="margin-bottom: 25px;">
                        <label
                            style="display: block; font-size: 12px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-camera" style="margin-right: 5px;"></i> Foto del Paquete / Domicilio
                        </label>
                        <div id="photo-preview-container" style="display: none; position: relative; margin-bottom: 10px;">
                            <img id="photo-preview"
                                style="width: 100%; border-radius: 16px; border: 1px solid var(--accent-color);">
                            <button type="button" onclick="retakePhoto()"
                                style="position: absolute; top: 10px; right: 10px; width: 35px; height: 35px; border-radius: 50%; background: rgba(239, 68, 68, 0.8); color: white; border: none; cursor: pointer;"><i
                                    class="fas fa-times"></i></button>
                        </div>
                        <div id="camera-area" style="text-align: center;">
                            <button type="button" onclick="document.getElementById('file-input').click()"
                                style="width: 100%; background: white; border: 2px dashed #cbd5e1; padding: 20px; border-radius: 16px; color: var(--text-secondary); cursor: pointer; transition: all 0.3s; display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 24px;"></i>
                                <span style="font-size: 13px; font-weight: 600;">Tomar Foto o Subir Archivo</span>
                            </button>
                            <input type="file" id="file-input" accept="image/*" capture="environment" style="display: none"
                                onchange="handlePhotoUpload(event)">
                        </div>
                    </div>

                    <!-- Firma Digital -->
                    <div style="margin-bottom: 25px;">
                        <label
                            style="display: block; font-size: 12px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px;">
                            <i class="fas fa-signature" style="margin-right: 5px;"></i> Firma de Conformidad
                        </label>
                        <div
                            style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; position: relative;">
                            <canvas id="signature-pad"
                                style="width: 100%; height: 180px; cursor: crosshair; touch-action: none;"></canvas>
                            <button type="button" onclick="clearSignature()"
                                style="position: absolute; bottom: 10px; right: 15px; background: none; border: none; color: #ef4444; font-size: 10px; font-weight: 800; cursor: pointer;">LIMPIAR</button>
                        </div>
                    </div>

                    <button type="button" onclick="saveDelivery()" class="btn"
                        style="width: 100%; background: #10b981; color: white; border: none; padding: 18px; border-radius: 18px; font-weight: 800; font-size: 15px; display: flex; align-items: center; justify-content: center; gap: 12px; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-paper-plane"></i> CONFIRMAR ENTREGA
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    let signaturePad;

    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('signature-pad');
        if (canvas) {
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(248, 250, 252)',
                penColor: 'rgb(41, 56, 135)'
            });

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }
            window.onresize = resizeCanvas;
            resizeCanvas();
        }
    });

    function clearSignature() { signaturePad.clear(); }

    function handlePhotoUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('photo-preview').src = e.target.result;
                document.getElementById('photo_data').value = e.target.result;
                document.getElementById('photo-preview-container').style.display = 'block';
                document.getElementById('camera-area').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }

    function retakePhoto() {
        document.getElementById('photo-preview-container').style.display = 'none';
        document.getElementById('camera-area').style.display = 'block';
        document.getElementById('photo_data').value = '';
        document.getElementById('file-input').value = '';
    }

    function saveDelivery() {
        if (signaturePad.isEmpty()) {
            alert("⚠️ Se requiere la firma del cliente para finalizar.");
            return;
        }
        if (!document.getElementById('photo_data').value) {
            if (!confirm("¿Deseas finalizar sin adjuntar evidencia fotográfica? (Recomendado para seguridad)")) {
                return;
            }
        }

        document.getElementById('signature_data').value = signaturePad.toDataURL();
        document.getElementById('formConfirm').submit();
    }
</script>

<style>
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

    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        box-shadow: var(--glass-shadow);
    }

    .btn {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn:hover {
        transform: translateY(-3px);
        filter: brightness(1.1);
    }
</style>