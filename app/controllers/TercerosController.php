<?php

require_once '../app/models/Terceros.php';

class TercerosController extends Controller
{
    public function index()
    {
        $tercerosModel = new Terceros();
        $terceros = $tercerosModel->getAll();

        $data = [
            'pageTitle' => 'Gestión de Terceros',
            'controller' => 'Terceros',
            'terceros' => $terceros
        ];

        $this->view('terceros/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tercerosModel = new Terceros();
            $imagen_url = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $filename = 'tercero_' . time() . '.' . $ext;
                $target = 'uploads/terceros/' . $filename;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
                    $imagen_url = $target;
                }
            }

            $data = [
                'nombre_razon_social' => $_POST['nombre_razon_social'],
                'rfc' => $_POST['rfc'],
                'direccion' => $_POST['direccion'],
                'email' => $_POST['email'],
                'telefono' => $_POST['telefono'],
                'tipo' => $_POST['tipo'],
                'imagen_url' => $imagen_url
            ];

            if ($tercerosModel->create($data)) {
                header('Location: index.php?controller=Terceros&action=index');
                exit;
            }
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tercerosModel = new Terceros();
            $id = $_POST['id'];
            $terceroActual = $tercerosModel->getById($id);
            $imagen_url = $terceroActual['imagen_url'];

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $filename = 'tercero_' . time() . '.' . $ext;
                $target = 'uploads/terceros/' . $filename;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
                    $imagen_url = $target;
                }
            }

            $data = [
                'nombre_razon_social' => $_POST['nombre_razon_social'],
                'rfc' => $_POST['rfc'],
                'direccion' => $_POST['direccion'],
                'email' => $_POST['email'],
                'telefono' => $_POST['telefono'],
                'tipo' => $_POST['tipo'],
                'imagen_url' => $imagen_url
            ];

            if ($tercerosModel->update($id, $data)) {
                header('Location: index.php?controller=Terceros&action=index');
                exit;
            }
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $tercerosModel = new Terceros();
            $id = $_GET['id'];
            if ($tercerosModel->delete($id)) {
                header('Location: index.php?controller=Terceros&action=index');
                exit;
            }
        }
    }
}
