<div style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="index.php?controller=Facturacion&action=index" class="btn"
                style="background: rgba(255,255,255,0.5); padding: 10px 15px;"><i class="fas fa-arrow-left"></i></a>
            <h2>Visualización de Factura</h2>
        </div>
        <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Imprimir PDF</button>
    </div>

    <!-- The Invoice Mockup (Glassmorphism style) -->
    <div class="card"
        style="background: white; padding: 50px; border-radius: 0; box-shadow: 0 15px 50px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; color: #000;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 50px;">
            <div>
                <img src="assets/logo.png" alt="URICA" style="height: 60px; margin-bottom: 20px;">
                <p style="font-size: 14px; color: #64748b;">URICA ELÉCTRICA Y CONTROL REPRESENTATIVES, S.A. DE C.V.</p>
                <p style="font-size: 14px; color: #64748b;">Avenida de la Industria 456, Parque Industrial</p>
                <p style="font-size: 14px; color: #64748b;">Querétaro, QRO, CP 76120</p>
                <p style="font-size: 14px; color: #64748b; font-weight: 600;">RFC: UEC010101QRO</p>
            </div>
            <div style="text-align: right;">
                <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 10px; color: #1e293b;">FACTURA</h1>
                <p style="font-family: monospace; font-size: 16px; font-weight: 700; color: #293887;">
                    #FAC-<?= str_pad($factura['id'], 5, '0', STR_PAD_LEFT) ?></p>
                <p style="font-size: 12px; color: #64748b; margin-top: 5px;">FECHA: <?= $factura['fecha_emision'] ?></p>
            </div>
        </div>

        <div
            style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px; padding: 20px; background: #f8fafc; border-radius: 12px;">
            <div>
                <p
                    style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700; margin-bottom: 5px;">
                    RECEPTOR (CLIENTE)</p>
                <p style="font-weight: 700; font-size: 16px;">
                    <?= $factura['nombre_razon_social'] ?>
                </p>
                <p style="font-family: monospace; font-weight: 600; color: #475569;">
                    <?= $factura['rfc'] ?>
                </p>
                <p style="font-size: 13px; color: #64748b; margin-top: 5px;">
                    <?= $factura['direccion'] ?>
                </p>
            </div>
            <div style="text-align: right;">
                <p
                    style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700; margin-bottom: 5px;">
                    FOLIO FISCAL (UUID)</p>
                <p
                    style="font-family: monospace; font-size: 13px; font-weight: 600; background: #e2e8f0; padding: 5px 10px; border-radius: 6px; display: inline-block;">
                    <?= $factura['folio_fiscal_uuid'] ?>
                </p>
                <p style="font-size: 11px; color: #64748b; margin-top: 10px;">Metodo de Pago: PPD - Pago en
                    parcialidades o diferido</p>
                <p style="font-size: 11px; color: #64748b;">Uso CFDI: G03 - Gastos en general</p>
            </div>
        </div>

        <table style="width: 100%; border-spacing: 0;">
            <thead>
                <tr style="border-bottom: 2px solid #1e293b;">
                    <th style="background: #1e293b; color: white; border-radius: 8px 0 0 0;">SKU</th>
                    <th style="background: #1e293b; color: white;">Descripción / Info Aduanera</th>
                    <th style="background: #1e293b; color: white; text-align: center;">Cant.</th>
                    <th style="background: #1e293b; color: white; text-align: right;">Precio</th>
                    <th style="background: #1e293b; color: white; text-align: right; border-radius: 0 8px 0 0;">Total
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $d): ?>
                    <tr>
                        <td
                            style="vertical-align: top; border-bottom: 1px solid #f1f5f9; padding: 20px 10px; font-weight: 700;">
                            <?= $d['sku'] ?>
                        </td>
                        <td style="vertical-align: top; border-bottom: 1px solid #f1f5f9; padding: 20px 10px;">
                            <div style="font-weight: 600; margin-bottom: 8px;">
                                <?= $d['descripcion'] ?>
                            </div>

                            <?php if ($d['numero_pedimento']): ?>
                                <!-- MAGIC PART HERE -->
                                <div
                                    style="background: rgba(41, 56, 135, 0.05); border-left: 3px solid #293887; padding: 10px 15px; border-radius: 4px;">
                                    <p style="font-size: 10px; color: #293887; font-weight: 800; text-transform: uppercase;">
                                        Información Aduanera (Nodo Automático)</p>
                                    <p style="font-size: 13px; font-family: 'Courier New', monospace; font-weight: 700;">
                                        Pedimento: <span style="color: #000;">
                                            <?= $d['numero_pedimento'] ?>
                                        </span>
                                    </p>
                                    <p style="font-size: 11px; color: #64748b;">
                                        Aduana:
                                        <?= $d['nombre_aduana'] ?> | Fecha:
                                        <?= $d['fecha_pedimento'] ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td
                            style="vertical-align: top; border-bottom: 1px solid #f1f5f9; padding: 20px 10px; text-align: center;">
                            <?= $d['cantidad'] ?>
                        </td>
                        <td
                            style="vertical-align: top; border-bottom: 1px solid #f1f5f9; padding: 20px 10px; text-align: right;">
                            $
                            <?= number_format($d['precio_unitario'], 2) ?>
                        </td>
                        <td
                            style="vertical-align: top; border-bottom: 1px solid #f1f5f9; padding: 20px 10px; text-align: right; font-weight: 700;">
                            $
                            <?= number_format($d['subtotal'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
            <div style="width: 250px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="color: #64748b;">Subtotal:</span>
                    <span style="font-weight: 600;">$
                        <?= number_format($factura['total'] / 1.16, 2) ?>
                    </span>
                </div>
                <div
                    style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                    <span style="color: #64748b;">IVA (16%):</span>
                    <span style="font-weight: 600;">$
                        <?= number_format($factura['total'] - ($factura['total'] / 1.16), 2) ?>
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 800;">
                    <span>TOTAL:</span>
                    <span style="color: #6366f1;">$
                        <?= number_format($factura['total'], 2) ?>
                    </span>
                </div>
            </div>
        </div>

        <div style="margin-top: 60px; display: flex; gap: 20px; color: #64748b; font-size: 10px;">
            <div style="flex: 1;">
                <p style="font-weight: 700; margin-bottom: 5px;">Sello Digital del Emisor</p>
                <p style="word-break: break-all; opacity: 0.7;">
                    Xy7B2aZ9Lp0mN1qW8vR5tU3iO4eP6dS7fG8hJ9kL0zX1cV2bN3mQ4wE5rT6yU7iI8oO9pP0[[SIMULATED]]...
                </p>
            </div>
            <div style="flex: 0 0 100px;">
                <div
                    style="width: 100px; height: 100px; background: #000; color: white; display: flex; align-items: center; justify-content: center; font-size: 8px; text-align: center;">
                    CÓDIGO QR<br>SIMULADO<br>CFDI 4.0
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
            padding: 0 !important;
        }

        .bg-orbs,
        .sidebar,
        .header,
        .btn-primary,
        .btn {
            display: none !important;
        }

        .app-container {
            padding: 0 !important;
        }

        .main-wrapper {
            padding: 0 !important;
        }

        .content-area {
            border: none !important;
            box-shadow: none !important;
            background: white !important;
            padding: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>