<?php
require_once 'admin.php';

class SuperAdmin extends Admin
{
    public function __construct($id, $firstName, $lastName, $email)
    {
        parent::__construct($id, $firstName, $lastName, $email);
        $this->roleId = 1;
    }
}

$me = new SuperAdmin(5, 'med', 'ali', 'Hime');

?>