<?php

class SellerView {
    public function showSellers($sellers) {
        // la vista define una nueva variable con la cantida de vendedores
        $count = count($sellers);

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion
        require_once 'app/templates/list_seller.phtml';

        
    }
    public function showSellerById($seller){
    
        require_once 'app/templates/seller_detail.phtml'; 
    }
}
