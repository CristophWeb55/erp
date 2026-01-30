<?php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Simplificación para MVP: admin / admin123
            if ($username === 'admin' && $password === 'admin123') {
                session_start();
                $_SESSION['user_id'] = 1;
                $_SESSION['user_name'] = 'Administrador Genesis';
                $_SESSION['user_role'] = 'Admin';
                header('Location: index.php?controller=Dashboard&action=index');
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos";
                require_once '../app/views/auth/login.php';
                exit;
            }
        }

        require_once '../app/views/auth/login.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: index.php?controller=Auth&action=login');
        exit;
    }
}
