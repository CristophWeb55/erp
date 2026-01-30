<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    <!-- Welcome Card -->
    <div class="card"
        style="grid-column: span 2; display: flex; align-items: center; justify-content: space-between; overflow: hidden; position: relative; background: linear-gradient(135deg, rgba(41, 56, 135, 0.1), rgba(227, 81, 86, 0.1));">
        <div style="z-index: 1; padding: 10px;">
            <h1 style="font-size: 28px; margin-bottom: 10px;">Bienvenido a URICA ERP</h1>
            <p style="color: var(--text-secondary); max-width: 400px; margin-bottom: 20px;">Tu plataforma centralizada
                para el control eléctrico y trazabilidad fiscal estratégica.</p>
            <button class="btn btn-primary">Panel de Control</button>
        </div>
        <div style="z-index: 0; opacity: 0.15;">
            <img src="assets/logo.png"
                style="width: 300px; position: absolute; right: -20px; top: 20px; filter: grayscale(1) brightness(0.5);">
        </div>
    </div>


    <!-- Quick Stats Card -->
    <div class="card">
        <h3
            style="margin-bottom: 20px; font-size: 16px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
            Conversión</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>Cotizaciones</span>
                <span style="font-weight: 700;">83%</span>
            </div>
            <div style="height: 8px; background: rgba(0,0,0,0.05); border-radius: 4px; overflow: hidden;">
                <div style="width: 83%; height: 100%; background: #10b981;"></div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>Ventas</span>
                <span style="font-weight: 700;">70%</span>
            </div>
            <div style="height: 8px; background: rgba(0,0,0,0.05); border-radius: 4px; overflow: hidden;">
                <div style="width: 70%; height: 100%; background: #6366f1;"></div>
            </div>
        </div>
    </div>

    <!-- Inventory Alert Card -->
    <div class="card">
        <h3
            style="margin-bottom: 20px; font-size: 16px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">
            Inventario Crítico</h3>
        <div style="text-align: center; padding: 20px;">
            <i class="fas fa-boxes" style="font-size: 40px; color: #f59e0b; margin-bottom: 15px;"></i>
            <p style="font-weight: 600; font-size: 24px;">12</p>
            <p style="color: var(--text-secondary); font-size: 14px;">Productos requieren pedimento</p>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="card" style="grid-column: span 3;">
        <h3 style="margin-bottom: 20px;">Actividad Comercial Reciente</h3>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Cliente/Proveeror</th>
                    <th>Monto</th>
                    <th>Pedimento</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>29 Ene</td>
                    <td>Cotización #4502</td>
                    <td>Corporativo Alfa</td>
                    <td>$45,200.00</td>
                    <td><span style="color: var(--text-secondary);">N/A</span></td>
                    <td><span
                            style="padding: 5px 10px; background: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 6px; font-size: 12px; font-weight: 600;">BORRADOR</span>
                    </td>
                </tr>
                <tr>
                    <td>28 Ene</td>
                    <td>Entrada de Almacén</td>
                    <td>Global Imp Ltda</td>
                    <td>$120,500.00</td>
                    <td><span style="font-family: monospace; font-weight: 600; color: #000;">24 47 3009 8001234</span>
                    </td>
                    <td><span
                            style="padding: 5px 10px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 6px; font-size: 12px; font-weight: 600;">RECIBIDA</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>