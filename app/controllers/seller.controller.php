
<?php
require_once './app/models/seller.model.php';
require_once './app/views/seller.view.php';

class SellerController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SellerModel();
        $this->view = new SellerView();
    }

    public function showSellers() {
        // Obtengo los vendedores de la base de datos
        $sellers = $this->model->getSellers();

        // Mando los vendedores a la vista
        return $this->view->showSellers($sellers); 
    }
}
