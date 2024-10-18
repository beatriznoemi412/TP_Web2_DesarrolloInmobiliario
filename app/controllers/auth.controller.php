<?php
require_once 'app/models/model.php'; 
require_once 'app/models/user.model.php';
require_once 'app/views/auth.view.php';

class AuthController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
        // Verifica si la sesión ya está iniciada antes de llamarla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si el usuario está logueado, lo asigno a la vista
        $user = isset($_SESSION['USUARIO_VENDEDOR']) ? $_SESSION['USUARIO_VENDEDOR'] : null;
        $this->view = new AuthView($user); // Paso el usuario a la vista
    }

    public function isAuthenticated($user) {
        return isset($user) && !empty($user);
    }

    public function showLogin() {
        // Muestro el formulario de login
        return $this->view->showLogin();
    }

    public function login() {
        // Verifica si se envió el formulario
        if (isset($_POST['usuario']) && isset($_POST['password'])) {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
    
            // Verifica que el usuario esté en la base de datos
            $userFromDB = $this->model->getUserByUsername($usuario); 
    
            if ($userFromDB && password_verify($password, $userFromDB->password)) {
                // Guarda en la sesión los detalles del usuario
                $_SESSION['ID_VENDEDOR'] = $userFromDB->id_vendedor; // ID del vendedor
                $_SESSION['USUARIO_VENDEDOR'] = $userFromDB->usuario; // Nombre del vendedor
                $_SESSION['ROL_VENDEDOR'] = $userFromDB->rol;  // Guardar el rol del vendedor (por ejemplo, 'admin' o 'vendedor')
                $_SESSION['LAST_ACTIVITY'] = time(); // Tiempo de la última actividad 
                // Redirige al home o a la página deseada
                header('Location: ' . BASE_URL);
                exit(); 
            } else {
                return $this->view->showLogin('Credenciales incorrectas');
            }
        } else {
            return $this->view->showLogin('Por favor, ingrese sus credenciales.');
        }
    }

    public function logout() {
        // Verifica si la sesión ya está iniciada antes de destruirla
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy(); // Destruye la sesión
        header('Location: ' . BASE_URL);
        exit;
    }
}