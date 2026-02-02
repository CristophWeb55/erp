<?php

require_once '../app/models/Transportistas.php';

class TransportistasController extends Controller
{
    public function index()
    {
        $model = new Transportistas();
        $transportistas = $model->getAll();

        $data = [
            'pageTitle' => 'Catálogo de Transportistas',
            'controller' => 'Transportistas',
            'transportistas' => $transportistas
        ];

        $this->view('transportistas/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Transportistas();
            if ($model->create($_POST)) {
                header('Location: index.php?controller=Transportistas&action=index&msg=created');
            } else {
                header('Location: index.php?controller=Transportistas&action=index&error=create_failed');
            }
            exit;
        }
    }

    public function edit()
    {
        if (isset($_GET['id'])) {
            $model = new Transportistas();
            $item = $model->getById($_GET['id']);
            echo json_encode($item);
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Transportistas();
            $id = $_POST['id'];
            if ($model->update($id, $_POST)) {
                header('Location: index.php?controller=Transportistas&action=index&msg=updated');
            } else {
                header('Location: index.php?controller=Transportistas&action=index&error=update_failed');
            }
            exit;
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $model = new Transportistas();
            if ($model->delete($_GET['id'])) {
                header('Location: index.php?controller=Transportistas&action=index&msg=deleted');
            } else {
                header('Location: index.php?controller=Transportistas&action=index&error=delete_failed');
            }
            exit;
        }
    }
}
