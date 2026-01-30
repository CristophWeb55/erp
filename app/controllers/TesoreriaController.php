<?php

require_once '../app/models/Facturacion.php';
require_once '../app/models/Tesoreria.php';

class TesoreriaController extends Controller
{
    public function index()
    {
        $facturaModel = new Facturacion();
        $facturas = $facturaModel->getAll(); // In real app, filter by status Pendiente

        $data = [
            'pageTitle' => 'Cobranza y Tesorería',
            'controller' => 'Tesoreria',
            'facturas' => $facturas
        ];

        $this->view('tesoreria/index', $data);
    }

    public function pay()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tesoreriaModel = new Tesoreria();
            $data = [
                'factura_id' => $_POST['factura_id'],
                'fecha_pago' => $_POST['fecha_pago'],
                'monto' => $_POST['monto'],
                'forma_pago' => $_POST['forma_pago'],
                'referencia' => $_POST['referencia']
            ];

            if ($tesoreriaModel->registerPayment($data)) {
                header('Location: index.php?controller=Tesoreria&action=index');
                exit;
            }
        }
    }
}
