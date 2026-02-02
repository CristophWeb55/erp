<?php

require_once '../app/models/Logistica.php';
require_once '../app/models/Pedidos.php';

class LogisticaController extends Controller
{
    public function index()
    {
        $logisticaModel = new Logistica();
        $entregas = $logisticaModel->getAll();
        $pendientes = $logisticaModel->getPendingOrders();

        $data = [
            'pageTitle' => 'Logística y Seguimiento de Entregas',
            'controller' => 'Logistica',
            'entregas' => $entregas,
            'pendientes' => $pendientes
        ];

        $this->view('entregas/index', $data);
    }

    public function detalle()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $logisticaModel = new Logistica();
            $entrega = $logisticaModel->getById($id);

            if ($entrega) {
                $data = [
                    'pageTitle' => 'Detalle de Entrega: ' . $entrega['folio'],
                    'controller' => 'Logistica',
                    'entrega' => $entrega
                ];
                $this->view('entregas/view', $data);
                return;
            }
        }
        header('Location: index.php?controller=Logistica&action=index');
    }

    public function generate()
    {
        if (isset($_GET['pedido_id'])) {
            $pedidoId = $_GET['pedido_id'];
            $logisticaModel = new Logistica();

            $entregaId = $logisticaModel->createFromPedido($pedidoId);

            if ($entregaId) {
                header('Location: index.php?controller=Logistica&action=detalle&id=' . $entregaId . '&msg=created');
            } else {
                header('Location: index.php?controller=Pedidos&action=index&error=entrega_failed');
            }
            exit;
        }
    }

    public function confirm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $firma = $_POST['signature_data'];
            $notas = $_POST['notas_entrega'] ?? '';

            $logisticaModel = new Logistica();
            if ($logisticaModel->confirmDelivery($id, $firma, $notas)) {
                header('Location: index.php?controller=Logistica&action=detalle&id=' . $id . '&msg=delivered');
            } else {
                header('Location: index.php?controller=Logistica&action=detalle&id=' . $id . '&error=confirm_failed');
            }
            exit;
        }
    }
}
