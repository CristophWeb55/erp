<?php

class Controller
{
    public function view($name, $data = [])
    {
        extract($data);
        ob_start();
        $viewFile = '../app/views/' . $name . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "View not found: " . $name;
        }
        $content = ob_get_clean();
        require_once '../app/views/layout/main.php';
    }

    public function rawView($name, $data = [])
    {
        extract($data);
        $viewFile = '../app/views/' . $name . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "View not found: " . $name;
        }
    }

    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
