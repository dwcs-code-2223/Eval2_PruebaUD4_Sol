<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of LoginViewData
 *
 * @author wadmin
 */
class LoginViewData {
    use ViewData;
    
    private array $appRoles;
    
    public function __construct(array $appRoles) {
        $this->appRoles = $appRoles;
    }

    public function getAppRoles(): array {
        return $this->appRoles;
    }

    public function setAppRoles(array $appRoles): void {
        $this->appRoles = $appRoles;
    }


}
