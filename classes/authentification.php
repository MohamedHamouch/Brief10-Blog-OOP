<?php

interface Authentication
{
    
    public function register(PDO $db, $password, $confirmPassword);

    public function login(PDO $db, $password);
   
    public function logout();

    public function isLoggedIn();

    public function isAdmin();
}