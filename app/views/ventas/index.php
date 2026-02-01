<!-- 📊 RESUMEN EJECUTIVO PREMIUM -->
<div class="stats-grid"
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stat-card"
        style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 25px; border-radius: 24px; box-shadow: var(--glass-shadow); display: flex; align-items: center; gap: 20px;">
        <div
            style="width: 50px; height: 50px; background: rgba(41, 56, 135, 0.1); color: var(--accent-color); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <div>
            <p
                style="margin: 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Cotizaciones Total</p>
            <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);">
                <?= count($cotizaciones) ?></h3>
        </div>
    </div>
    <div class="stat-card"
        style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 25px; border-radius: 24px; box-shadow: var(--glass-shadow); display: flex; align-items: center; gap: 20px;">
        <div
            style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-check-double"></i></div>
        <div>
            <p
                style="margin: 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Aprobadas</p>
            <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);"><?php
            $aprobadas = array_filter($cotizaciones, fn($c) => $c['estatus'] == 'Aprobada' || $c['estatus'] == 'Convertida');
            echo count($aprobadas);
            ?></h3>
        </div>
    </div>
    <div class="stat-card"
        style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); padding: 25px; border-radius: 24px; box-shadow: var(--glass-shadow); display: flex; align-items: center; gap: 20px;">
        <div
            style="width: 50px; height: 50px; background: rgba(227, 81, 86, 0.1); color: var(--accent-secondary); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
            <i class="fas fa-clock"></i></div>
        <div>
            <p
                style="margin: 0; font-size: 11px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">
                Pendientes</p>
            <h3 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary);"><?php
            $pendientes = array_filter($cotizaciones, fn($c) => $c['estatus'] == 'Borrador');
            echo count($pendientes);
            ?></h3>
        </div>
    </div>
</div>

<!-- 🔝 BARRA DE ACCIONES -->
<div class="header-actions"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div>
        <h2 style="margin: 0; font-weight: 800; color: var(--text-primary); font-size: 28px; letter-spacing: -1px;">
            Ventas y Cotizaciones</h2>
        <p style="margin: 5px 0 0 0; color: var(--text-secondary); font-size: 14px;">Gestiona tus ofertas comerciales y
            conviértelas en ventas.</p>
    </div>
    <button class="btn btn-primary" onclick="openQuoteOverlay()"
        style="display: flex; align-items: center; gap: 10px; padding: 15px 30px; border-radius: 18px; background: var(--accent-color); box-shadow: 0 10px 25px rgba(41, 56, 135, 0.25);">
        <i class="fas fa-plus-circle" style="font-size: 18px;"></i>
        <span style="font-weight: 700;">Nueva Cotización</span>
    </button>
</div>

<!-- 📋 LISTADO PREMIUM -->
<div class="card"
    style="background: var(--glass-bg); backdrop-filter: var(--glass-blur); border: 1px solid var(--glass-border); border-radius: 28px; box-shadow: var(--glass-shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: rgba(41, 56, 135, 0.03); border-bottom: 1px solid var(--glass-border);">
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Folio / Versión</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Cliente</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Emisión / Vence</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Monto Total</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
                    Estatus</th>
                <th
                    style="padding: 20px 25px; font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; text-align: right;">
                    Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($cotizaciones)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 100px 25px;">
                            <i class="fas fa-folder-open"
                                style="font-size: 50px; opacity: 0.1; display: block; margin-bottom: 20px;"></i>
                            Aún no tienes cotizaciones registradas.
                        </td>
                    </tr>
            <?php else: ?>
                    <?php foreach ($cotizaciones as $c):
                        $estatusColors = [
                            'Borrador' => ['bg' => 'rgba(99, 102, 241, 0.1)', 'text' => '#6366f1', 'icon' => 'fa-edit'],
                            'Aprobada' => ['bg' => 'rgba(16, 185, 129, 0.1)', 'text' => '#10b981', 'icon' => 'fa-check-circle'],
                            'Convertida' => ['bg' => 'rgba(41, 56, 135, 0.1)', 'text' => 'var(--accent-color)', 'icon' => 'fa-rocket'],
                            'Cancelada' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444', 'icon' => 'fa-times-circle']
                        ];
                        $st = $estatusColors[$c['estatus']] ?? $estatusColors['Borrador'];
                        ?>
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.03); transition: all 0.3s;"
                                onmouseover="this.style.background='rgba(41, 56, 135, 0.01)'"
                                onmouseout="this.style.background='transparent'">
                                <td style="padding: 20px 25px;">
                                    <div style="font-weight: 800; color: var(--text-primary); font-size: 15px;"><?= $c['folio'] ?></div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">Versión: <?= $c['version'] ?></div>
                                </td>
                                <td style="padding: 20px 25px;">
                                    <div style="font-weight: 600; color: var(--text-primary);"><?= $c['nombre_razon_social'] ?></div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">ID Cliente: #<?= $c['cliente_id'] ?>
                                    </div>
                                </td>
                                <td style="padding: 20px 25px;">
                                    <div style="font-size: 13px; color: var(--text-primary);">
                                        <?= date('d/m/Y', strtotime($c['fecha_emision'])) ?></div>
                                    <div style="font-size: 11px; color: var(--accent-secondary); font-weight: 600;">Exp:
                                        <?= date('d/m/Y', strtotime($c['fecha_vencimiento'])) ?></div>
                                </td>
                                <td style="padding: 20px 25px;">
                                    <div style="font-weight: 900; color: var(--text-primary); font-size: 16px;">
                                        $<?= number_format($c['total'], 2) ?></div>
                                    <div style="font-size: 10px; color: #94a3b8;">Incluye IVA</div>
                                </td>
                                <td style="padding: 20px 25px;">
                                    <span
                                        style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 10px; font-size: 11px; font-weight: 800; background: <?= $st['bg'] ?>; color: <?= $st['text'] ?>; text-transform: uppercase;">
                                        <i class="fas <?= $st['icon'] ?>"></i> <?= $c['estatus'] ?>
                                    </span>
                                </td>
                                <td style="padding: 20px 25px; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <?php if ($c['estatus'] == 'Borrador'): ?>
                                            <a title="Aprobar para Venta" href="index.php?controller=Ventas&action=approve&id=<?= $c['id'] ?>" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #10b981; color: white; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);"><i class="fas fa-check"></i></a>
                                        <?php elseif ($c['estatus'] == 'Aprobada'): ?>
                                            <a title="Convertir a Pedido" href="index.php?controller=Ventas&action=convertToPedido&id=<?= $c['id'] ?>" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: var(--accent-color); color: white; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 10px rgba(41, 56, 135, 0.2);"><i class="fas fa-rocket"></i></a>
                                            <a title="Crear Nueva Versión" href="index.php?controller=Ventas&action=newVersion&id=<?= $c['id'] ?>" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #f59e0b; color: white; border-radius: 10px; text-decoration: none; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);"><i class="fas fa-layer-group"></i></a>
                                        <?php endif; ?>
                                        <button onclick="window.print()" title="Imprimir / PDF" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; color: var(--text-primary); border: none; border-radius: 10px; cursor: pointer;"><i class="fas fa-file-pdf"></i></button>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<!-- 🎭 OVERLAY DEL CREADOR DE COTIZACIONES DINÁMICO -->
<div id="quoteOverlay" class="edit-overlay" onclick="closeQuoteOverlay(event)">
    <div class="edit-panel" style="max-width: 1000px;" onclick="event.stopPropagation()">
        <div id="quoteOverlayContent">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
                <div>
                    <h2 style="font-weight: 800; color: var(--text-primary); margin: 0; font-size: 26px; letter-spacing: -1px;">Nueva Cotización Premium</h2>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 14px;">Arma tu oferta formal agregando múltiples productos.</p>
                </div>
                <button onclick="closeQuoteOverlay(null, true)" style="background: #f1f5f9; border: none; width: 50px; height: 50px; border-radius: 50%; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>

            <form action="index.php?controller=Ventas&action=create" method="POST" id="quoteForm">
                <input type="hidden" name="items_json" id="itemsJsonInput">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                    <div>
                        <label class="form-label">CLIENTE / PROSPECTO</label>
                        <select name="cliente_id" required class="form-input" style="font-weight: 700;">
                            <option value="">Seleccionar Cliente...</option>
                            <?php foreach ($clientes as $cl): ?>
                                    <option value="<?= $cl['id'] ?>"><?= $cl['nombre_razon_social'] ?> (<?= $cl['rfc'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">VIGENCIA (DIAS)</label>
                        <select name="vigencia" class="form-input">
                            <option value="15">15 Días Naturales</option>
                            <option value="30">30 Días Naturales</option>
                            <option value="5">5 Días (Urgencia)</option>
                        </select>
                    </div>
                </div>

                <!-- 🛒 SELECTOR DE PRODUCTOS -->
                <div style="background: rgba(41, 56, 135, 0.03); padding: 25px; border-radius: 25px; border: 1px dashed var(--accent-color); margin-bottom: 30px;">
                    <h4 style="margin: 0 0 15px 0; font-size: 14px; color: var(--accent-color); text-transform: uppercase; letter-spacing: 1px;">Agregar Productos a la Oferta</h4>
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 0.5fr; gap: 15px; align-items: flex-end;">
                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: var(--text-secondary);">BUSCAR PRODUCTO</label>
                            <select id="productSelect" class="form-input" onchange="updatePriceHint()">
                                <option value="">Selecciona un item...</option>
                                <?php foreach ($productos as $prod): ?>
                                        <option value="<?= $prod['id'] ?>" data-price="<?= $prod['precio_venta'] ?>" data-sku="<?= $prod['sku'] ?>">
                                            <?= $prod['sku'] ?> - <?= $prod['descripcion'] ?>
                                        </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: var(--text-secondary);">CANTIDAD</label>
                            <input type="number" id="itemQty" value="1" min="1" class="form-input">
                        </div>
                        <div>
                            <label style="font-size: 11px; font-weight: 700; color: var(--text-secondary);">PRECIO UNIT. ($)</label>
                            <input type="number" id="itemPrice" step="0.01" class="form-input">
                        </div>
                        <button type="button" onclick="addItem()" style="background: var(--accent-color); color: white; border: none; height: 50px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <!-- 📋 TABLA DE PARTIDAS -->
                <div style="margin-bottom: 30px; max-height: 300px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse;" id="itemsTable">
                        <thead>
                            <tr style="border-bottom: 2px solid #f1f5f9;">
                                <th style="padding: 12px; text-align: left; font-size: 12px; color: var(--text-secondary);">SKU / DESCRIPCIÓN</th>
                                <th style="padding: 12px; text-align: center; font-size: 12px; color: var(--text-secondary);">CANT.</th>
                                <th style="padding: 12px; text-align: right; font-size: 12px; color: var(--text-secondary);">P. UNIT</th>
                                <th style="padding: 12px; text-align: right; font-size: 12px; color: var(--text-secondary);">TOTAL</th>
                                <th style="padding: 12px;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Items dinámicos aquí -->
                        </tbody>
                    </table>
                </div>

                <!-- 💰 TOTALES -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                    <div>
                        <label class="form-label">DESCUENTO GENERAL (%)</label>
                        <input type="number" name="descuento_porcentaje" id="globalDiscount" value="0" min="0" max="100" class="form-input" oninput="calculateTotals()" style="width: 100px;">
                        <p style="font-size: 12px; color: var(--text-secondary); margin-top: 10px;">El descuento se aplicará sobre el subtotal antes de impuestos.</p>
                    </div>
                    <div style="background: #f8fafc; padding: 25px; border-radius: 20px; border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: var(--text-secondary); font-size: 14px;"><span>Subtotal:</span><span id="lblSubtotal">$0.00</span></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: var(--accent-secondary); font-size: 14px;"><span>Descuento:</span><span id="lblDiscount">-$0.00</span></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px; color: var(--text-secondary); font-size: 14px;"><span>IVA (16%):</span><span id="lblIva">$0.00</span></div>
                        <div style="display: flex; justify-content: space-between; padding-top: 15px; border-top: 2px solid #e2e8f0;">
                            <span style="font-weight: 800; color: var(--text-primary); font-size: 18px;">TOTAL FINAL:</span>
                            <span id="lblTotal" style="font-weight: 900; color: var(--accent-color); font-size: 22px;">$0.00</span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 40px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                    <button type="button" class="btn" onclick="closeQuoteOverlay(null, true)">Descartar</button>
                    <button type="submit" class="btn btn-primary" style="padding: 15px 40px; border-radius: 15px; font-weight: 800;"><i class="fas fa-save"></i> GENERAR COTIZACIÓN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let quoteItems = [];

    function openQuoteOverlay() {
        document.getElementById('quoteOverlay').classList.add('active');
        document.body.classList.add('no-scroll');
    }

    function closeQuoteOverlay(e, force = false) {
        if (force || (e && e.target.id === 'quoteOverlay')) {
            document.getElementById('quoteOverlay').classList.remove('active');
            document.body.classList.remove('no-scroll');
        }
    }

    function updatePriceHint() {
        const select = document.getElementById('productSelect');
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('itemPrice').value = selectedOption.dataset.price;
        }
    }

    function addItem() {
        const select = document.getElementById('productSelect');
        const qty = parseInt(document.getElementById('itemQty').value);
        const price = parseFloat(document.getElementById('itemPrice').value);
        const selected = select.options[select.selectedIndex];

        if (!selected.value || isNaN(qty) || isNaN(price)) {
            alert("Por favor selecciona un producto, cantidad y precio válido.");
            return;
        }

        quoteItems.push({
            producto_id: selected.value,
            sku: selected.dataset.sku,
            descripcion: selected.text.split(' - ')[1],
            cantidad: qty,
            precio_unitario: price,
            total: qty * price
        });

        renderItems();
        select.value = "";
        document.getElementById('itemQty').value = 1;
        document.getElementById('itemPrice').value = "";
    }

    function removeItem(index) {
        quoteItems.splice(index, 1);
        renderItems();
    }

    function renderItems() {
        const body = document.getElementById('itemsBody');
        body.innerHTML = "";
        
        quoteItems.forEach((item, index) => {
            const row = `
                <tr style="border-bottom: 1px solid #f8fafc;">
                    <td style="padding: 12px;"><div style="font-weight: 700;">${item.sku}</div><div style="font-size: 11px; color: #64748b;">${item.descripcion}</div></td>
                    <td style="padding: 12px; text-align: center; font-weight: 600;">${item.cantidad}</td>
                    <td style="padding: 12px; text-align: right;">$${item.precio_unitario.toFixed(2)}</td>
                    <td style="padding: 12px; text-align: right; font-weight: 800;">$${item.total.toFixed(2)}</td>
                    <td style="padding: 12px; text-align: right;"><button type="button" onclick="removeItem(${index})" style="background: none; border: none; color: #ef4444; cursor: pointer;"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            body.innerHTML += row;
        });

        calculateTotals();
    }

    function calculateTotals() {
        let subtotal = quoteItems.reduce((acc, item) => acc + item.total, 0);
        let discPercent = parseFloat(document.getElementById('globalDiscount').value) || 0;
        let discount = (subtotal * discPercent) / 100;
        let subtotalConDesc = subtotal - discount;
        let iva = subtotalConDesc * 0.16;
        let total = subtotalConDesc + iva;

        document.getElementById('lblSubtotal').innerText = `$${subtotal.toLocaleString('es-MX', {minimumFractionDigits:2})}`;
        document.getElementById('lblDiscount').innerText = `-$${discount.toLocaleString('es-MX', {minimumFractionDigits:2})}`;
        document.getElementById('lblIva').innerText = `$${iva.toLocaleString('es-MX', {minimumFractionDigits:2})}`;
        document.getElementById('lblTotal').innerText = `$${total.toLocaleString('es-MX', {minimumFractionDigits:2})}`;

        // Guardar en el input oculto para el enviarlo al backend
        document.getElementById('itemsJsonInput').value = JSON.stringify(quoteItems);
    }
</script>