<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

/**
 *
 * @author wadmin
 */
interface IUsuarioRepository {

    public function getUsuarios(): array;

//a) iniciar sesión utilizando password_hash() y password_verify() con BCRYPT y parámetros por defecto (1 punto)
    public function getUsuarioByEmail($email): Usuario;
}
