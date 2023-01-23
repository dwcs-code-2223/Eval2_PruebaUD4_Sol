<?php

class UsuarioServicio {

    const USER_DOES_NOT_EXIST = "No existe usuario";
    const PWD_INCORRECT = "La contraseña no es correcta";

    private IUsuarioRepository $userRepository;
    private IRolRepository $rolRepository;

    public function __construct() {
        $this->userRepository = new UsuarioRepository();
        $this->rolRepository = new RolRepository();
    }

    /* Get all notes */

    public function getUsuarios(): array {

        $usuarios = $this->userRepository->getUsuarios();

        return $usuarios;
    }

    public function login(string $user, string $pwd, $rolId): ?Usuario {

        $userResult = $this->userRepository->getUsuarioByEmail($user);

        if ($userResult != null && password_verify($pwd, $userResult->getPwdhash())) {

            //check if selected rol is among user roles
            if ($this->isUserInRole($userResult, $rolId)) {

                return $userResult;
            }
        }
        return null;
    }

    public function getRoles(): array {

        $roles = $this->rolRepository->getRoles();

        return $roles;
    }

     public function getRoleById(int $roleId): Rol {

      $roles = $this->rolRepository->getRoles();
      foreach ($roles as $rol) {
          if($rol->getId()===$roleId){
              return $rol;
          }
          
      }
      

        return null;
    }
    
    public function isUserInRole(Usuario $usuario, int $roleId): bool {
        $rolesArray = $usuario->getRoles();
        foreach ($rolesArray as $rol) {
            if ($rol->getId() === $roleId) {
                return true;
            }
        }

        return false;
    }

       public function isUserInRoleName(Usuario $usuario, string $roleName): bool {
        $rolesArray = $usuario->getRoles();
        foreach ($rolesArray as $rol) {
            if ($rol->getName() === $roleName) {
                return true;
            }
        }

        return false;
    }
}

?>