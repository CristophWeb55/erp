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
                'stock_minimo' => $_POST['stock_minimo'] ?? 10,
                'imagen_url' => $_POST['imagen_url'] ?? null,
                'requiere_pedimento' => isset($_POST['requiere_pedimento']) ? 1 : 0
            ];

            if ($productosModel->create($data)) {
                header('Location: index.php?controller=Productos&action=index');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Productos&action=index');
            exit;
        }

        $productosModel = new Productos();
        $producto = $productosModel->getById($id);

        $data = [
            'pageTitle' => 'Editar Producto',
            'controller' => 'Productos',
            'producto' => $producto
        ];

        $this->view('productos/edit', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $productosModel = new Productos();
            $data = [
                'sku' => $_POST['sku'],
                'descripcion' => $_POST['descripcion'],
                'precio_venta' => $_POST['precio_venta'],
                'stock_minimo' => $_POST['stock_minimo'] ?? 10,
                'imagen_url' => $_POST['imagen_url'] ?? null,
                'requiere_pedimento' => isset($_POST['requiere_pedimento']) ? 1 : 0
            ];

            if ($productosModel->update($id, $data)) {
                header('Location: index.php?controller=Productos&action=index');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $productosModel = new Productos();
            $productosModel->delete($id);
        }
        header('Location: index.php?controller=Productos&action=index');
        exit;
    }

    public function search()
    {
        $query = $_GET['q'] ?? '';
        $productosModel = new Productos();
        $productos = $productosModel->search($query);

        header('Content-Type: application/json');
        echo json_encode($productos);
        exit;
    }
}

