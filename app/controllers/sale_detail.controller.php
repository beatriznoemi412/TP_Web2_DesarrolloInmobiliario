
<?php
require_once 'app/models/sale.model.php';
require_once 'app/views/sale.view.php';

class SaleDetailController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SaleModel();
        $this->view = new SaleView();
    }

    public function showSaleById($id) {
        // Validar que el ID sea numérico
        if (!is_numeric($id)) {
            echo "ID inválido.";
            return;
        }

        // Obtener venta por ID
        $sale = $this->model->getSale($id);

        if ($sale) {
            // Usar la vista ya instanciada
            $this->view->showSaleById($sale); 
        } else {
            echo "Venta no encontrada.";
        }
    }
    
}