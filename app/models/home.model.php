<?php
class HomeModel {
    private $db;

    public function __construct($db) {
        $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
    }
    // Método para obtener información importante para página de inicio
    public function getHomeData() {
    
        $query = $this->db->prepare('SELECT * FROM venta LIMIT 3'); // obtiene las 3 propiedades más recientes
        $query->execute();
        
        // Obtiene resultados como un array de objetos
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
}
?>