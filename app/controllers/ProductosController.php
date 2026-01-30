<?php

require_once '../app/models/Productos.php';

class ProductosController extends Controller
{
    public function index()
    {
        $productosModel = new Productos();
        $productos = $productosModel->getAll();

        $data = [
            'pageTitle' => 'Catálogo de Productos',
            'controller' => 'Productos',
            'productos' => $productos
        ];

        $this->view('productos/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productosModel = new Productos();
            $data = [
                'sku' => $_POST['sku'],
                'descripcion' => $_POST['descripcion'],
                'precio_venta' => $_POST['precio_venta'],
                'requiere_pedimento' => isset($_POST['requiere_pedimento']) ? 1 : 0
            ];

            if ($productosModel->create($data)) {
                header('Location: index.php?controller=Productos&action=index');
                exit;
            }
        }
    }
}
