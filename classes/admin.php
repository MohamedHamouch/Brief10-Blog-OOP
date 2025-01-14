<?php
require_once 'blogger.php';

class Admin extends Blogger
{
    public function __construct($id, $firstName, $lastName, $email)
    {
        parent::__construct($id, $firstName, $lastName, $email);
        $this->roleId = 2;
    }
}

?>