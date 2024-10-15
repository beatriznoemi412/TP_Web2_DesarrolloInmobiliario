<?php
    function sessionAuthMiddleware($res) {
        // Verifica si el usuario está autenticado
        if (isset($_SESSION['ID_VENDEDOR'])) {
            // Si está autenticado, se asigna información del usuario a $res
            $res->user = new stdClass();
            $res->user->Id_vendedor = $_SESSION['ID_VENDEDOR'];
            $res->user->usuario = $_SESSION['USUARIO_VENDEDOR'];
            return;
        } else {
            // Si no está autenticado, se redirige al formulario de login
            header('Location: ' . BASE_URL . 'showLogin');
            exit(); // Detiene la ejecución para evitar que el flujo continúe
        }
    }
?>
