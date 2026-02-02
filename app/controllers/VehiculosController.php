<?php

require_once '../app/models/Vehiculos.php';
require_once '../app/models/Transportistas.php';

class VehiculosController extends Controller
{
    public function index()
    {
        $vModel = new Vehiculos();
        $tModel = new Transportistas();

        $vehiculos = $vModel->getAll();
        $transportistas = $tModel->getActive();

        $data = [
            'pageTitle' => 'Catálogo de Vehículos',
            'controller' => 'Vehiculos',
            'vehiculos' => $vehiculos,
            'transportistas' => $transportistas
        ];

        $this->view('vehiculos/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Vehiculos();
            if ($model->create($_POST)) {
                header('Location: index.php?controller=Vehiculos&action=index&msg=created');
            } else {
                header('Location: index.php?controller=Vehiculos&action=index&error=create_failed');
            }
            exit;
        }
    }

    public function edit()
    {
        if (isset($_GET['id'])) {
            $model = new Vehiculos();
            $item = $model->getById($_GET['id']);
            echo json_encode($item);
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Vehiculos();
            $id = $_POST['id'];
            if ($model->update($id, $_POST)) {
                header('Location: index.php?controller=Vehiculos&action=index&msg=updated');
            } else {
                header('Location: index.php?controller=Vehiculos&action=index&error=update_failed');
            }
            exit;
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $model = new Vehiculos();
            if ($model->delete($_GET['id'])) {
                header('Location: index.php?controller=Vehiculos&action=index&msg=deleted');
            } else {
                header('Location: index.php?controller=Vehiculos&action=index&error=delete_failed');
            }
            exit;
        }
    }
}
