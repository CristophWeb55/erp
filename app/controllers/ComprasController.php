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

        $data = [
            'pageTitle' => 'Gestión de Compras',
            'controller' => 'Compras',
            'compras' => $compras
        ];

        $this->view('compras/index', $data);
    }

    public function create()
    {
        $tercerosModel = new Terceros();
        $productosModel = new Productos();

        $proveedores = $tercerosModel->getProveedores();
        $productos = $productosModel->getAll(); // Asumiendo que existe

        $data = [
            'pageTitle' => 'Nueva Orden de Compra',
            'controller' => 'Compras',
            'proveedores' => $proveedores,
            'productos' => $productos
        ];

        $this->view('compras/create', $data);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'proveedor_id' => $_POST['proveedor_id'],
                'fecha_compra' => $_POST['fecha_compra'],
                'referencia' => $_POST['referencia'],
                'observaciones' => $_POST['observaciones'],
                'total' => 0 // Se calcula abajo
            ];

            // Procesar items
            $items = [];
            $total = 0;
            if (isset($_POST['productos']) && is_array($_POST['productos'])) {
                foreach ($_POST['productos'] as $prodId => $cant) {
                    if ($cant > 0) {
                        $costo = $_POST['costos'][$prodId];
                        $subtotal = $cant * $costo;
                        $items[] = [
                            'producto_id' => $prodId,
                            'cantidad' => $cant,
                            'costo_unitario' => $costo,
                            'subtotal' => $subtotal
                        ];
                        $total += $subtotal;
                    }
                }
            }

            $data['total'] = $total;

            $comprasModel = new Compras();
            $id = $comprasModel->create($data, $items);

            if ($id) {
                header('Location: index.php?controller=Compras&action=detalle&id=' . $id . '&msg=created');
            } else {
                // Manejar error
                header('Location: index.php?controller=Compras&action=create&error=failed');
            }
        }
    }

    public function detalle()
    {
        if (isset($_GET['id'])) {
            $comprasModel = new Compras();
            $compra = $comprasModel->getById($_GET['id']);

            if ($compra) {
                $data = [
                    'pageTitle' => 'Orden de Compra #' . $compra['id'],
                    'controller' => 'Compras',
                    'compra' => $compra
                ];
                $this->view('compras/view', $data);
                return;
            }
        }
        header('Location: index.php?controller=Compras&action=index');
    }

    public function receive()
    {
        if (isset($_GET['id'])) {
            $comprasModel = new Compras();
            if ($comprasModel->receiveOrder($_GET['id'])) {
                header('Location: index.php?controller=Compras&action=detalle&id=' . $_GET['id'] . '&msg=received');
            } else {
                header('Location: index.php?controller=Compras&action=detalle&id=' . $_GET['id'] . '&error=receive_failed');
            }
        }
    }
}
