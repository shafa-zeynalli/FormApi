<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';

$conn = new mysqli($servername, $username, $password, $dbname);
$sqlQuery = 'SELECT * FROM user';

if($conn -> connect_error){
    die('connection failed: ' . $conn->connect_error);
}

echo '<pre>';

$resultQuery = $conn->query($sqlQuery);
print_r($resultQuery->fetch_all());
$deleteQuery = "delete from user where name='User2' and password = 'User 3 password'";
$resultQuery = $conn->query($deleteQuery);
$isQuery = "SELECT * FROM user WHERE name = 'Shafa' AND password = 'pass 2'";
$resultQuery = $conn->query($isQuery);

if ($resultQuery->num_rows == 0) {
    $insertQuery = "INSERT INTO user (name, password) VALUES ('Shafa', 'pass 2')";
    $conn->query($insertQuery);
}


