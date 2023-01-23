<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of SessionManager
 *
 * @author wadmin
 */
class SessionManager {
    
    public static function isRoleAllowedInAction(array $actionAllowedRoles){
        self::iniciarSesion();
        if(isset($_SESSION["roleId"])){
          
            return in_array($_SESSION["roleId"], $actionAllowedRoles);
        }
        return false;
    }
    
    
     public static function cerrarSesion(){
         self::iniciarSesion();

        session_destroy();

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
            );
        }
    }

    public static function iniciarSesion(): bool {
        $iniciada = true;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $iniciada = session_start();
        }

        return $iniciada;
    }
}
