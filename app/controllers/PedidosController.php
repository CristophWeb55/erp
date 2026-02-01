<?php

require_once '../app/models/Pedidos.php';
require_once '../app/models/Ventas.php'; // Para acceder a cotizaciones si es necesario

class PedidosController extends Controller
{
    public function index()
    {
        $pedidosModel = new Pedidos();
        $pedidos = $pedidosModel->getAll();

        $data = [
            'pageTitle' => 'Gestión de Pedidos de Venta',
            'controller' => 'Pedidos',
            'pedidos' => $pedidos
        ];

        $this->view('pedidos/index', $data);
    }

    public function create_from_quote()
    {
        if (isset($_GET['quote_id'])) {
            $quoteId = $_GET['quote_id'];
            $pedidosModel = new Pedidos();

            // Verificar si ya existe un pedido para esta cotización (opcional, por ahora permitimos múltiples)
            // Lógica de conversión
            $pedidoId = $pedidosModel->createFromQuote($quoteId);

            if ($pedidoId) {
                // Redirigir al dashboard de pedidos con mensaje
                header('Location: index.php?controller=Pedidos&action=index&msg=created');
            } else {
                header('Location: index.php?controller=Ventas&action=index&error=conversion_failed');
            }
            exit;
        }
        header('Location: index.php?controller=Ventas&action=index');
    }

    public function fulfill()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pedidosModel = new Pedidos();

            if ($pedidosModel->fulfillOrder($id)) {
                header('Location: index.php?controller=Pedidos&action=index&msg=fulfilled');
            } else {
                header('Location: index.php?controller=Pedidos&action=index&error=stock_error');
            }
            exit;
        }
    }

    public function detalle()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $pedidosModel = new Pedidos();
            $pedido = $pedidosModel->getById($id);

            if (!$pedido) {
                header('Location: index.php?controller=Pedidos&action=index');
                exit;
            }

            $data = [
                'pageTitle' => 'Detalle de Pedido: ' . $pedido['folio'],
                'controller' => 'Pedidos',
                'pedido' => $pedido
            ];

            $this->view('pedidos/view', $data);
        } else {
            header('Location: index.php?controller=Pedidos&action=index');
        }
    }
}
