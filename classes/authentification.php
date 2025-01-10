<?php

interface Authentication
{
    
    public function register(PDO $db, $firstName, $lastName, $password, $confirmPassword, $role);

    public function login(PDO $db, $password);
   
    public function logout();

    public function isLoggedIn();

    public function isAdmin();
}