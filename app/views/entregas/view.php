<div style="display: flex; gap: 20px; animation: fadeIn 0.4s ease-out; align-items: flex-start;">

    <!-- Lado Izquierdo: Información y Detalles -->
    <div style="flex: 1.4; display: flex; flex-direction: column; gap: 20px;">
        <!-- Card Encabezado Principal -->
        <div class="glass-panel" style="padding: 20px; border-radius: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                <div>
                    <span style="background: rgba(41, 56, 135, 0.1); color: var(--accent-color); padding: 4px 10px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase;">Orden de Logística</span>
                    <h2 style="font-weight: 800; font-size: 24px; color: var(--text-primary); margin: 5px 0 0 0;"><?= $entrega['folio'] ?></h2>
                    <div style="margin-top: 10px; display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 12px; color: var(--text-secondary);">
                            <i class="fas fa-file-invoice" style="margin-right: 5px;"></i> Pedido: <strong><?= $entrega['folio_pedido'] ?></strong>
                        </span>
                        <span style="width: 4px; height: 4px; background: #cbd5e1; border-radius: 50%;"></span>
                        <span style="font-size: 12px; color: #f59e0b; font-weight: 700;">
                            <i class="fas fa-calendar-alt" style="margin-right: 5px;"></i> <?= date('d/m/Y', strtotime($entrega['fecha_entrega_estimada'])) ?>
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
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 15px; border-radius: 12px; font-size: 11px; font-weight: 800; background: <?= $st['bg'] ?>; color: <?= $st['text'] ?>;">
                        <i class="fas <?= $st['icon'] ?>"></i> <?= strtoupper($entrega['estatus']) ?>
                    </span>
                </div>
            </div>

            <div style="background: rgba(41, 56, 135, 0.02); border-radius: 16px; padding: 15px; border: 1px solid rgba(41, 56, 135, 0.05);">
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 9px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 3px;">Cliente / Destinatario</label>
                        <p style="margin: 0; font-weight: 700; font-size: 14px; color: var(--text-primary);"><?= $entrega['cliente'] ?></p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 9px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 3px;">Dirección de Entrega</label>
                        <p style="margin: 0; font-weight: 500; font-size: 13px; color: var(--text-primary); line-height: 1.3;"><?= $entrega['direccion'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila de Información Profesional -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
            <!-- Transporte -->
            <div class="glass-panel" style="padding: 15px; border-radius: 16px; border-left: 3px solid var(--accent-color);">
                <h4 style="margin: 0 0 10px 0; font-size: 11px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-truck-pickup"></i> Transporte
                </h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div>
                        <span style="display: block; font-size: 8px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Placas</span>
                        <p style="margin: 0; font-size: 12px; font-weight: 600;"><?= ($entrega['placas_vehiculo'] ?? '') ?: 'Pendiente' ?></p>
                    </div>
                    <div>
                        <span style="display: block; font-size: 8px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Guía</span>
                        <p style="margin: 0; font-size: 12px; font-weight: 600; color: var(--accent-color);"><?= ($entrega['guia_seguimiento'] ?? '') ?: 'N/A' ?></p>
                    </div>
                </div>
            </div>

            <!-- Carga -->
            <div class="glass-panel" style="padding: 15px; border-radius: 16px; border-left: 3px solid #f59e0b;">
                <h4 style="margin: 0 0 10px 0; font-size: 11px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-boxes"></i> Paquetería
                </h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <div>
                        <span style="display: block; font-size: 8px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Bultos</span>
                        <p style="margin: 0; font-size: 14px; font-weight: 800;"><?= $entrega['bultos'] ?? 0 ?></p>
                    </div>
                    <div>
                        <span style="display: block; font-size: 8px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Peso KG</span>
                        <p style="margin: 0; font-size: 14px; font-weight: 800;"><?= number_format($entrega['peso_total'] ?? 0, 2) ?></p>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="glass-panel" style="padding: 15px; border-radius: 16px; border-left: 3px solid #10b981;">
                <h4 style="margin: 0 0 10px 0; font-size: 11px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-user-check"></i> Recepción
                </h4>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <div>
                        <span style="display: block; font-size: 8px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Recibe</span>
                        <p style="margin: 0; font-size: 12px; font-weight: 600;"><?= ($entrega['persona_recibe'] ?? '') ?: 'No especificado' ?></p>
                    </div>
                    <div>
                        <span style="display: block; font-size: 8px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase;">Teléfono</span>
                        <p style="margin: 0; font-size: 12px; font-weight: 600;"><?= ($entrega['telefono_contacto'] ?? '') ?: 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Productos -->
        <div class="glass-panel" style="padding: 20px; border-radius: 20px;">
            <h3 style="font-weight: 800; font-size: 16px; color: var(--text-primary); margin-bottom: 15px;">Mercancía en Tránsito</h3>
            <div style="background: white; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: rgba(0,0,0,0.01);">
                        <tr>
                            <th style="padding: 10px 15px; text-align: left; font-size: 11px; color: var(--text-secondary);">Producto</th>
                            <th style="padding: 10px 15px; text-align: center; font-size: 11px; color: var(--text-secondary);">Cant.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entrega['items'] as $item): ?>
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.02);">
                                <td style="padding: 10px 15px;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <?php if ($item['imagen_url']): ?>
                                            <img src="<?= $item['imagen_url'] ?>" style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover;">
                                        <?php else: ?>
                                            <div style="width: 32px; height: 32px; border-radius: 6px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px;"><i class="fas fa-box"></i></div>
                                        <?php endif; ?>
                                        <div><div style="font-weight: 700; font-size: 13px;"><?= $item['sku'] ?></div><div style="font-size: 10px; color: var(--text-secondary);"><?= $item['descripcion'] ?></div></div>
                                    </div>
                                </td>
                                <td style="padding: 10px 15px; text-align: center; font-weight: 800; font-size: 14px; color: var(--accent-color);"><?= $item['cantidad_a_entregar'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Lado Derecho: Formulario de Confirmación -->
    <div style="flex: 1;">
        <div class="glass-panel" style="padding: 20px; border-radius: 20px; position: sticky; top: 10px;">
            <h3 style="font-weight: 800; font-size: 16px; color: var(--text-primary); margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-file-signature" style="color: var(--accent-secondary);"></i> Finalizar Entrega
            </h3>

            <?php if ($entrega['estatus'] == 'Entregado'): ?>
                <!-- Vista de Entrega Completada -->
                <div style="text-align: center;">
                    <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid #10b981; border-radius: 12px; padding: 15px; margin-bottom: 15px;">
                        <i class="fas fa-check-circle" style="font-size: 32px; color: #10b981; margin-bottom: 8px;"></i>
                        <h4 style="margin: 0; color: #10b981; font-weight: 800; font-size: 14px;">PEDIDO ENTREGADO</h4>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <?php if(($entrega['evidencia_foto'] ?? '')): ?>
                        <div>
                            <label style="display: block; font-size: 9px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 5px; text-align: left;">Evidencia Foto</label>
                            <img src="<?= $entrega['evidencia_foto'] ?>" style="width: 100%; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                        </div>
                        <?php endif; ?>

                        <?php if(($entrega['evidencia_firma'] ?? '')): ?>
                        <div>
                            <label style="display: block; font-size: 9px; font-weight: 800; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 5px; text-align: left;">Firma Cliente</label>
                            <img src="<?= $entrega['evidencia_firma'] ?>" style="width: 100%; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <p style="font-size: 10px; color: var(--text-secondary); margin-top: 5px;">Recibió: <strong><?= ($entrega['persona_recibe'] ?? '') ?: 'N/A' ?></strong></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Formulario Progresivo -->
                <form id="formConfirm" action="index.php?controller=Logistica&action=confirm" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    <input type="hidden" name="id" value="<?= $entrega['id'] ?>">
                    <input type="hidden" name="signature_data" id="signature_data">
                    <input type="hidden" name="photo_data" id="photo_data">

                    <!-- Sección: Datos del Chofer y Envío -->
                    <div style="background: rgba(41, 56, 135, 0.04); padding: 12px; border-radius: 12px;">
                        <span style="display: block; font-size: 9px; font-weight: 800; color: var(--accent-color); margin-bottom: 8px; text-transform: uppercase;">Detalles Rápidos</span>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                            <input type="text" name="placas_vehiculo" placeholder="Placas" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #ddd; font-size: 11px;">
                            <input type="text" name="persona_recibe" placeholder="Recibe" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #ddd; font-size: 11px;">
                            <input type="number" name="bultos" placeholder="Bultos" value="1" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #ddd; font-size: 11px;">
                            <input type="number" step="0.01" name="peso_total" placeholder="Peso KG" value="0" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #ddd; font-size: 11px;">
                        </div>
                    </div>

                    <!-- Evidencia Fotográfica -->
                    <div>
                        <div id="photo-preview-container" style="display: none; position: relative; margin-bottom: 8px;">
                            <img id="photo-preview" style="width: 100%; border-radius: 12px; border: 1px solid var(--accent-color);">
                            <button type="button" onclick="retakePhoto()" style="position: absolute; top: 5px; right: 5px; width: 28px; height: 28px; border-radius: 50%; background: rgba(239, 68, 68, 0.8); color: white; border: none; cursor: pointer; font-size: 10px;"><i class="fas fa-times"></i></button>
                        </div>
                        <div id="camera-area">
                            <button type="button" onclick="document.getElementById('file-input').click()" 
                                style="width: 100%; background: white; border: 1.5px dashed #cbd5e1; padding: 15px; border-radius: 12px; color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class="fas fa-camera"></i>
                                <span style="font-size: 11px; font-weight: 600;">Evidencia Foto</span>
                            </button>
                            <input type="file" id="file-input" accept="image/*" capture="environment" style="display: none" onchange="handlePhotoUpload(event)">
                        </div>
                    </div>

                    <!-- Firma -->
                    <div>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; position: relative;">
                            <canvas id="signature-pad" style="width: 100%; height: 130px; cursor: crosshair; touch-action: none;"></canvas>
                            <button type="button" onclick="clearSignature()" style="position: absolute; bottom: 5px; right: 10px; background: none; border: none; color: #ef4444; font-size: 9px; font-weight: 800; cursor: pointer;">LIMPIAR</button>
                        </div>
                    </div>

                    <button type="button" onclick="saveDelivery()" class="btn" style="width: 100%; background: #10b981; color: white; border: none; padding: 12px; border-radius: 12px; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-check"></i> CONFIRMAR
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

    function clearSignature() { if(signaturePad) signaturePad.clear(); }

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
        if (signaturePad && signaturePad.isEmpty()) {
            alert("⚠️ Se requiere la firma para finalizar.");
            return;
        }
        document.getElementById('signature_data').value = signaturePad.toDataURL();
        document.getElementById('formConfirm').submit();
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .glass-panel { background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); box-shadow: var(--glass-shadow); }
    .btn { cursor: pointer; transition: all 0.2s; }
    .btn:hover { transform: scale(1.02); filter: brightness(1.1); }
</style>