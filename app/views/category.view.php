<?php
class CategoryView {
    public function showCategories($categories) {
        require_once 'app/templates/list_category.phtml'; 
    }
    public function showItemsByCategory($items){
        require_once 'app/templates/category_detail.phtml'; 
    }
}

