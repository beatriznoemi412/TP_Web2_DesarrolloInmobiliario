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
        
            // Obtener la lista de vendedores
        $sellers = $this->sellerModel->getSellers();
            // Verificar si no hay vendedores disponibles
        if (empty($sellers)) {
            echo 'No hay vendedores disponibles.'; // Muestra un mensaje si no hay vendedores
            return $sellers; // Detener el flujo si no hay vendedores
        }
    }
    public function showSales() {
        // Obtengo los vendedores de la base de datos
        $sales = $this->model->getSales();
        
        // Mando los vendedores a la vista
        return $this->view->showSales($sales); 
    }
    public function addSale() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
     
        // Obtener el rol del usuario actual usando la misma clave de sesión que en listSale.phtml
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

        // Verificar si el usuario es administrador (o el rol que necesites)
        if ($current_user_role !== 'admin') {
            header('Location: ' . BASE_URL . '?error=No tienes permiso para eliminar esta venta.');
            exit();
        }
      
    // Verificar si el formulario fue enviado correctamente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validar que los campos requeridos estén completos
        if (empty($_POST['inmueble']) || empty($_POST['date']) || empty($_POST['price']) || empty($_POST['id_vendedor']) || empty($_POST['image'])) {
            return $this->view->showError('Todos los campos son obligatorios.');
        }

        // Obtener los datos del formulario
        $inmueble = $_POST['inmueble'];  
        $date = $_POST['date'];
        $price = $_POST['price'];
        $id_vendedor = $_POST['id_vendedor'];
        $image = $_POST['image'];
        
        // Validar que la URL de la imagen sea válida
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            return $this->view->showError('La URL de la imagen no es válida.');
        }

        // Insertar la venta en la base de datos
        $id = $this->model->insertSale($inmueble, $date, $price, $id_vendedor, $image);

        // Verificar si la inserción fue exitosa ACA
        if ($id) {
            header('Location: ' . 'listarVenta'); 
            exit();
        } else {
            return $this->view->showError('Hubo un problema al agregar la venta.');
        }



        } else {
            $sellers = $this->sellerModel->getSellers();
        
        // Llamar al método para mostrar el formulario y pasarle los vendedores
            return $this->showAddSaleForm($sellers);
        }
    }



public function deleteSale($id) {
    // Verificar si el ID de la venta es válido
    if (!empty($id)) {
        // Iniciar la sesión si aún no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener el rol del usuario actual usando la misma clave de sesión que en listSale.phtml
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

        // Verificar si el usuario es administrador (o el rol que necesites)
        if ($current_user_role !== 'admin') {
            header('Location: ' . BASE_URL . '?error=No tienes permiso para eliminar esta venta.');
            exit();
        }

        // Obtener la venta desde la base de datos
        $sale = $this->model->getSaleById($id);

        // Si la venta no existe, mostrar un error
        if (!$sale) {
            header('Location: ' . BASE_URL . '?error=Venta no encontrada.');
            exit();
        }

        // Intentar eliminar la venta
        if ($this->model->removeSale($id)) {
            header('Location: ' . BASE_URL . '?success=Venta eliminada con éxito.');
            exit();
        } else {
            header('Location: ' . BASE_URL . '?error=No se pudo eliminar la venta.');
            exit();
        }
    } else {
        header('Location: ' . BASE_URL . '?error=ID de venta no válido.');
        exit();
    }
}
public function editSale($id) {
    if (!empty($id)) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener el rol del usuario actual usando la misma clave que en listSale.phtml
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

        // Verificar si el usuario es administrador
        if ($current_user_role !== 'admin') {
            header('Location: ' . BASE_URL . '?error=No tienes permiso para editar esta venta.');
            exit();
        }

        $sale = $this->model->getSaleById($id);

        if (!$sale) {
            header('Location: ' . BASE_URL . '?error=Venta no encontrada.');
            exit();
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
                header('Location: ' . BASE_URL . 'listarVenta?success=Venta actualizada con éxito.');
                exit();
            } else {
                return $this->view->showError('Hubo un problema al actualizar la venta.');
            }
        }

            $this->view->showEditSaleForm($sale);
            } else {
                return $this->view->showError('Venta no encontrada.');
            }
        }
}