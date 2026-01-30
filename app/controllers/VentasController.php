<?php

require_once '../app/models/Ventas.php';
require_once '../app/models/Terceros.php';
require_once '../app/models/Productos.php';

class VentasController extends Controller
{
    public function index()
    {
        $ventasModel = new Ventas();
        $cotizaciones = $ventasModel->getAll();

        $tercerosModel = new Terceros();
        $clientes = $tercerosModel->getAll();

        $productosModel = new Productos();
        $productos = $productosModel->getAll();

        $data = [
            'pageTitle' => 'Gestión de Ventas y Cotizaciones',
            'controller' => 'Ventas',
            'cotizaciones' => $cotizaciones,
            'clientes' => $clientes,
            'productos' => $productos
        ];

        $this->view('ventas/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ventasModel = new Ventas();
            $data = [
                'cliente_id' => $_POST['cliente_id'],
                'fecha_emision' => $_POST['fecha_emision'],
                'producto_id' => $_POST['producto_id'],
                'cantidad' => $_POST['cantidad'],
                'precio_unitario' => $_POST['precio_unitario']
            ];

            if ($ventasModel->create($data)) {
                header('Location: index.php?controller=Ventas&action=index');
                exit;
            }
        }
    }

    public function approve()
    {
        $id = $_GET['id'];
        $ventasModel = new Ventas();
        if ($ventasModel->approve($id)) {
            header('Location: index.php?controller=Ventas&action=index');
            exit;
        }
    }
}
