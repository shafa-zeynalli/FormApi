<?php
include 'database.php';
class User extends Database
{
    public function __construct()
    {
        parent::__construct();
        $this->table= 'user';
    }
}

$user = new User();
echo '<pre>';

print_r(
    $user->select('*')
         ->getTable()
         ->where()
         ->condition("password='Scccvv' ")
         ->andWhere()
         ->condition('name="d" ')
         ->limit(3)
         ->fetchAll()
);
