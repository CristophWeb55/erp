<?php
// Validar que exista la información
if (!isset($entrega) || !$entrega) {
    die("Error: No se encontró la información de la entrega. Verifique el ID.");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Logística
        <?= $entrega['folio'] ?> - URICA
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
            width: 90px;
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

        .logistics-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .evidence-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .evidence-box {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .evidence-img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 4px;
        }

        .terms {
            margin-top: 40px;
            font-size: 9px;
            color: var(--text-muted);
            border-top: 2px solid var(--border);
            padding-top: 20px;
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

    <div class="pdf-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-area">
                <img src="assets/logo.png" alt="URICA" onerror="this.style.display='none'">
                <div style="font-weight: 900; font-size: 30px; color: var(--primary); display: none;" id="textLogo">
                    URICA</div>
                <script>
                    window.onload = function () {
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

        <!-- Meta Grid -->
        <div class="meta-grid">
            <div class="card">
                <div class="card-title">Datos del Destinatario</div>
                <div class="info-item">
                    <span class="info-label">Cliente:</span>
                    <span class="info-value">
                        <?= $entrega['cliente'] ?>
                    </span>
                </div>
                <div class="info-item" style="margin-top: 8px;">
                    <span class="info-label">Dirección:</span>
                    <span class="info-value" style="font-weight: 400;">
                        <?= $entrega['direccion'] ?>
                    </span>
                </div>
                <div class="info-item" style="margin-top: 8px;">
                    <span class="info-label">Recibe:</span>
                    <span class="info-value">
                        <?= $entrega['persona_recibe'] ?: 'N/A' ?>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Teléfono:</span>
                    <span class="info-value">
                        <?= $entrega['telefono_contacto'] ?: 'N/A' ?>
                    </span>
                </div>
            </div>
            <div class="card doc-id-card">
                <div class="card-title">Orden de Entrega</div>
                <div class="doc-number">
                    <?= $entrega['folio'] ?>
                </div>
                <div style="font-size: 11px; margin-top: 10px; opacity: 0.8;">PEDIDO ORIGEN</div>
                <div style="font-weight: 700;">
                    <?= $entrega['folio_pedido'] ?>
                </div>
                <div style="font-weight: 700; font-size: 11px; margin-top: 5px;">
                    <?= $entrega['estatus'] ?>
                </div>
            </div>
        </div>

        <!-- Info Logística -->
        <div class="logistics-details">
            <div class="card">
                <div class="card-title">Transporte</div>
                <div class="info-item"><span class="info-label">Transportista:</span> <span class="info-value">
                        <?= $entrega['transportista'] ?: 'Interno' ?>
                    </span></div>
                <div class="info-item"><span class="info-label">Placas:</span> <span class="info-value">
                        <?= $entrega['placas_vehiculo'] ?: 'N/A' ?>
                    </span></div>
                <div class="info-item"><span class="info-label">Guía:</span> <span class="info-value">
                        <?= $entrega['guia_seguimiento'] ?: 'N/A' ?>
                    </span></div>
            </div>
            <div class="card">
                <div class="card-title">Carga</div>
                <div class="info-item"><span class="info-label">Bultos:</span> <span class="info-value">
                        <?= $entrega['bultos'] ?>
                    </span></div>
                <div class="info-item"><span class="info-label">Peso Total:</span> <span class="info-value">
                        <?= $entrega['peso_total'] ?> KG
                    </span></div>
                <div class="info-item"><span class="info-label">Fecha Est.:</span> <span class="info-value">
                        <?= date('d/m/Y', strtotime($entrega['fecha_entrega_estimada'])) ?>
                    </span></div>
            </div>
        </div>

        <!-- Tabla de Items -->
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;" class="text-center">#</th>
                    <th style="width: 120px;">SKU</th>
                    <th>DESCRIPCIÓN</th>
                    <th class="text-center" style="width: 60px;">CANT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entrega['items'] as $i => $item): ?>
                    <tr class="item-row">
                        <td class="text-center">
                            <?= $i + 1 ?>
                        </td>
                        <td style="font-weight: 700;">
                            <?= $item['sku'] ?>
                        </td>
                        <td>
                            <?= $item['descripcion'] ?>
                        </td>
                        <td class="text-center" style="font-weight: 700; color: var(--primary);">
                            <?= $item['cantidad_a_entregar'] ?? $item['cantidad'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Evidencias -->
        <?php if ($entrega['estatus'] == 'Entregado'): ?>
            <div class="card">
                <div class="card-title">Evidencia de Entrega</div>
                <div class="evidence-grid">
                    <div class="evidence-box">
                        <p style="font-size: 10px; font-weight: 700; margin-top: 0;">FIRMA DEL RECEPTOR</p>
                        <?php if ($entrega['evidencia_firma']): ?>
                            <img src="<?= $entrega['evidencia_firma'] ?>" class="evidence-img">
                        <?php else: ?>
                            <p style="font-size: 11px; color: var(--text-muted);">Sin firma</p>
                        <?php endif; ?>
                    </div>
                    <div class="evidence-box">
                        <p style="font-size: 10px; font-weight: 700; margin-top: 0;">FOTO / EVIDENCIA</p>
                        <?php if ($entrega['evidencia_foto']): ?>
                            <img src="<?= $entrega['evidencia_foto'] ?>" class="evidence-img">
                        <?php else: ?>
                            <p style="font-size: 11px; color: var(--text-muted);">Sin foto</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Firmas -->
        <div class="signature-area">
            <div>
                <p>Despachado Por:</p>
                <div class="signature-line">Almacén / Logística</div>
            </div>
            <div>
                <p>Transportista:</p>
                <div class="signature-line">Firma Chofer</div>
            </div>
            <div>
                <p>Recibido De Conformidad:</p>
                <div class="signature-line">Firma Cliente</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 30px; font-size: 10px; color: var(--text-muted);">
            Documento generado el
            <?= date('d/m/Y H:i') ?> | URICA ELECTRICA Y CONTROL
        </div>

    </div>

</body>

</html>