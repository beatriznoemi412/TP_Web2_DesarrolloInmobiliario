<?php
class HomeController {
    public function index() {
        // Incluye el archivo que contiene la clase HomeView
        require_once 'app/views/home.view.php'; // Asegúrate de que la ruta sea correcta
        
        $view = new HomeView();  // Instancia de la clase HomeView
        $view->index();          // Llama al método index de la vista
    }
}
