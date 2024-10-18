
<?php
require_once 'app/models/seller.model.php';
require_once 'app/views/seller.view.php';

class SellerDetailController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SellerModel();
        $this->view = new SellerView();
    }

    public function showSellerById($id) {
        // Valida que el ID sea numérico
        if (!is_numeric($id)) {
            echo "ID inválido.";
            return;
        }

        // Obtiene el vendedor por ID
        $seller = $this->model->getSeller($id);

        if ($seller) {
             // Obtiene las ventas asociadas a este vendedor
        $ventas = $this->model->getSalesBySellerId($id);

            // Usa la vista ya instanciada
            $this->view->showSellerById($seller, $ventas); 
        } else {
            echo "Vendedor no encontrado.";
        }
    }
    
}