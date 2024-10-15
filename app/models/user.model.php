<?php
require_once 'app/config.php'; // Asegúrate de que el archivo config.php esté en el mismo directorio

class UserModel {
    private $db;

    public function __construct() {
        // Usar las constantes definidas en config.php para la conexión
        try {
            $this->db = new PDO(
                'mysql:host=' . MYSQL_HOST . 
                ';dbname=' . MYSQL_DB . 
                ';charset=utf8', 
                MYSQL_USER, 
                MYSQL_PASS
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para manejo de errores
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }

    public function getUserByUsername($usuario) {    
        $query = $this->db->prepare("SELECT * FROM vendedores WHERE usuario = ?");
        $query->execute([$usuario]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}
