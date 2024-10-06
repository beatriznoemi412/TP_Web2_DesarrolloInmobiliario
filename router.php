
<?php
require_once 'app/controllers/seller.controller.php';  
require_once 'app/controllers/seller_detail.controller.php'; 
require_once 'app/controllers/sale.controller.php';  
require_once 'app/controllers/sale_detail.controller.php'; 
require_once 'app/controllers/category.controller.php';
require_once 'app/controllers/category_detail.controller.php'; 
require_once 'app/controllers/home.controller.php';

// base_url para redirecciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

// Obtener la acción proporcionada o una acción por defecto
$action = 'home'; // Acción por defecto
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// Parsear la URL en segmentos
$params = explode('/', $action);

// Instanciar el controlador correspondiente
$sellerController = new SellerController();
$sellerDetailController = new SellerDetailController();
$categoryController = new CategoryController();
$categoryDetailController = new CategoryDetailController();
$homeController = new HomeController();
$saleController = new SaleController();
$saleDetailController = new SaleDetailController();

// Tabla de ruteo
switch ($params[0]) {
    case 'home':
        $homeController->index();
        break;
        
    case 'listar':
        $sellerController->showSellers();
        break;
    case 'vendedor':
        // Verificar si se ha pasado un ID como segundo parámetro en la URL
        if (isset($params[1])) {
            // Llamar a showSellerById con el ID del vendedor
            $sellerDetailController->showSellerById($params[1]);
        } else {
            echo "ID de vendedor no especificado.";
        }
        break;
        
        case 'listarVenta':
            $saleController->showSales();
            break;
        case 'venta':
            // Verificar si se ha pasado un ID como segundo parámetro en la URL
            if (isset($params[1])) {
                // Llamar a showSellerById con el ID del vendedor
                $saleDetailController->showSaleById($params[1]);
            } else {
                echo "ID de la venta no especificado.";
            }
            break;
        case 'nueva':
            $saleController->addSale();
            break;
        case 'eliminar':
            $saleController->deleteSale($params[1]);
            break;
        case 'editar':
            $saleController->editSale($params[1]);
            break;
        case 'categorias': // Nueva ruta para mostrar categorías
                $categoryController->showCategories(); // Llama al método correspondiente
            break;
        case 'categoriaItem':
           // Verificar si se ha pasado un ID como segundo parámetro en la URL
            if (isset($params[1])) {
            // Llamar a showItemsByCategory con el ID de la categoría
            $categoryDetailController->showItemsByCategory($params[1]);
            } else {
                echo "ID de categoría no especificado.";
            }
            break;
    
        default:
            echo "Acción no encontrada";
        break;
}
