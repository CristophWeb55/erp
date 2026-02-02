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

            $data = [
                'transportista' => $_POST['transportista'] ?? '',
                'placas_vehiculo' => $_POST['placas_vehiculo'] ?? '',
                'numero_guia' => $_POST['numero_guia'] ?? '',
                'persona_recibe' => $_POST['persona_recibe'] ?? '',
                'telefono_contacto' => $_POST['telefono_contacto'] ?? '',
                'bultos' => $_POST['bultos'] ?? 1,
                'peso_total' => $_POST['peso_total'] ?? 0,
                'notas_entrega' => $_POST['notas_entrega'] ?? '',
                'evidencia_firma' => $_POST['signature_data'] ?? '',
                'evidencia_foto' => $_POST['photo_data'] ?? ''
            ];

            $logisticaModel = new Logistica();
            if ($logisticaModel->confirmDelivery($id, $data)) {
                header('Location: index.php?controller=Logistica&action=detalle&id=' . $id . '&msg=delivered');
            } else {
                header('Location: index.php?controller=Logistica&action=detalle&id=' . $id . '&error=confirm_failed');
            }
            exit;
        }
    }
}
