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
            $model = new Facturacion();
            $facturaId = $model->createFromOrder($_GET['pedido_id']);

            if ($facturaId) {
                header('Location: index.php?controller=Facturacion&action=ver&id=' . $facturaId . '&msg=created');
            } else {
                header('Location: index.php?controller=Pedidos&action=view&id=' . $_GET['pedido_id'] . '&error=failed');
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

    // Simula imprimir
    public function print()
    {
        // En este MVP reusamos la vista 'ver' pero limpiaremos el layout en el futuro si es necesario
        // O imprimimos solo el frame
        $this->ver();
    }
}
