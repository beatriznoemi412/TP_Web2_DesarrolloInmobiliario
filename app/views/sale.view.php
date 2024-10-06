<?php

class SaleView {
    public function showSales($sales) {
        // la vista define una nueva variable con la cantida de vendedores
        $count = count($sales);

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require_once 'app/templates/list_sale.phtml';

        
    }
    public function showSaleById($sale){
    
        require_once 'app/templates/sale_detail.phtml'; 
    }
    public function showError($message) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
    }
    public function showEditSaleForm($sale) {
        require 'app/templates/form_editar_venta.phtml'; 
    }

}
