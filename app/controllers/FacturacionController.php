<?php
require_once '../app/models/Facturacion.php';
require_once '../app/models/Pedidos.php';

class FacturacionController extends Controller
{
    public function index()
    {
        $model = new Facturacion();
        $facturas = $model->getAll();

        $data = [
            'pageTitle' => 'Facturación Electrónica',
            'controller' => 'Facturacion',
            'facturas' => $facturas
        ];
        $this->view('facturacion/index', $data);
    }

    public function generar()
    {
        if (isset($_GET['pedido_id'])) {
            try {
                $model = new Facturacion();
                $facturaId = $model->createFromOrder($_GET['pedido_id']);

                if ($facturaId) {
                    header('Location: index.php?controller=Facturacion&action=ver&id=' . $facturaId . '&msg=created');
                } else {
                    header('Location: index.php?controller=Pedidos&action=detalle&id=' . $_GET['pedido_id'] . '&error=No se pudo generar la factura');
                }
            } catch (Exception $e) {
                header('Location: index.php?controller=Pedidos&action=detalle&id=' . $_GET['pedido_id'] . '&error=' . urlencode($e->getMessage()));
            }
        } else {
            header('Location: index.php?controller=Pedidos');
        }
    }

    public function ver()
    {
        if (isset($_GET['id'])) {
            $model = new Facturacion();
            $factura = $model->getById($_GET['id']);

            if ($factura) {
                $data = [
                    'pageTitle' => 'Factura ' . substr($factura['folio_fiscal_uuid'], 0, 8),
                    'controller' => 'Facturacion',
                    'factura' => $factura
                ];
                $this->view('facturacion/view', $data);
            } else {
                header('Location: index.php?controller=Facturacion');
            }
        }
    }

    // Generar la representación visual de la factura (PDF)
    public function exportPDF()
    {
        if (isset($_GET['id'])) {
            $model = new Facturacion();
            $factura = $model->getById($_GET['id']);

            if ($factura) {
                $data = [
                    'fact' => $factura
                ];
                $this->rawView('facturacion/export_pdf', $data);
                return;
            }
        }
        echo "Factura no encontrada";
    }

    // Simula imprimir
    public function print()
    {
        $this->exportPDF();
    }

    public function enviar()
    {
        if (isset($_GET['id'])) {
            sleep(1);
            header('Location: index.php?controller=Facturacion&action=ver&id=' . $_GET['id'] . '&msg=email_sent');
        } else {
            header('Location: index.php?controller=Facturacion');
        }
    }
}
