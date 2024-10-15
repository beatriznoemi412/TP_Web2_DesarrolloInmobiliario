<?php
class HomeModel {
    private $db;

    public function __construct($db) {
        $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
    }
    // Método para obtener información relevante para la página de inicio
    public function getHomeData() {
    
        $query = $this->db->prepare('SELECT * FROM venta LIMIT 3'); // Ejemplo: obtener las 3 propiedades más recientes
        $query->execute();
        
        // Obtener resultados como un array de objetos
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
}
?>