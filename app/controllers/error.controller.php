<?php
require_once 'app/views/error.view.php'; 
        
class ErrorController {
    private $view;
        
    public function __construct() {
    // Instancia la vista del error
        $this->view = new ErrorView();
    }
        
    public function showError($message = "Error no especificado.") {
        // vista muestra el error
        $this->view->showError($message);
    }
}
        
