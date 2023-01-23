<?php

ob_start();



require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'config/config.php';
require_once dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'includes/autoload.php';
ini_set("session.cookie_lifetime", MAX_SECONDS_INACTIVITY);

if (!isset($_GET["controller"])) {
    $_GET["controller"] = DEFAULT_CONTROLLER;
}

if (!isset($_GET["action"])) {
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



    
    /* Check roles */

    $allowed = true; //Por defecto suponemos que se permite acceso
    if (count($controller->getAction_roles_array()) > 0) {

        //existe control de acceso para al menos una acción
        if (isset($controller->getAction_roles_array()[$_GET["action"]])) {
            //existe control de acceso para la accion de la url

            $allowedRolesInAction = $controller->getAction_roles_array()[$_GET["action"]];

            if (!SessionManager::isRoleAllowedInAction($allowedRolesInAction)) {
                $allowed = false;
            }
        }
    }
    if ($allowed) {
        //Se llama a la action
        $dataToView["data"] = $controller->{$_GET["action"]}();
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