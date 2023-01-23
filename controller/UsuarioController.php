<?php

class UsuarioController {

    const VIEW_FOLDER = "user";

    public $page_title;
    public $view;
    private UsuarioServicio $usuarioServicio;
    private array $action_roles_array;

    public function __construct() {
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'login';
        $this->page_title = '';
        $this->usuarioServicio = new UsuarioServicio();
        //Para cada action se registran los roles permitidos [ADMIN_ROLE =1, USER_ROLE=2]
        $this->action_roles_array = ["list" => [1]];
    }

    /* List all notes */

    public function list() {

        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'list_user';
        $this->page_title = 'Listado de usuarios';
        return $this->usuarioServicio->getUsuarios();
    }

    public function login() {
        if (SessionManager::isUserLoggedIn()) {
            $this->redirectAccordingToRole();
            exit;
        }
        $this->page_title = 'Inicio de sesión';
        $this->view = self::VIEW_FOLDER . DIRECTORY_SEPARATOR . 'login';

        $app_roles = $this->usuarioServicio->getRoles();
        $loginViewData = new LoginViewData($app_roles);

        if (isset($_POST["email"]) && isset($_POST["pwd"]) && isset($_POST["rol"])) {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $rolId = $_POST["rol"];

            //Devuelve null si ha habido algún error
            $userResult = $this->usuarioServicio->login($email, $pwd, $rolId);

            if ($userResult == null) {

                $loginViewData->setStatus(Util::OPERATION_NOK);
                return $loginViewData;
            } else {
                SessionManager::iniciarSesion();
                $_SESSION["userId"] = $userResult->getId();
                $_SESSION["email"] = $userResult->getEmail();
                $_SESSION["roleId"] = $rolId;
                $_SESSION["ultimoAcceso"] = time();
                $this->redirectAccordingToRole();

                exit;
            }
        } else {
            return $loginViewData;
        }
    }

    public function logout() {
        SessionManager::cerrarSesion();
        $this->redirectTo("Usuario", "login");
    }

//    private function cerrarSesion(){
//         $this->iniciarSesion();
//
//        session_destroy();
//
//        $_SESSION = array();
//
//        if (ini_get("session.use_cookies")) {
//            $params = session_get_cookie_params();
//            setcookie(session_name(), '', time() - 42000,
//                    $params["path"], $params["domain"],
//                    $params["secure"], $params["httponly"]
//            );
//        }
//    }
//    private function iniciarSesion(): bool {
//        $iniciada = true;
//        if (session_status() !== PHP_SESSION_ACTIVE) {
//            $iniciada = session_start();
//        }
//
//        return $iniciada;
//    }

    private function redirectTo(string $controller, string $action): void {
        header("Location: FrontController.php?controller=$controller&action=$action");
        exit;
    }

    private function redirectAccordingToRole() {
        $user_selected_rol = $this->usuarioServicio->getRoleById($_SESSION["roleId"]);
        if ($user_selected_rol->getName() === ADMIN_ROLE) {
            $this->redirectTo("Usuario", "list");
        } elseif ($user_selected_rol->getName() === USER_ROLE) {
            $this->redirectTo("Nota", "list");
        }
    }

    public function getAction_roles_array(): array {
        return $this->action_roles_array;
    }

}

?>