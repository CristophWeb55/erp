<div style="display: flex; gap: 25px; animation: fadeIn 0.4s ease-out;">

    <!-- Lado Izquierdo: Información de la Entrega -->
    <div style="flex: 2;">
        <div class="glass-panel" style="padding: 30px; border-radius: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <div>
                    <span
                        style="background: rgba(41, 56, 135, 0.1); color: var(--accent-color); padding: 5px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Orden
                        de Logística</span>
                    <h2 style="font-weight: 800; font-size: 32px; color: var(--text-primary); margin: 10px 0 0 0;">
                        <?= $entrega['folio'] ?>
                    </h2>
                </div>
                <div style="text-align: right;">
                    <p style="color: var(--text-secondary); font-size: 13px; margin: 0;">Pedido Referencia</p>
                    <p style="font-weight: 700; color: var(--accent-color); margin: 0;">
                        <?= $entrega['folio_pedido'] ?>
                    </p>
                </div>
            </div>

            <!-- Grid de Información -->
            <div
                style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 40px; background: rgba(0,0,0,0.02); padding: 25px; border-radius: 20px;">
                <div>
                    <label
                        style="display: block; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; margin-bottom: 8px;">Cliente
                        Destinatario</label>
                    <p style="font-weight: 700; font-size: 16px; margin: 0; color: var(--text-primary);">
                        <?= $entrega['cliente'] ?>
                    </p>
                </div>
                <div>
                    <label
                        style="display: block; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; margin-bottom: 8px;">Dirección
                        de Entrega</label>
                    <p
                        style="font-weight: 500; font-size: 14px; margin: 0; color: var(--text-primary); line-height: 1.4;">
                        <?= $entrega['direccion'] ?>
                    </p>
                </div>
                <div>
                    <label
                        style="display: block; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; margin-bottom: 8px;">Fecha
                        Prometida</label>
                    <p style="font-weight: 700; font-size: 15px; margin: 0; color: #f59e0b;">
                        <i class="fas fa-calendar-alt"></i>
                        <?= date('d/m/Y', strtotime($entrega['fecha_entrega_estimada'])) ?>
                    </p>
                </div>
                <div>
                    <label
                        style="display: block; color: var(--text-secondary); font-size: 12px; text-transform: uppercase; margin-bottom: 8px;">Estatus
                        Actual</label>
                    <p style="font-weight: 700; font-size: 15px; margin: 0; color: var(--accent-color);">
                        <i class="fas fa-circle" style="font-size: 8px; margin-right: 5px;"></i>
                        <?= $entrega['estatus'] ?>
                    </p>
                </div>
            </div>

            <!-- Tabla de Ítems a Entregar -->
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
                                            <div style="font-weight: 700; font-size: 14px;">
                                                <?= $item['sku'] ?>
                                            </div>
                                            <div style="font-size: 11px; color: var(--text-secondary);">
                                                <?= $item['descripcion'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    style="padding: 15px 20px; text-align: center; font-weight: 800; font-size: 16px; color: var(--accent-color);">
                                    <?= $item['cantidad_a_entregar'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Lado Derecho: Confirmación y Firma -->
    <div style="flex: 1;">
        <div class="glass-panel" style="padding: 30px; border-radius: 24px; position: sticky; top: 20px;">
            <h3
                style="font-weight: 800; font-size: 18px; color: var(--text-primary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-pen-nib" style="color: var(--accent-secondary);"></i>
                Confirmar Recepción
            </h3>

            <?php if ($entrega['estatus'] == 'Entregado'): ?>
                <!-- Vista de Entrega Completada -->
                <div
                    style="text-align: center; padding: 20px; background: rgba(16, 185, 129, 0.05); border-radius: 16px; border: 1px dashed #10b981;">
                    <i class="fas fa-check-circle" style="font-size: 50px; color: #10b981; margin-bottom: 15px;"></i>
                    <h4 style="margin: 0; color: #10b981; font-weight: 800;">ENTREGA EXITOSA</h4>
                    <p style="font-size: 13px; color: #10b981; margin-top: 5px;">Recibido el
                        <?= date('d/m/Y H:i', strtotime($entrega['fecha_entrega_real'])) ?>
                    </p>

                    <?php if ($entrega['evidencia_firma']): ?>
                        <div style="margin-top: 20px;">
                            <label
                                style="display: block; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 10px;">Firma
                                de Recibido</label>
                            <img src="<?= $entrega['evidencia_firma'] ?>"
                                style="width: 100%; background: white; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05);">
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Formulario de Firma (Signature Pad) -->
                <form id="formConfirm" action="index.php?controller=Logistica&action=confirm" method="POST">
                    <input type="hidden" name="id" value="<?= $entrega['id'] ?>">
                    <input type="hidden" name="signature_data" id="signature_data">

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 10px; font-weight: 600;">Notas
                            o Comentarios:</label>
                        <textarea name="notas_entrega"
                            style="width: 100%; height: 80px; padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); font-family: inherit; font-size: 13px; outline: none;"
                            placeholder="Ej: Recibió en recepción, sin daños..."></textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label
                            style="display: block; font-size: 12px; color: var(--text-secondary); margin-bottom: 10px; font-weight: 600;">Firma
                            del Cliente:</label>
                        <div
                            style="background: white; border-radius: 16px; border: 1px solid rgba(0,0,0,0.1); position: relative; overflow: hidden;">
                            <canvas id="signature-pad" width="400" height="200"
                                style="width: 100%; height: 200px; cursor: crosshair; touch-action: none;"></canvas>
                        </div>
                        <button type="button" onclick="clearSignature()"
                            style="margin-top: 10px; background: none; border: none; color: #ef4444; font-size: 11px; font-weight: 700; cursor: pointer;">
                            <i class="fas fa-eraser"></i> LIMPIAR FIRMA
                        </button>
                    </div>

                    <button type="button" onclick="saveDelivery()" class="btn"
                        style="width: 100%; background: #10b981; color: white; border: none; padding: 15px; border-radius: 16px; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.3s;">
                        <i class="fas fa-save"></i> FINALIZAR ENTREGA
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
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(41, 56, 135)'
            });

            // Ajustar canvas al tamaño real del contenedor
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

    function clearSignature() {
        signaturePad.clear();
    }

    function saveDelivery() {
        if (signaturePad.isEmpty()) {
            alert("Por favor, capture la firma del cliente antes de continuar.");
            return;
        }

        const dataUrl = signaturePad.toDataURL();
        document.getElementById('signature_data').value = dataUrl;
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

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        background: #059669 !important;
    }
</style>