<?php

class SellerView {

    public function showSellers($sellers) {
        // la vista define una nueva variable con la cantidad de vendedores
        $count = count($sellers);
        require_once 'app/templates/list_seller.phtml';
    }
    public function showSellerById($seller, $ventas){
        require_once 'app/templates/seller_detail.phtml'; 
    }
    public function showEditSellerForm($seller) {
        require 'app/templates/form_editar_vendedor.phtml'; 
    }
    public function showError($message) {
        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($message) . '</div>';
    }
    public function setSuccessMessage($message) {
        return '<div class="alert alert-success" role="alert">' . htmlspecialchars($message) . '</div>';
    }
    public function showAddSellerForm($sellers){
        require 'app/templates/form_agregar_vendedor.phtml';
    }
}
