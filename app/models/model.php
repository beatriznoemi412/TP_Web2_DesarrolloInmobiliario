<?php
require_once 'app/config.php'; // Incluye el archivo de configuración

class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST .
            ";dbname=".MYSQL_DB.";charset=utf8", 
            MYSQL_USER, MYSQL_PASS);
        $this->_deploy();  // Corrección: Llamar al método correcto
    }

    // Método privado para desplegar las tablas si no existen
    private function _deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        
        // Si no hay tablas en la base de datos
        if(count($tables) == 0) {
            // Creación de la tabla 'vendedores'
            $sql =<<<SQL
                CREATE TABLE IF NOT EXISTS `vendedores` (
                    `Id_vendedor` int(11) NOT NULL AUTO_INCREMENT,
                    `Nombre` varchar(50) NOT NULL,
                    `Apellido` varchar(50) NOT NULL,
                    `Telefono` varchar(70) NOT NULL,
                    `Email` varchar(50) NOT NULL UNIQUE,
                    `usuario` varchar(50) NOT NULL,
                    `password` char(150) NOT NULL,
                    `rol` enum('admin', 'vendedor') NOT NULL DEFAULT 'vendedor',
                    PRIMARY KEY (`Id_vendedor`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            SQL;

            // Creación de la tabla 'venta'
            $sql_venta = <<<SQL
                CREATE TABLE IF NOT EXISTS `venta` (
                    `id_venta` int(11) NOT NULL AUTO_INCREMENT,
                    `inmueble` varchar(300) NOT NULL,
                    `fecha_venta` date NOT NULL,
                    `precio` int(11) NOT NULL,
                    `Id_vendedor` int(11) NOT NULL,
                    `foto_url` varchar(255) DEFAULT NULL,
                    PRIMARY KEY (`id_venta`),
                    FOREIGN KEY (`Id_vendedor`) REFERENCES `vendedores`(`Id_vendedor`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            SQL;

            // Ejecutar las consultas para crear las tablas
            $this->db->exec($sql);  // Corrección: Ejecutar $sql para 'vendedores'
            $this->db->exec($sql_venta); // Ejecutar $sql_venta para 'venta'

            // Agregar datos iniciales a la tabla 'vendedores'
            $sql_insert_vendedores = <<<SQL
                INSERT INTO `vendedores` (`Nombre`, `Apellido`, `Telefono`, `Email`, `usuario`, `password`, `rol`)
                VALUES
                ('Agustín', 'Castro', '2494678635', 'agustinC@gmail.com', 'webadmin', '$2a$12$mvhk0vIlA2p3LU.cQw/OxOrWxQFOk71l0Eq8I94pvcQTF5Z32icBu', 'admin'),
                ('Pamela', 'Sosa', '2494582311', 'pamsosa@gmail.com', '', '', 'vendedor'),
                ('Juan', 'Arce', '2494985634', 'ja@gmail.com', '', '', 'vendedor'),
                ('Carmen', 'Lopez', '2494123122', 'carmenlo@gmail.com', '', '', 'vendedor');
            SQL;

            $this->db->exec($sql_insert_vendedores);

            // Agregar datos iniciales a la tabla 'venta'
            $sql_insert_ventas = <<<SQL
                INSERT INTO `venta` (`inmueble`, `fecha_venta`, `precio`, `Id_vendedor`, `foto_url`)
                VALUES
                ('Lujosa casa en country golf', '2024-08-07', 525000, 1, 'https://cdn.pixabay.com/photo/2016/08/16/03/50/exterior-1597098_1280.jpg'),
                ('Departamento en pleno centro Tandil', '2024-08-13', 220000, 3, 'https://cdn.pixabay.com/photo/2014/09/04/05/54/construction-435302_1280.jpg'),
                ('Casa importante cerca del lago de Tandil', '2024-08-23', 480000, 2, 'https://cdn.pixabay.com/photo/2013/09/24/12/08/apartment-185779_1280.jpg');
            SQL;

            $this->db->exec($sql_insert_ventas);
        }
    }
}
