<?php

class UsuarioController {
    
    const VIEW_FOLDER="user";

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

    public function loginGet() {
        $this->page_title = 'Inicio de sesión';
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'login';
    }

    public function login() {
        $this->page_title = 'Inicio de sesión';
        $this->view = self::VIEW_FOLDER. DIRECTORY_SEPARATOR . 'login';

        if (isset($_POST["email"]) && isset($_POST["pwd"])) {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];

            //Devuelve null si ha habido algún error
            $userResult = $this->usuarioServicio->login($email, $pwd);

            if ($userResult == null) {
                $userResult= new Usuario('', '', array());
                $userResult->setStatus(Util::OPERATION_NOK);
                return $userResult;
            } else {
                $this->iniciarSesion();
                $_SESSION["userId"] = $userResult->getId();
                $_SESSION["ultimoAcceso"] = time();
               header("Location: FrontController.php?controller=Nota&action=list");
               exit;
            }
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