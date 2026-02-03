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

            $imagen_url = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $filename = 'prod_' . uniqid() . '.' . $ext;
                $uploadDir = 'uploads/productos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $target = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
                    $imagen_url = $target;
                }
            }

            $data = [
                'sku' => $_POST['sku'],
                'descripcion' => $_POST['descripcion'],
                'precio_venta' => $_POST['precio_venta'],
                'stock_minimo' => $_POST['stock_minimo'] ?? 10,
                'stock_inicial' => $_POST['stock_inicial'] ?? 0,
                'imagen_url' => $imagen_url,
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

            // Obtener producto actual para conservar la imagen si no se sube una nueva
            $productoActual = $productosModel->getById($id);
            $imagen_url = $productoActual['imagen_url'] ?? null;

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $filename = 'prod_' . uniqid() . '.' . $ext;
                $uploadDir = 'uploads/productos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $target = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
                    $imagen_url = $target;
                }
            }

            $data = [
                'sku' => $_POST['sku'],
                'descripcion' => $_POST['descripcion'],
                'precio_venta' => $_POST['precio_venta'],
                'stock_minimo' => $_POST['stock_minimo'] ?? 10,
                'stock_actual' => $_POST['stock_actual'] ?? null,
                'imagen_url' => $imagen_url,
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

    public function getOne()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->json(['error' => 'ID missing']);
        }

        $productosModel = new Productos();
        $producto = $productosModel->getById($id);

        $this->json($producto);
    }
}


