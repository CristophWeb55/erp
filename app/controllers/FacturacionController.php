<?php

require_once '../app/models/Facturacion.php';

class FacturacionController extends Controller
{
    public function index()
    {
        $facturaModel = new Facturacion();
        $facturas = $facturaModel->getAll();

        $data = [
            'pageTitle' => 'Facturación y CFDI',
            'controller' => 'Facturacion',
            'facturas' => $facturas
        ];

        $this->view('facturacion/index', $data);
    }

    public function generate()
    {
        $cotizacion_id = $_GET['cotizacion_id'];
        $facturaModel = new Facturacion();

        if ($facturaModel->createFromQuote($cotizacion_id)) {
            header('Location: index.php?controller=Facturacion&action=index');
            exit;
        } else {
            die("Error generating invoice. Check stock for products requiring pedimento.");
        }
    }

    public function show()
    {
        $id = $_GET['id'];
        $facturaModel = new Facturacion();
        $factura = $facturaModel->getDetail($id);

        $data = [
            'pageTitle' => 'Detalle de Factura (Timbrado Simulado)',
            'controller' => 'Facturacion',
            'factura' => $factura['header'],
            'detalles' => $factura['details']
        ];

        $this->view('facturacion/detalle', $data);
    }
}
