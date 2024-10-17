<?php

class SaleModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
    }


    public function getSales() {
        //try {
            // Prepare and execute the query to fetch all sales
            $query = $this->db->prepare('SELECT * FROM venta');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ); // Fetch all results as an array of objects
       // } catch (PDOException $e) {
        //    error_log($e->getMessage());
         //   return []; // Return an empty array in case of error
        //}
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
    
    
    public function insertSale($inmueble, $date, $price, $id_vendedor, $image) { 
        try {
            $query = $this->db->prepare('INSERT INTO venta(inmueble, fecha_venta, precio, Id_vendedor, foto_url) VALUES (?, ?, ?, ?, ?)');
            $query->execute([$inmueble, $date, $price, $id_vendedor, $image]);
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

    public function updateSale($id, $inmueble, $date, $price, $id_vendedor, $image) {
        try {
            
            $query = $this->db->prepare('UPDATE venta SET inmueble = ?, fecha_venta = ?, precio = ?, id_vendedor = ?, foto_url = ? WHERE id_venta = ?');
            
            // Ejecutar la consulta con los parámetros
            return $query->execute([$inmueble, $date, $price, $id_vendedor, $image, $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage()); // Log del error
            return false; // Retorna false en caso de error
        }
  }
}
