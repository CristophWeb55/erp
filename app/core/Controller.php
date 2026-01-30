<?php

class Controller
{
    public function view($name, $data = [])
    {
        // Extract data to make it available in the view
        extract($data);

        // Start output buffering to capture the view
        ob_start();
        $viewFile = '../app/views/' . $name . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            echo "View not found: " . $name;
        }
        $content = ob_get_clean();

        // Load the main layout with the glassmorphism design
        require_once '../app/views/layout/main.php';
    }

    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
