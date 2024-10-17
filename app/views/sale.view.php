<?php

class SaleView {

    public function showSales($sales, $sellers) {
        // la vista define una nueva variable con la cantida de vendedores
        $count = count($sales);

        // el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require_once 'app/templates/list_sale.phtml';
    }
    public function showSaleById($sale){
    
        require_once 'app/templates/sale_detail.phtml'; 
    }
    public function showError($message) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
    }
    public function showEditSaleForm($sale, $sellers) {
        require 'app/templates/form_editar_venta.phtml'; 
    }

    public function showAddSaleForm($sale, $sellers) {
        require 'app/templates/form_agregar_venta.phtml'; 
    }

    public function showSuccess($message) {
        echo "<div class='success'>{$message}</div>";
    }

}
