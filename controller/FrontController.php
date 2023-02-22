<?php

ob_start();

require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'config/config.php';
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'includes/autoload.php';
//i) Establece el tiempo máximo de duración de la cookie al mismo valor mediante una directiva (que afecte solo al script php) 
ini_set("session.cookie_lifetime", MAX_SECONDS_INACTIVITY);

//    h) Establece un tiempo máximo de inactividad con el servidor tras el cual se cerrará la sesión de forma automática. Actualiza el tiempo de acceso, siempre que se invoque una action con el rol permitido. (1 punto)
   
if (!isset($_GET["controller"]) || !SessionManager::isUserLoggedIn()) {
    $_GET["controller"] = DEFAULT_CONTROLLER;
}

if (!isset($_GET["action"]) || !SessionManager::isUserLoggedIn()) {
    $_GET["action"] = DEFAULT_ACTION;
}

$controller_path = $_GET["controller"] . '.php';

/* Check if controller exists */
if (!file_exists($controller_path)) {
    $controller_path = DEFAULT_CONTROLLER . 'Controller.php';
}



/* Load controller */
//require_once $controller_path; //Se hace en autoload.php

$controllerName = $_GET["controller"] . 'Controller';
$controller = new $controllerName();

//Se preparan los datos para que estén disponibles en la vista
$dataToView["data"] = array();

/* Check if method is defined */
if (method_exists($controller, $_GET["action"])) {


//    g) Deberá comprobarse, cada vez que un usuario intente invocar una action concreta de un controlador, que el rol con el que ha iniciado sesión está entre los roles permitidos de la action. En caso contrario ha de redigirse al usuario a una vista nueva indicando que no tiene permisos. En lugar de utilizar código en cada action, piensa en un mecanismo que permita realizar la autorización en un único punto. (1,5 puntos)
    $allowed = AuthorizationManager::isUserAuthorized($controllerName, $_GET["action"]);

    if ($allowed) {
        //Se llama a la action
        $dataToView["data"] = $controller->{$_GET["action"]}();
        SessionManager::updateLastAccess();
        $mainBodyView = $controller->view . '.php';
    } else {
        $mainBodyView = 'template' . DIRECTORY_SEPARATOR . '403Forbidden.php';
    }
}


/* Load views */
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'view/template/header.php';
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'view/' . $mainBodyView;
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'view/template/footer.php';
ob_end_flush();
?>