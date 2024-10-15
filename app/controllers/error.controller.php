<?php
require_once 'app/views/error.view.php'; // Vista para manejar el error
        
class ErrorController {
    private $view;
        
    public function __construct() {
    // Instanciar la vista del error
        $this->view = new ErrorView();
    }
        
    public function showError($message = "Error no especificado.") {
        // Usar la vista para mostrar el error
        $this->view->showError($message);
    }
}
        
