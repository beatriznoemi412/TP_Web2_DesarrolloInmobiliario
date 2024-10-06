
<?php
require_once './app/models/category.model.php';
require_once './app//views/category.view.php';

class CategoryDetailController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new CategoryModel();
        $this->view = new CategoryView();
    }

    public function showItemsByCategory($categoryName) {
        // Lógica para obtener ítems de una categoría
        $items = $this->model->getItemsByCategory($categoryName);
    
        // Renderizar la vista con los ítems
        if (!empty($items)) {
            $this->view->showItemsByCategory($items); 
        } else {
            echo "No hay ítems disponibles para esta categoría.";
        }
    }
}