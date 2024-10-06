<?php

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
    }

    public function getCategories() {
        try {
            // Consulta para agrupar por categoría de precio
            $query = $this->db->prepare('SELECT CASE WHEN precio < 200000 THEN "Bajo"
                        WHEN precio BETWEEN 200000 AND 500000 THEN "Medio"
                        ELSE "Alto" 
                    END AS categoria, 
                    COUNT(*) AS cantidad,
                    MIN(precio) AS min_precio,
                    MAX(precio) AS max_precio
                FROM venta
                GROUP BY categoria
            '); 
            $query->execute();
        
            // Obtengo los datos en un arreglo de objetos
            $categories = $query->fetchAll(PDO::FETCH_OBJ); 
        
            return $categories;
        } catch (Exception $e) {
            // Manejo de errores
            error_log($e->getMessage());
            return []; // Retornar un arreglo vacío en caso de error
        }
    }
    public function getItemsByCategory($categoryName) {
        try {
            // Ajusta la consulta para filtrar por el rango de precio según el nombre de la categoría
            $query = $this->db->prepare('
                SELECT inmueble, fecha_venta, precio, Id_vendedor 
                FROM venta 
                WHERE 
                    (CASE 
                        WHEN :categoryName = "Bajo" THEN precio < 200000
                        WHEN :categoryName = "Medio" THEN precio BETWEEN 200000 AND 500000
                        WHEN :categoryName = "Alto" THEN precio > 500000
                    END)
            ');
            $query->execute([':categoryName' => $categoryName]);
        
            // Obtengo los datos en un arreglo de objetos
            $items = $query->fetchAll(PDO::FETCH_OBJ);
        
            return $items;
        } catch (Exception $e) {
            // Manejo de errores
            error_log($e->getMessage());
            return []; // Retornar un arreglo vacío en caso de error
        }
    }
}    
    