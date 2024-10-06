
<?php
require_once './app/models/sale.model.php';
require_once './app/views/sale.view.php';
require_once './app/models/category.model.php'; 

class SaleController {
    private $model;
    private $categoryModel;
    private $view;

    public function __construct() {
        $this->model = new SaleModel();
        $this->categoryModel = new CategoryModel(); 
        $this->view = new SaleView();
    }

    public function showSales() {
        // Obtengo los vendedores de la base de datos
        $sales = $this->model->getSales();
        $categories = $this->categoryModel->getCategories();
        
        // Mapeo de categorías por ID (o nombre) para fácil acceso
        $categoryMap = [];
        foreach ($categories as $category) {
            $categoryMap[$category->categoria] = $category;  // Cambia 'nombre' al campo que uses para identificar la categoría
        }
        // Mando los vendedores a la vista
        return $this->view->showSales($sales); 
    }
    public function addSale() {
        // Verificar si el formulario fue enviado correctamente
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que los campos requeridos estén completos
            if (empty($_POST['inmueble']) || empty($_POST['date']) || empty($_POST['price'])) {
                return $this->view->showError('Todos los campos son obligatorios.');
            }
    
            // Obtener los datos del formulario
            $inmueble = $_POST['inmueble'];  
            $date = $_POST['date'];
            $price = $_POST['price'];
    
            // **Opcional**: Si decides incluir un vendedor por ahora, podrías establecer un ID de vendedor por defecto
            $id_vendedor = 1; // Por ejemplo, si solo tienes un vendedor, usa un ID fijo
    
            // Insertar la venta en la base de datos
            $id = $this->model->insertSale($inmueble, $date, $price, $id_vendedor);
    
            // Verificar si la inserción fue exitosa
            if ($id) {
                header('Location: ' . 'listarVenta'); 
                exit();
            } else {
                return $this->view->showError('Hubo un problema al agregar la venta.');
            }
        } else {
            // En caso de que no sea un POST, redirigir al formulario de ventas o mostrar un mensaje de error
            return $this->view->showError('Método no permitido.');
        }
    }
    public function deleteSale($id) {
        // Verificar si el ID de la venta es válido
        if (!empty($id)) {
            // Intentar eliminar la venta
            if ($this->model->removeSale($id)) {
                // Redirigir al listado de ventas con un mensaje de éxito
                header('Location: ' . BASE_URL . '?success=Venta eliminada con éxito.');
                exit();
            } else {
                // Redirigir con un mensaje de error si no se pudo eliminar
                header('Location: ' . BASE_URL . '?error=No se pudo eliminar la venta.');
                exit();
            }
        } else {
            // Manejo de error si el ID no es válido
            header('Location: ' . BASE_URL . '?error=ID de venta no válido.');
            exit();
        }
    }
    public function editSale($id) {
        // Verificar si el ID de la venta es válido
        if (!empty($id)) {
            // Obtener la venta actual usando el modelo
            $sale = $this->model->getSaleById($id);
    
            // Verificar si la venta existe
            if ($sale) {
                // Verificar si el formulario fue enviado
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Validar que los campos requeridos estén completos
                    if (empty($_POST['inmueble']) || empty($_POST['date']) || empty($_POST['price'])) {
                        return $this->view->showError('Todos los campos son obligatorios.');
                    }
    
                    // Obtener los datos del formulario
                    $inmueble = $_POST['inmueble'];
                    $date = $_POST['date'];
                    $price = $_POST['price'];
    
                    // Actualizar la venta en la base de datos
                    if ($this->model->updateSale($id, $inmueble, $date, $price)) {
                        // Redirigir a listarVenta después de la actualización
                        header('Location: ' . BASE_URL . 'listarVenta?success=Venta actualizada con éxito.');
                        exit();
                    } else {
                        return $this->view->showError('Hubo un problema al actualizar la venta.');
                    }
                }
    
                // Si no es un POST, mostrar el formulario de edición
                $this->view->showEditSaleForm($sale); // Método para mostrar el formulario
            } else {
                return $this->view->showError('Venta no encontrada.');
            }
        } else {
            return $this->view->showError('ID de venta no válido.');
        }
    }
    

    
}    