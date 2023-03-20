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
    
      const MAX_TOKEN_LENGTH = 10;

//    e) Para las operaciones relacionadas con la sesión puedes crear una clase nueva SessionManager con métodos estáticos que permitan gestionar (2 puntos) :
//-inicio de sesión
//-cierre de sesión
//-comprobación de tiempo de actividad de usuario
//-si usuario tiene los roles adecuados para ejecutar una determinada action y cualquier otra funcionalidad que precises
//
//La clase SessionManager será invocada desde los controllers que la necesiten.

    CONST MAX_SECONDS_INACTIVITY = 600;

    public static function isRoleAllowedInAction(array $actionAllowedRoles) {
        self::iniciarSesion();
        if (isset($_SESSION["roleId"])) {

            return in_array($_SESSION["roleId"], $actionAllowedRoles);
        }
        return false;
    }

    public static function cerrarSesion() {
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

        //c)

        setcookie("userId", '', time() - self::MAX_SECONDS_INACTIVITY);
        
        
        //h) 
        setcookie("token", '', time()-self::MAX_SECONDS_INACTIVITY);
    }

    public static function iniciarSesion(): bool {
        $iniciada = true;
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $iniciada = session_start();
        }

        return $iniciada;
    }

    public static function isUserLoggedIn() {

        //b) ++ isset
        $autenticado = self::iniciarSesion() && isset($_SESSION["userId"]) && isset($_SESSION["roleId"]) && isset($_SESSION["ultimoAcceso"]) && isset($_COOKIE["userId"]) && isset($_COOKIE["token"]) && isset($_SESSION["token"]);

        //b)
        if ($autenticado) {
            $autenticado = $autenticado && ( (int) $_COOKIE["userId"] === $_SESSION["userId"]);
            //g)
            $autenticado = $autenticado && ($_COOKIE["token"]=== $_SESSION["token"]);
        }
        
       //b) y g)
        if (!$autenticado) {
            SessionManager::cerrarSesion();
            return false;
        } else {
            return $autenticado && self::isUserActive();
        }
    }

//    h) Establece un tiempo máximo de inactividad con el servidor tras el cual se cerrará la sesión de forma automática. Actualiza el tiempo de acceso, siempre que se invoque una action con el rol permitido. (1 punto)
    public static function isUserActive(): bool {
        $active = false;
        $actual_time = time();
        $diff = $actual_time - $_SESSION["ultimoAcceso"];
        if ($diff < MAX_SECONDS_INACTIVITY) {
            $active = true;
        } else {
            self::cerrarSesion();
        }

        return $active;
    }

    public static function updateLastAccess() {
        $_SESSION["ultimoAcceso"] = time();
    }
    
    public static function getRandomToken(): string{
      
        //Genera un string formado por 10 dígitos
        
     $random_number=   random_int(0, 9999999999);
     $random_token_string = str_pad($random_number,self::MAX_TOKEN_LENGTH, "0", STR_PAD_LEFT);
     return $random_token_string;
    }

}
