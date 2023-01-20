<?php

class UsuarioController {

    const VIEW_FOLDER = "user";

    public $page_title;
    public $view;
    private UsuarioServicio $usuarioServicio;

    public function __construct() {
        $this->view = 'user' . DIRECTORY_SEPARATOR . 'list_user';
        $this->page_title = '';
        $this->usuarioServicio = new UsuarioServicio();
    }

    /* List all notes */

    public function list() {
        $this->page_title = 'Listado de usuarios';

        return $this->usuarioServicio->getUsuarios();
    }

    public function login() {
        $this->page_title = 'Inicio de sesión';
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'login';

        $app_roles = $this->usuarioServicio->getRoles();
        $loginViewData = new LoginViewData($app_roles);
        
        
        if (isset($_POST["email"]) && isset($_POST["pwd"]) && isset($_POST["rol"])) {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $rol = $_POST["rol"];

            //Devuelve null si ha habido algún error
            $userResult = $this->usuarioServicio->login($email, $pwd, $rol);

            if ($userResult == null) {

                $loginViewData->setStatus(Util::OPERATION_NOK);
                return $loginViewData;
            } else {
                $this->iniciarSesion();
                $_SESSION["userId"] = $userResult->getId();
                $_SESSION["ultimoAcceso"] = time();
                header("Location: FrontController.php?controller=Nota&action=list");
                exit;
            }
        } else {
            return $loginViewData;
        }
    }

    private function iniciarSesion(): bool {
        $iniciada = true;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $iniciada = session_start();
        }

        return $iniciada;
    }

}

?>