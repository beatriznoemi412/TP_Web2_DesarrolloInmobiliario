<?php
require_once 'libs/response.php';
require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/middlewares/verify.auth.middleware.php';
require_once 'app/controllers/seller.controller.php';  
require_once 'app/controllers/seller_detail.controller.php'; 
require_once 'app/controllers/sale.controller.php';  
require_once 'app/controllers/sale_detail.controller.php';  
require_once 'app/controllers/home.controller.php';
require_once 'app/controllers/auth.controller.php';
require_once 'app/controllers/error.controller.php'; 

// base_url para redirecciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$res = new Response();
// Se obtiene la acción proporcionada o una acción por defecto
$action = 'home'; // Acción por defecto
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// Se parsea la URL en segmentos
$params = explode('/', $action);

// Se instancian los controladores correspondientes
$sellerController = new SellerController();
$sellerDetailController = new SellerDetailController();
$homeController = new HomeController();
$saleController = new SaleController($res);
$saleDetailController = new SaleDetailController($res);
$authController = new AuthController();
$errorController = new ErrorController(); 

// Tabla de ruteo
switch ($params[0]) {
    // Rutas públicas
    case 'home':
        $homeController->index();
        break;

    case 'listar':
        $sellerController->showSellers();
        break;

    case 'vendedor':
        if (isset($params[1])) {
            $sellerDetailController->showSellerById($params[1]);
        } else {
            echo "ID de vendedor no especificado.";
        }
        break;
    //Rutas que requieren autenticación
    case 'nuevo':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $sellerController->showAddSellerForm();
        break;
        
    case 'guardarVendedor':
        sessionAuthMiddleware($res);  // Verifica si hay una sesión activa
        verifyAuthMiddleware($res);   // Verifica si el usuario tiene permisos de administrador
        $sellerController->saveSeller(); 
        break;

    case 'eliminarVendedor':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if (isset($params[1]) && is_numeric($params[1])) { 
            $sellerController->deleteSeller($params[1]); // Elimina el ítem por su ID
        } else {
            echo "ID de venta no especificado o no válido."; // Maneja el error de un ID faltante o no válido
        }
        break;
    
    case 'editarVendedor':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if (isset($params[1]) && is_numeric($params[1])) { // Verificar si el índice 1 existe y es numérico
            $sellerController->editSeller($params[1]);
        } else {
            echo "ID de asesor no válido."; // Manejar el error de un ID faltante o no numérico
        }
         break;

    //Rutas públicas
    case 'listarVenta':
       $saleController->showSales();
    break;
    
    case 'venta':
        if (isset($params[1])) {
            $saleDetailController->showSaleById($params[1]);
        } else {
            echo "ID de la venta no especificado.";
        }
    break;
    //Rutas que requieren autenticación
    case 'nueva':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $saleController->addSale();
        break;

    case 'eliminar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if (isset($params[1]) && is_numeric($params[1])) { // Asegúrate de que el ID sea válido
            $saleController->deleteSale($params[1]); // Elimina el ítem por su ID
        } else {
            echo "ID de venta no especificado o no válido."; // Maneja el error de un ID faltante o no válido
        }
        break;

    case 'editar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        if (isset($params[1]) && is_numeric($params[1])) { // Verificar si el índice 1 existe y es numérico
            $saleController->editSale($params[1]);
        } else {
            echo "ID de venta no válido."; // Manejar el error de un ID faltante o no numérico
        }
        break;

    // Rutas de autenticación
    case 'showLogin':
        $authController->showLogin();
        break;

    case 'login':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;
     // Ruta de error
     case 'showError':
        $errorController->showError(); // Muestra la página de error
        break;

    default:
        $errorController->showError(); // Redirige a la página de error si no se encuentra la acción
        break;
}
    
    