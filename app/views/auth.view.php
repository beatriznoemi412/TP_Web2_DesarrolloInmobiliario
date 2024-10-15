<?php
class AuthView {
    private $user;

    public function __construct($user = null) {
        $this->user = $user;
    }

    public function isAuthenticated() {
        return isset($this->user) && !empty($this->user);
    }

    public function showLogin($error = null) {
        // Lógica para mostrar el formulario de login, incluyendo la variable $error
        require 'app/templates/form_login.phtml';; // Incluye el archivo de la vista
    }
}