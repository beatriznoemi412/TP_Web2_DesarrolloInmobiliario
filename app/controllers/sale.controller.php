<?php
require_once 'app/models/seller.model.php';
require_once 'app/models/sale.model.php';
require_once 'app/views/sale.view.php';

class SaleController {
    private $model;
    private $view;
    private $sellerModel;

    public function __construct() {
        $this->model = new SaleModel();
        $this->view = new SaleView();
        $this->sellerModel = new SellerModel();
       
    }
    
    public function showAddSaleForm() {
        $sellers = $this->sellerModel->getSellers(); // Obtiene la lista de vendedores
    
        die();
        // Verifica si hay un error al obtener vendedores
        if ($sellers === false) {
            return $this->view->showError('Error al obtener vendedores.');
        }
        // Verifica si no hay vendedores disponibles
        if (empty($sellers)) {
            return $this->view->showError('No hay vendedores disponibles.');
        }


        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;
    
        if ($current_user_role !== 'admin') {
            // Si el usuario no es admin, redirige o muestra un error
            return $this->view->showError('Acceso no autorizado.');
        }
    
        // Renderiza el formulario y pasar los vendedores a la vista
        return $this->view->showAddSaleForm($sellers);
    }
    
    public function showSales() {
        // Obtengo las ventas de la base de datos
        $sales = $this->model->getSales();
        $sellers = $this->sellerModel->getSellers();
        // Comprueba si hay ventas
        if (empty($sales)) {
            return $this->view->showError('No hay ventas registradas.');
        }

        // Comprueba si hay vendedores
        if (empty($sellers)) {
        return $this->view->showError('No hay vendedores disponibles.');
        }
        // Mando las ventas a la vista
        return $this->view->showSales($sales, $sellers); 
    }
    
    public function addSale() {
        // Inicia la sesión si no está ya iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Obtiene el rol del usuario actual
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;
        var_dump($_SESSION);
        // Verifica si el usuario es administrador
        if ($current_user_role !== 'admin') {
            return $this->view->showError('Acceso no autorizado.');
        }

    
        // Verifica si el formulario fue enviado correctamente
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que los campos requeridos estén completos
            if (empty($_POST['inmueble']) || empty($_POST['date']) || empty($_POST['price']) || empty($_POST['id_vendedor']) || empty($_POST['image'])) {
                return $this->view->showError('Todos los campos son obligatorios.');
            }
    
            // Obtiene los datos del formulario
            $inmueble = $_POST['inmueble'];  
            $date = $_POST['date'];
            $price = $_POST['price'];
            $id_vendedor = $_POST['id_vendedor'];
            $image = $_POST['image'];
    
            // Valida que la URL de la imagen sea válida
            if (!filter_var($image, FILTER_VALIDATE_URL)) {
                return $this->view->showError('La URL de la imagen no es válida.');
            }
    
            // Inserta la venta en la base de datos
            $id = $this->model->insertSale($inmueble, $date, $price, $id_vendedor, $image);
    
            // Verifica si la inserción fue exitosa
            if ($id) {
                $this->view->showSuccess(' agregado con éxito.');
                return $this->showSales(); // Retorna la vista actualizada
            } else {
                return $this->view->showError('Hubo un problema al agregar la venta.');
            }
        } else {
            // Obtengo la lista de vendedores
            $sellers = $this->sellerModel->getSellers(); // Obtener la lista de vendedores
    
             // Compruebo si se obtuvieron vendedores
        if (empty($sellers)) {
            return $this->view->showError('No hay vendedores disponibles.');
        }

        // Llamo al método para mostrar el formulario y pasarle los vendedores
        return $this->showAddSaleForm($sellers); // Llama al formulario pasando selectSellers

        }
    }
    
    public function deleteSale($id) {
    // Verificosi el ID de la venta es válido
        if (!empty($id)) {
        // Inicio la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

        // Obtengo el rol del usuario actual usando la misma clave de sesión que en listSale.phtml
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;
        
        // Verifico si el usuario es administrador (o el rol que necesites)
            if ($current_user_role !== 'admin') {
            return $this->view->showError('No tienes permiso para eliminar esta venta.');
            }

        // Obtengo la venta desde la base de datos
        $sale = $this->model->getSaleById($id);

        // Si la venta no existe, mostrar un error
            if (!$sale) {
                return $this->view->showError('Venta no encontrada.');
            }

        //  elimino la venta
            if ($this->model->removeSale($id)) {
                $_SESSION['success_message'] = 'Venta eliminada con éxito.';
    
                // Redirige a la lista de ventas
                header('Location: ' . BASE_URL . '/listarVenta');
                exit();
            } else {
                    return $this->view->showError('No se pudo eliminar la venta.');
            }
        } else {
            return $this->view->showError('ID de venta no válido.');
        }
    }
public function editSale($id) {
    if (!empty($id)) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtengo el rol del usuario actual usando la misma clave que en listSale.phtml
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

        // Verifico si el usuario es administrador
        if ($current_user_role !== 'admin') {
            return $this->view->showError('No tienes permiso para editar esta venta.');
        }

        $sale = $this->model->getSaleById($id);

        if (!$sale) {
            return $this->view->showError('Venta no encontrada.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['inmueble']) || empty($_POST['date']) || empty($_POST['price']) || empty($_POST['id_vendedor']) || empty($_POST['image'])) {
                return $this->view->showError('Todos los campos son obligatorios.');
            }

            $inmueble = $_POST['inmueble'];
            $date = $_POST['date'];
            $price = $_POST['price'];
            $id_vendedor = $_POST['id_vendedor'];
            $image = $_POST['image'];
            
            if ($this->model->updateSale($id, $inmueble, $date, $price, $id_vendedor, $image)) {
                // Almacena el mensaje de éxito en la sesión
                $_SESSION['success_message'] = 'Venta actualizada con éxito.';
    
                // Redirige a la lista de ventas
                header('Location: ' . BASE_URL . '/listarVenta');
                exit();
            } else {
                return $this->view->showError('Hubo un problema al actualizar la venta.');
            }
        } else {
            // Obtengo la lista de vendedores
            $sellers = $this->sellerModel->getSellers(); // Obtener la lista de vendedores

            // Compruebo si se obtuvieron vendedores
            if (empty($sellers)) {
                return $this->view->showError('No hay vendedores disponibles.');
            }

            // Llamo al método para mostrar el formulario de edición y pasarle los datos de la venta y los vendedores
            $this->view->showEditSaleForm($sale, $sellers);
        }
    } else {
        return $this->view->showError('Venta no encontrada.');
        }
    }
}