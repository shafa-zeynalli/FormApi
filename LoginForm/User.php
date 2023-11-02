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
//         ->where([
//             'password' => "Scccvv",
//             'name' => "d"
//         ])
//         ->condition("password='Scccvv' ")
         ->andWhere([
             ['id', '>', '40'],
             ['id', '<', '46'],
             ['password', '=', 'Scccvv']
         ])
//         ->condition('name="d" ')
         ->limit(3)
         ->fetchAll()
);
