<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura
        <?= $fact['serie'] ?>-
        <?= $fact['folio_interno'] ?> - URICA
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        :root {
            --primary: #293887;
            --secondary: #E35156;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --accent: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            margin: 0;
            padding: 0;
            line-height: 1.4;
            background: white;
            font-size: 10px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .pdf-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .logo-area img {
            height: 70px;
            width: auto;
        }

        .company-info {
            text-align: left;
            font-size: 10px;
            color: var(--text-muted);
            max-width: 350px;
        }

        .company-info h1 {
            color: var(--text-main);
            font-size: 14px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .invoice-meta {
            text-align: right;
            font-size: 10px;
        }

        .invoice-meta h2 {
            margin: 0;
            color: var(--text-main);
            font-size: 16px;
            font-weight: 800;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            background: #fff;
        }

        .card-title {
            font-size: 11px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 4px;
        }

        .info-item {
            display: flex;
            margin-bottom: 3px;
        }

        .info-label {
            font-weight: 700;
            width: 90px;
            color: var(--text-muted);
        }

        .info-value {
            font-weight: 600;
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #f1f5f9;
            color: var(--text-main);
            font-size: 9px;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid var(--border);
        }

        td {
            padding: 8px 10px;
            border: 1px solid var(--border);
            font-size: 9px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fiscal-footer {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 20px;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .qr-placeholder {
            width: 120px;
            height: 120px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .qr-placeholder i {
            font-size: 80px;
            color: #cbd5e1;
        }

        .stamps-area {
            font-size: 7px;
            word-break: break-all;
            color: var(--text-muted);
        }

        .stamps-area b {
            color: var(--text-main);
            display: block;
            margin-top: 5px;
            text-transform: uppercase;
            font-size: 8px;
        }

        .totals-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .totals-table {
            width: 250px;
            margin-bottom: 0;
        }

        .totals-table td {
            border: none;
            padding: 4px 10px;
        }

        .total-row {
            font-weight: 800;
            font-size: 13px;
            color: var(--text-main);
        }

        @media print {
            body {
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .pdf-container {
                padding: 0 !important;
                width: 100% !important;
                max-width: none !important;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
        }
    </style>
</head>

<body>

    <button class="btn-print no-print" onclick="window.print()">
        <i class="fas fa-print"></i> IMPRIMIR FACTURA
    </button>

    <div class="pdf-container">
        <div class="header">
            <div style="display: flex; gap: 20px;">
                <div class="logo-area">
                    <img src="assets/logo.png" alt="URICA"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/150x70?text=URICA';">
                </div>
                <div class="company-info">
                    <h1>URICA ELECTRICA Y CONTROL REPRESENTATIVES</h1>
                    <p>UEC120111H70</p>
                    <p>Regimen Fiscal: 601 - General de Ley Personas Morales</p>
                    <p>Playa Condesa No. 25, Colonia La Quebrada, CP 54769</p>
                    <p>Cuautitlán Izcalli, Estado de México</p>
                </div>
            </div>
            <div class="invoice-meta">
                <h2>Factura Folio:
                    <?= $fact['serie'] ?>
                    <?= $fact['folio_interno'] ?>
                </h2>
                <p>Fecha de Emisión:
                    <?= date('Y-m-d H:i:s', strtotime($fact['fecha_emision'])) ?>
                </p>
                <p>Lugar de Expedición: 54769</p>
                <p>Tipo de Comprobante: I - Ingreso</p>
            </div>
        </div>

        <div class="meta-grid">
            <div class="card">
                <div class="card-title">Cliente</div>
                <div class="info-value" style="font-size: 11px; margin-bottom: 5px;">
                    <?= $fact['cliente_nombre'] ?>
                </div>
                <div class="info-item"><span class="info-label">RFC:</span><span class="info-value">
                        <?= $fact['cliente_rfc'] ?>
                    </span></div>
                <div class="info-item"><span class="info-label">Uso CFDI:</span><span class="info-value">G01 -
                        Adquisición de mercancías</span></div>
                <div class="info-item"><span class="info-label">Domicilio:</span><span class="info-value">
                        <?= $fact['cliente_direccion'] ?>
                    </span></div>
            </div>
            <div class="card">
                <div class="card-title">Datos Fiscales</div>
                <div class="info-item"><span class="info-label">Folio Fiscal:</span><span class="info-value"
                        style="font-size: 9px;">
                        <?= $fact['folio_fiscal_uuid'] ?>
                    </span></div>
                <div class="info-item"><span class="info-label">Serie Cert. SAT:</span><span
                        class="info-value">00001000000709182898</span></div>
                <div class="info-item"><span class="info-label">No. Cert. Emisor:</span><span
                        class="info-value">00001000000509681372</span></div>
                <div class="info-item"><span class="info-label">Metodo Pago:</span><span class="info-value">PPD - Pago
                        en parcialidades</span></div>
                <div class="info-item"><span class="info-label">Forma Pago:</span><span class="info-value">99 - Por
                        definir</span></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">Cant.</th>
                    <th style="width: 80px;">Código</th>
                    <th style="width: 80px;">Clave SAT</th>
                    <th style="width: 60px;">Unidad</th>
                    <th>Descripción</th>
                    <th class="text-right" style="width: 90px;">Precio Unt.</th>
                    <th class="text-right" style="width: 90px;">Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fact['items'] as $item): ?>
                    <tr>
                        <td class="text-center">
                            <?= $item['cantidad'] ?>
                        </td>
                        <td>
                            <?= $item['sku'] ?>
                        </td>
                        <td>39121500</td>
                        <td>H87-PIEZA</td>
                        <td>
                            <?= $item['descripcion'] ?>
                        </td>
                        <td class="text-right">$
                            <?= number_format($item['precio_unitario'], 2) ?>
                        </td>
                        <td class="text-right">$
                            <?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="totals-container">
            <table class="totals-table">
                <tr>
                    <td class="text-right" style="font-weight: 700;">Subtotal:</td>
                    <td class="text-right">$
                        <?= number_format($fact['total'] / 1.16, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-right" style="font-weight: 700;">IVA (16%):</td>
                    <td class="text-right">$
                        <?= number_format($fact['total'] - ($fact['total'] / 1.16), 2) ?>
                    </td>
                </tr>
                <tr class="total-row">
                    <td class="text-right">Total:</td>
                    <td class="text-right">$
                        <?= number_format($fact['total'], 2) ?>
                    </td>
                </tr>
            </table>
        </div>

        <div
            style="font-size: 9px; font-weight: 700; background: #fff; padding: 10px; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 20px;">
            Importe con letra:
            <?= strtoupper($fact['total']) ?> PESOS 00/100 MXN
        </div>

        <div class="fiscal-footer">
            <div class="qr-placeholder">
                <i class="fas fa-qrcode"></i>
            </div>
            <div class="stamps-area">
                <b>Sello Digital del SAT:</b>
                <?= $fact['sello_sat'] ?>
                <b>Sello Digital del CFDI:</b>
                <?= $fact['sello_cfdi'] ?>
                <b>Cadena Original del Complemento de Certificación Digital del SAT:</b>
                <?= $fact['cadena_original'] ?>
            </div>
        </div>

        <div
            style="text-align: center; margin-top: 30px; font-size: 9px; color: var(--text-muted); border-top: 1px solid var(--border); padding-top: 10px;">
            Este documento es una representación impresa de un CFDI 4.0
        </div>
    </div>
</body>

</html>