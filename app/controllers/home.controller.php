<?php
require_once 'app/views/home.view.php'; 

class HomeController {
    private $view;

    public function __construct() {
        session_start(); // Inicia la sesión
        $user = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
        $this->view = new HomeView($user); // Pasa el usuario a la vista
    }

    public function index() {
        $this->view->Index(); // Aquí llama a la vista principal
    }
}