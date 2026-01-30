<?php

require_once '../app/models/Compras.php';
require_once '../app/models/Terceros.php';
require_once '../app/models/Productos.php';

class ComprasController extends Controller
{
    public function index()
    {
        $comprasModel = new Compras();
        $compras = $comprasModel->getAll();

        $tercerosModel = new Terceros();
        $proveedores = $tercerosModel->getAll();

        $productosModel = new Productos();
        $productos = $productosModel->getAll();

        $data = [
            'pageTitle' => 'Órdenes de Compra y Entradas',
            'controller' => 'Compras',
            'compras' => $compras,
            'proveedores' => $proveedores,
            'productos' => $productos
        ];

        $this->view('compras/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comprasModel = new Compras();
            $data = [
                'proveedor_id' => $_POST['proveedor_id'],
                'fecha_compra' => $_POST['fecha_compra'],
                'referencia' => $_POST['referencia'],
                'total' => $_POST['total'],
                'producto_id' => $_POST['producto_id'],
                'cantidad' => $_POST['cantidad']
            ];

            if ($comprasModel->create($data)) {
                header('Location: index.php?controller=Compras&action=index');
                exit;
            }
        }
    }

    public function receiving()
    {
        $id = $_GET['id'];
        $comprasModel = new Compras();
        $compra = $comprasModel->getById($id);

        $data = [
            'pageTitle' => 'Recibir Mercancía (Capturar Pedimento)',
            'controller' => 'Compras',
            'compra' => $compra
        ];

        $this->view('compras/recepcion', $data);
    }

    public function process_receiving()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comprasModel = new Compras();
            $data = [
                'compra_id' => $_POST['compra_id'],
                'producto_id' => $_POST['producto_id'],
                'cantidad' => $_POST['cantidad'],
                'numero_pedimento' => $_POST['numero_pedimento'],
                'fecha_pedimento' => $_POST['fecha_pedimento'],
                'nombre_aduana' => $_POST['nombre_aduana']
            ];

            if ($comprasModel->receiveStock($data)) {
                header('Location: index.php?controller=Compras&action=index');
                exit;
            }
        }
    }
}
