<?php

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'app/models/seller.model.php';
require_once 'app/views/seller.view.php';

class SellerController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SellerModel();
        $this->view = new SellerView();
    }

    public function showSellers() {
        $sellers = $this->model->getSellers();
        return $this->view->showSellers($sellers); 
        }
   
     // Método para mostrar el formulario de agregar vendedor
     public function showAddSellerForm() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Asegurarse de que la variable de sesión contiene el rol esperado
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;
    
        if ($current_user_role !== 'admin') {
            // Si el usuario no es admin, redirige o muestra un error
            return $this->view->showError('Acceso no autorizado.');
        }
    
        // Mostrar el formulario si el usuario es administrador
        return $this->view->showAddSellerForm();
    }


    // Método para guardar el vendedor
    public function saveSeller() {
    
       if (session_status() === PHP_SESSION_NONE) {
           session_start();
        }
        
        $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

        if ($current_user_role !== 'admin') {
            return $this->view->showError('Acceso no autorizado.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            if (empty($_POST['name']) || empty($_POST['firstName']) || empty($_POST['telephone']) || empty($_POST['email'])) {
                return $this->view->showError('Todos los campos son obligatorios.');
            
            }

            $name = $_POST['name'];  
            $firstName = $_POST['firstName'];
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];

            try {
                // Intenta insertar el vendedor en la base de datos
                $id = $this->model->insertSeller($name, $firstName, $telephone, $email);
                if ($id) {
                    $this->view->setSuccessMessage('Asesor agregado con éxito.');
                    return $this->showSellers(); // Muestra la vista actualizada
                } else {
                    return $this->view->showError('Hubo un problema al agregar el asesor.');
                }
            } catch (Exception $e) {
                error_log('Error al agregar el asesor: ' . $e->getMessage()); // Log del error
                // Captura cualquier excepción y muestra el mensaje de error
                return $this->view->showError('Error al agregar el asesor: ' . $e->getMessage());
            }
        } else {
            return $this->view->showError('Método no permitido.');
        }
    }
    
    
    public function deleteSeller($id) {
        if (!empty($id)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

            if ($current_user_role !== 'admin') {
                return $this->view->showError('No tienes permiso para eliminar al asesor.');
            }

            $ventas = $this->model->getSalesBySellerId($id);

            if (!empty($ventas)) {
                return $this->view->showError('El asesor tiene ventas asociadas y no se puede eliminar.');
            }

            if ($this->model->removeSeller($id)) {
                $this->view->setSuccessMessage('Asesor eliminado con éxito.');
                return $this->showSellers(); // Retorna la vista actualizada
            } else {
                return $this->view->showError('No se pudo eliminar al asesor, intenta de nuevo.');
            }
        } else {
            return $this->view->showError('ID de Asesor no válido.');
        }
    }
   
        public function editSeller($id) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
    
            $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;
    
            if ($current_user_role !== 'admin') {
                return $this->view->showError('Acceso no autorizado.');
            }
    
            $seller = $this->model->getSeller($id);
            if (!$seller) {
                return $this->view->showError('Vendedor no encontrado.');
            }
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (empty($_POST['name']) || empty($_POST['firstName']) || empty($_POST['telephone']) || empty($_POST['email'])) {
                    return $this->view->showError('Todos los campos son obligatorios.');
                }
    
                $name = $_POST['name'];
                $firstName = $_POST['firstName'];
                $telephone = $_POST['telephone'];
                $email = $_POST['email'];
    
                if ($this->model->updateSeller($id, $name, $firstName, $telephone, $email)) {
                    
                    $this->view->setSuccessMessage('Datos del vendedor actualizados con éxito.');
                    header('Location: ' . BASE_URL . 'listarVendedores'); // Redirigir después de actualizar
                    exit();
                } else {
                    return $this->view->showError('Hubo un problema al actualizar los datos del vendedor.');
                }
            }
    
            $this->view->showEditSellerForm($seller);
        }
    }