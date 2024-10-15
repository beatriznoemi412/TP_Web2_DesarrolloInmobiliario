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
            $query = $this->db->prepare('SELECT * FROM vendedores WHERE id_vendedor = ?');
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
    public function getSalesBySellerId($id) {
        // Consulta para obtener ventas por el ID del vendedor
        $query = "SELECT * FROM venta WHERE id_vendedor = :id_vendedor";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_vendedor' => $id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function insertSeller($name, $firstName, $telephone, $email) { 
        try {
            $query = $this->db->prepare('INSERT INTO vendedores(Nombre, Apellido, Telefono, Email) VALUES (?, ?, ?, ?)');
            $query->execute([$name, $firstName, $telephone, $email]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null; 
        }
    }
    public function removeSeller($id) {
        try {
            $query = $this->db->prepare('DELETE FROM vendedores WHERE id_vendedor = ?');
            $success = $query->execute([$id]);
            if (!$success) {
                error_log("Error al intentar eliminar al asesor con ID: " . $id);
            }
            return $success;
        } catch (PDOException $e) {
            error_log("Error de PDO: " . $e->getMessage());
            return false;
        }
    }
    
    public function getSellerById($id) {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("Invalid Seller ID.");
            }
            $query = $this->db->prepare('SELECT * FROM vendedores WHERE id_vendedor = ?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ); // Devuelve un objeto de la venta
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null; // Retorna null en caso de error
        } catch (InvalidArgumentException $e) {
            error_log($e->getMessage());
            return null;
            }
        }

    
     public function updateSeller($id, $name, $firstName, $telephone, $email) {
        try {
         // Corrige la consulta eliminando la coma antes de 'WHERE'
            $query = $this->db->prepare('UPDATE vendedores SET Nombre = ?, Apellido = ?, Telefono = ?, Email = ? WHERE id_vendedor = ?');
            // Ejecutar la consulta con los parámetros
            return $query->execute([$name, $firstName, $telephone, $email, $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage()); // Log del error
            return false; // Retorna false en caso de error
            }
        }
    }