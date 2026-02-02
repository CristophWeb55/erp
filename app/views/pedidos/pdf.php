<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido<?= $pedido['folio'] ?> - URICA</title>
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
            line-height: 1.5;
            background: white;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .pdf-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }

        .logo-area img {
            height: 60px;
            width: auto;
        }

        .company-info {
            text-align: right;
            font-size: 11px;
            color: var(--text-muted);
        }

        .company-info h1 {
            color: var(--primary);
            font-size: 18px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 15px;
            background: var(--accent);
        }

        .card-title {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 1px;
            margin-bottom: 10px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 5px;
        }

        .info-item {
            display: flex;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .info-label {
            font-weight: 600;
            width: 80px;
            color: var(--text-muted);
        }

        .info-value {
            font-weight: 700;
        }

        .doc-id-card {
            background: var(--primary);
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .doc-id-card .card-title {
            color: rgba(255, 255, 255, 0.7);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .doc-number {
            font-size: 22px;
            font-weight: 900;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background: var(--primary);
            color: white;
            font-size: 10px;
            text-transform: uppercase;
            padding: 12px 10px;
            text-align: left;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            vertical-align: top;
        }

        .item-row:nth-child(even) {
            background: #fbfcfe;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-area {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 40px;
            page-break-inside: avoid;
        }

        .observations {
            font-size: 11px;
        }

        .observations h4 {
            margin: 0 0 10px 0;
            color: var(--primary);
        }

        .totals-table {
            margin-bottom: 0;
        }

        .totals-table td {
            padding: 8px 10px;
            border: none;
        }

        .total-row {
            background: var(--primary);
            color: white;
            font-weight: 800;
            font-size: 16px;
        }

        .total-row td {
            padding: 12px 10px;
        }

        .terms {
            margin-top: 40px;
            font-size: 9px;
            color: var(--text-muted);
            border-top: 2px solid var(--border);
            padding-top: 20px;
        }

        .terms h4 {
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 11px;
        }

        .signature-area {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 11px;
        }

        .signature-line {
            border-top: 1px solid var(--text-main);
            width: 200px;
            margin-top: 60px;
            text-align: center;
            padding-top: 5px;
            font-weight: 700;
        }

        @media print {
            body {
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .pdf-container {
                padding: 0 !important;
                margin: 0 auto !important;
                width: 100% !important;
                max-width: none !important;
            }

            .no-print {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }

            @page {
                margin: 1.5cm;
                size: portrait;
            }

            .card,
            .doc-id-card,
            th,
            .total-row {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--secondary);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(227, 81, 86, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <a href="#" class="btn-print no-print" onclick="window.print()">
        <i class="fas fa-file-pdf"></i> IMPRIMIR / GUARDAR PDF
    </a>

    <div class="pdf-container">
        <div class="header">
            <div class="logo-area">
                <img src="assets/logo.png" alt="URICA" onerror="this.style.display='none'">
                <div style="font-weight: 900; font-size: 30px; color: var(--primary); display: none;" id="textLogo">
                    URICA</div>
                <script>
                    window.onload = function() {
                        const img = document.querySelector('.logo-area img');
                        if (!img.complete || img.naturalWidth === 0) {
                            img.style.display = 'none';
                            document.getElementById('textLogo').style.display = 'block';
                        }
                    }
                </script>
            </div>
            <div class="company-info">
                <h1>URICA ELECTRICA Y CONTROL</h1>
                <p>RFC: UEC120111H70</p>
                <p>PLAYA CONDESA #25, CUAUTITLÁN IZCALLI</p>
                <p>CP. 54769, México | 5537011841</p>
                <p style="color: var(--primary); font-weight: 700;">www.uricaelectrica.com</p>
            </div>
        </div>

        <div class="meta-grid">
            <div class="card">
                <div class="card-title">Información del Cliente</div>
                <div class="info-item">
                    <span class="info-label">Cliente:</span>
                    <span class="info-value"><?= $pedido['cliente_nombre'] ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">RFC:</span>
                    <span class="info-value"><?= $pedido['cliente_rfc'] ?: 'XAXX010101000' ?></span>
                </div>
                <div class="info-item" style="margin-top: 8px;">
                    <span class="info-label">Dirección:</span>
                    <span class="info-value" style="font-weight: 400;"><?= $pedido['cliente_direccion'] ?: 'N/A' ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value" style="font-weight: 400;"><?= $pedido['cliente_email'] ?: 'N/A' ?></span>
                </div>
            </div>
            <div class="card doc-id-card">
                <div class="card-title">Pedido de Venta</div>
                <div class="doc-number"><?= $pedido['folio'] ?></div>
                <div style="font-size: 11px; margin-top: 10px; opacity: 0.8;">FECHA DEL PEDIDO</div>
                <div style="font-weight: 700;"><?= date('d M, Y', strtotime($pedido['fecha_pedido'])) ?></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 40px;" class="text-center">#</th>
                    <th style="width: 120px;">SKU</th>
                    <th>DESCRIPCIÓN</th>
                    <th class="text-center" style="width: 60px;">CANT</th>
                    <th class="text-right" style="width: 100px;">UNITARIO</th>
                    <th class="text-right" style="width: 100px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $symbol = (isset($pedido['moneda']) && $pedido['moneda'] === 'USD') ? 'USD $' : '$';
                foreach ($pedido['items'] as $i => $item):
                    ?>
                    <tr class="item-row">
                        <td class="text-center"><?= $i + 1 ?></td>
                        <td style="font-weight: 700;"><?= $item['sku'] ?></td>
                        <td><?= $item['descripcion'] ?></td>
                        <td class="text-center"><?= $item['cantidad'] ?></td>
                        <td class="text-right"><?= $symbol ?>     <?= number_format($item['precio_unitario'], 2) ?></td>
                        <td class="text-right" style="font-weight: 700; color: var(--primary);">
                            <?= $symbol ?>     <?= number_format($item['subtotal'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary-area">
            <div class="observations">
                <h4>DATOS DE ENTREGA</h4>
                <div style="background: var(--accent); padding: 15px; border-radius: 10px; border: 1px dashed var(--border);">
                    <p style="margin: 0;"><b>Estatus:</b> <?= strtoupper($pedido['estatus']) ?></p>
                    <p style="margin: 5px 0 0 0;"><b>Vendedor:</b> <?= $pedido['vendedor_nombre'] ?: 'N/A' ?></p>
                    <p style="margin: 5px 0 0 0;"><b>Entrega Est.:</b> <?= $pedido['fecha_entrega_estimada'] ? date('d/m/Y', strtotime($pedido['fecha_entrega_estimada'])) : 'N/A' ?></p>
                    <p style="margin: 5px 0 0 0;"><b>Moneda:</b> <?= (isset($pedido['moneda']) && $pedido['moneda'] === 'USD') ? 'Dólares Americanos (USD)' : 'Pesos Mexicanos (MXN)' ?></p>
                </div>
            </div>
            <div>
                <table class="totals-table">
                    <tr>
                        <td class="text-right" style="color: var(--text-muted); font-weight: 600;">SUBTOTAL:</td>
                        <td class="text-right" style="font-weight: 700; width: 120px;">
                            <?= $symbol ?> <?= number_format($pedido['subtotal'], 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right" style="color: var(--text-muted); font-weight: 600;">IVA (16%):</td>
                        <td class="text-right" style="font-weight: 700;">
                            <?= $symbol ?> <?= number_format($pedido['iva'], 2) ?>
                        </td>
                    </tr>
                    <tr class="total-row">
                        <td class="text-right">TOTAL:</td>
                        <td class="text-right">
                            <?= $symbol ?> <?= number_format($pedido['total'], 2) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="signature-area">
            <div>
                <p>Autorizado Por:</p>
                <div class="signature-line">Firma de Gerencia</div>
            </div>
            <div>
                <p>Recibido Por:</p>
                <div class="signature-line">Firma del Cliente</div>
            </div>
            <div style="text-align: right; font-size: 9px; color: var(--text-muted);">
                Generado por URICA ERP v2.0<br>
                <?= date('d/m/Y H:i') ?>
            </div>
        </div>
    </div>

</body>
</html>