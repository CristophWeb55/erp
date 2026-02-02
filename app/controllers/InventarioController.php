<?php

require_once '../app/models/Inventario.php';
require_once '../app/models/Productos.php';

class InventarioController extends Controller
{
    public function index()
    {
        $inventarioModel = new Inventario();
        $stock = $inventarioModel->getStockGeneral();
        $stats = $inventarioModel->getStats();

        $data = [
            'pageTitle' => 'Control de Inventarios y Existencias',
            'controller' => 'Inventario',
            'stock' => $stock,
            'stats' => $stats
        ];

        $this->view('inventario/index', $data);
    }

    public function detalle()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $inventarioModel = new Inventario();
            $productoModel = new Productos();

            $producto = $productoModel->getById($id);
            $lotes = $inventarioModel->getKardex($id);

            if ($producto) {
                $data = [
                    'pageTitle' => 'Kardex de Producto: ' . $producto['sku'],
                    'controller' => 'Inventario',
                    'producto' => $producto,
                    'lotes' => $lotes
                ];
                $this->view('inventario/detalle', $data);
                return;
            }
        }
        header('Location: index.php?controller=Inventario&action=index');
    }

    public function adjust()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoId = $_POST['producto_id'];
            $tipo = $_POST['tipo_ajuste']; // 'entrada' o 'salida'
            $cantidad = (int) $_POST['cantidad'];
            $pedimento = $_POST['pedimento'] ?? 'AJUSTE-MANUAL';

            if ($tipo === 'salida') {
                $cantidad = -$cantidad;
            }

            $inventarioModel = new Inventario();
            if (
                $inventarioModel->adjustStock([
                    'producto_id' => $productoId,
                    'cantidad' => $cantidad,
                    'pedimento' => $pedimento
                ])
            ) {
                header('Location: index.php?controller=Inventario&action=detalle&id=' . $productoId . '&msg=adjusted');
            } else {
                header('Location: index.php?controller=Inventario&action=detalle&id=' . $productoId . '&error=adjust_failed');
            }
            exit;
        }
    }
}
