<?php

class UsuarioServicio {

    const USER_DOES_NOT_EXIST = "No existe usuario";
    const PWD_INCORRECT = "La contraseña no es correcta";

    private IUsuarioRepository $repository;

    public function __construct() {
        $this->repository = new UsuarioRepository();
    }

    /* Get all notes */

    public function getUsuarios(): array {

        $usuarios = $this->repository->getUsuarios();

        return $usuarios;
    }

    public function login(string $user, string $pwd): ?Usuario {

        $userResult = $this->repository->getUsuarioByEmail($user);

        if ($userResult != null && password_verify($pwd, $userResult->getPwdhash())) {

            return $userResult;
        } else {
            return null;
        }
    }

}

?>