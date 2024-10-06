<?php
class SellerModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
    }
 
    public function getSellers() {
        // 2. Ejecuto la consulta
        $query = $this->db->prepare('SELECT * FROM vendedores');
        $query->execute();
    
        // 3. Obtengo los datos en un arreglo de objetos
        $sellers = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $sellers;
    }
 
    public function getSeller($id) {    
        try {
            // Validación de entrada
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("El ID proporcionado no es válido.");
            }
            
            // Preparar y ejecutar la consulta
            $query = $this->db->prepare('SELECT * FROM vendedores WHERE Id_vendedor = ?');
            $query->execute([$id]);   
    
            // Obtener el resultado
            $seller = $query->fetch(PDO::FETCH_OBJ);
        
            return $seller;
    
        } catch (Exception $e) {
            // Manejo de errores (puedes registrar el error o mostrar un mensaje adecuado)
            error_log($e->getMessage());
            return null;  // o lo que sea apropiado en tu caso
        }
    }
    
}