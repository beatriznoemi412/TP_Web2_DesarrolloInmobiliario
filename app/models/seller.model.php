<?php
class SellerModel {
    private $db;

    public function __construct() {
       $this->db = new PDO('mysql:host=localhost;dbname=desarrolloinmobiliario;charset=utf8', 'root', '');
       $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
    }
 
    public function getSellers() {
        // 2. Ejecuto la consulta
        $query = $this->db->prepare('SELECT * FROM vendedores');
        $query->execute();
    
        // 3. Obtengo los datos en un arreglo de objetos
        $sellers = $query->fetchAll(PDO::FETCH_OBJ); 
        
         // Comprobar si se encontraron resultados
        if (empty($sellers)) {
            return []; // Retornar arreglo vacio si no hay vendedores
        }

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
            error_log('Error al insertar vendedor: ' . $e->getMessage()); // Mensaje de error más claro
            return false; // Retorna falso en caso de error
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
    
   /* public function getSellerById($id) {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException("Invalid Seller ID.");
            }
            $query = $this->db->prepare('SELECT * FROM vendedores WHERE id_vendedor = ?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ); 
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null; // Retorna null en caso de error
        } catch (InvalidArgumentException $e) {
            error_log($e->getMessage());
            return null;
            }
        }*/
       
    
        public function updateSeller($id, $name, $firstName, $telephone, $email) {
            try {
                // Preparar la consulta SQL
                $query = $this->db->prepare('UPDATE vendedores SET Nombre = ?, Apellido = ?, Telefono = ?, Email = ? WHERE id_vendedor = ?');
        
                // Ejecutar la consulta con los parámetros
                if (!$query->execute([$name, $firstName, $telephone, $email, $id])) {
                    // Si execute devuelve false, hay un error
                    $errorInfo = $query->errorInfo(); // Obtiene información sobre el error
                    error_log('Error SQL: ' . $errorInfo[2]); // Registra el mensaje de error
                    return false; // O puedes lanzar una excepción
                }
        
                return true; // Si todo fue bien
            } catch (PDOException $e) {
                // Manejo de excepciones en caso de que haya un error de conexión o de consulta
                error_log('Error en la base de datos: ' . $e->getMessage()); // Registra el error
                return false; // O se puede lanzar una excepción
            }
        }
    }        