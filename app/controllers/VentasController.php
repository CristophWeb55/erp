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

            // Recibir items como array (desde PHP o JSON)
            $items = [];
            if (isset($_POST['items_json'])) {
                $items = json_decode($_POST['items_json'], true);
            } else {
                // Fallback para MVP anterior si es necesario
                $items[] = [
                    'producto_id' => $_POST['producto_id'],
                    'cantidad' => $_POST['cantidad'],
                    'precio_unitario' => $_POST['precio_unitario']
                ];
            }

            $data = [
                'cliente_id' => $_POST['cliente_id'],
                'moneda' => $_POST['moneda'] ?? 'MXN',
                'fecha_emision' => $_POST['fecha_emision'] ?? date('Y-m-d'),
                'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? date('Y-m-d', strtotime('+15 days')),
                'descuento_porcentaje' => $_POST['descuento_porcentaje'] ?? 0,
                'items' => $items
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

    public function convertToPedido()
    {
        $id = $_GET['id'];
        $ventasModel = new Ventas();
        if ($ventasModel->convertToPedido($id)) {
            header('Location: index.php?controller=Ventas&action=index&msg=converted');
            exit;
        } else {
            header('Location: index.php?controller=Ventas&action=index&error=conversion_failed');
            exit;
        }
    }

    public function newVersion()
    {
        $id = $_GET['id'];
        $ventasModel = new Ventas();
        if ($ventasModel->duplicateAsNewVersion($id)) {
            header('Location: index.php?controller=Ventas&action=index&msg=new_version_created');
            exit;
        } else {
            header('Location: index.php?controller=Ventas&action=index&error=version_failed');
            exit;
        }
    }

    public function exportPDF()
    {
        $id = $_GET['id'];
        $ventasModel = new Ventas();
        $cotizacion = $ventasModel->getOneWithDetails($id);

        if (!$cotizacion) {
            die("Cotización no encontrada");
        }

        $data = [
            'cot' => $cotizacion
        ];

        // Usamos una vista especial para PDF sin el layout normal de la app
        $this->view('ventas/export_pdf', $data);
    }
}


