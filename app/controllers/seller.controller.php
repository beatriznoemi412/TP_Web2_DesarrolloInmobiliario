<?php
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

    public function addSeller() {
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

            $id = $this->model->insertSeller($name, $firstName, $telephone, $email);
            if ($id) {
                $this->view->setSuccessMessage('Asesor agregado con éxito.');
                return $this->showSellers(); // Retorna la vista actualizada
            } else {
                return $this->view->showError('Hubo un problema al agregar el asesor.');
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
        if (!empty($id)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $current_user_role = $_SESSION['ROL_VENDEDOR'] ?? null;

            if ($current_user_role !== 'admin') {
                return $this->view->showError('Acceso no autorizado.');
            }

            $seller = $this->model->getSellerById($id); 

            if (!$seller) {
                return $this->view->showError('Asesor no encontrado.');
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
                    $this->view->setSuccessMessage('Datos del asesor actualizados con éxito.');
                    return $this->showSellers(); // Retorna la vista actualizada
                } else {
                    return $this->view->showError('Hubo un problema al actualizar datos del asesor.');
                }
            }
            return $this->view->showEditSellerForm($seller); 
        } else {
            return $this->view->showError('Asesor no encontrado.');
        }
    }
}
