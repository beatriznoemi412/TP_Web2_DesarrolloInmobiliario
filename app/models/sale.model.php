<?php
class SaleModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
    }

    public function getSales() {
        // 2. Ejecuto la consulta
        $query = $this->db->prepare('SELECT *, 
        CASE 
            WHEN precio < 200000 THEN "Bajo"
            WHEN precio BETWEEN 200000 AND 500000 THEN "Medio"
            ELSE "Alto"
        END AS categoria 
        FROM venta');
        $query->execute();
    
        // 3. Obtengo los datos en un arreglo de objetos
        $sales = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $sales;
    }

    public function getSale($id) {    
        try {
            // Validación de entrada
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("El ID proporcionado no es válido.");
            }
            
            // Preparar y ejecutar la consulta
            $query = $this->db->prepare('SELECT * FROM venta WHERE id_venta = ?');
            $query->execute([$id]);   
    
            // Obtener el resultado
            $sale = $query->fetch(PDO::FETCH_OBJ);
        
            return $sale;
    
        } catch (Exception $e) {
            // Manejo de errores
            error_log($e->getMessage());
            return null;  // o lo que sea apropiado en tu caso
        }
    }

    public function insertSale($inmueble, $date, $price, $id_vendedor) { 
        try {
            $query = $this->db->prepare('INSERT INTO venta(inmueble, fecha_venta, precio, Id_vendedor) VALUES (?, ?, ?, ?)');
            $query->execute([$inmueble, $date, $price, $id_vendedor]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null; 
        }
    }
    public function removeSale($id) {
        try {
            $query = $this->db->prepare('DELETE FROM venta WHERE id_venta = ?');
            return $query->execute([$id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false; // Retorna false en caso de error
        }
    }
        public function getSaleById($id) {
            try {
                $query = $this->db->prepare('SELECT * FROM venta WHERE id_venta = ?');
                $query->execute([$id]);
                return $query->fetch(PDO::FETCH_OBJ); // Devuelve un objeto de la venta
            } catch (PDOException $e) {
                error_log($e->getMessage());
                return null; // Retorna null en caso de error
            }
        }
        
        public function updateSale($id, $inmueble, $date, $price) {
            try {
                $query = $this->db->prepare('UPDATE venta SET inmueble = ?, fecha_venta = ?, precio = ? WHERE id_venta = ?');
                return $query->execute([$inmueble, $date, $price, $id]);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                return false; // Retorna false en caso de error
            }
        }
    
}    