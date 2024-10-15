
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
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            echo "ID inválido.";
            return;
        }

        // Obtener el vendedor por ID
        $seller = $this->model->getSeller($id);

        if ($seller) {
             // Obtener las ventas asociadas a este vendedor
        $ventas = $this->model->getSalesBySellerId($id);

            // Usar la vista ya instanciada
            $this->view->showSellerById($seller, $ventas); 
        } else {
            echo "Vendedor no encontrado.";
        }
    }
    
}