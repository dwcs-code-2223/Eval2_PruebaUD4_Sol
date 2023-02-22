<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AuthorizationManager
 *
 * @author wadmin
 */
class AuthorizationManager {

    private static $controller_action_roles_array_assoc = null;

    const RUTA_FICHERO = "config" . DIRECTORY_SEPARATOR . "action_roles.json";

    private function __construct() {
        
    }

    public function __clone() {
        
    }

    public static function isUserAuthorized($controllerName, $action): bool {
        if (self::$controller_action_roles_array_assoc == null) {
            $filePath = dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . self::RUTA_FICHERO;
            $assoc_array = json_decode(file_get_contents($filePath), true);

            //Cambiamos a lower case las claves
            $assoc_array_lowercase = array_change_key_case($assoc_array, CASE_LOWER);
            self::$controller_action_roles_array_assoc = $assoc_array_lowercase;
        }
        $allowed_rol_ids_in_action = self::$controller_action_roles_array_assoc[strtolower($controllerName)][strtolower($action)];

        //Si hay roles especificados y el usuario actual tiene uno de los roles permitidos
        if (isset($allowed_rol_ids_in_action)) {
            if (count($allowed_rol_ids_in_action) > 0) {
                return SessionManager::isRoleAllowedInAction($allowed_rol_ids_in_action);
               //si está presente en action_roles.json, pero está vacío, asumimos acceso anónimo permitido
            } else if (count($allowed_rol_ids_in_action) == 0) {
                
                return true;
            }
        }
        //Cualquier otro caso:
        return false;
    }

}
