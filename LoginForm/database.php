<?php

class Database
{
    private $servername = 'localhost';
    private $username = 'root';
    private $serverpassword = '';
    private $dbname = 'test';
    private $conn;
    protected $table;
    private $result;
//    private $select;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->serverpassword, $this->dbname);
        if ($this->conn->connect_error) {
            die('connection failed: ' . $this->conn->connect_error);
        }

    }


    public function getUsers($email, $pass)
    {
        $query = "SELECT * FROM user WHERE email = '$email' AND password = '$pass'";
        return $this->conn->query($query);
    }

    public function getEmail($email)
    {
        $query = "SELECT * FROM user WHERE email = '$email'";
        return $this->conn->query($query);
    }
    public function addQuery($name,$email,$pass)
    {
        $insertQuery = "INSERT INTO user (name, email, password) VALUES ('$name','$email', '$pass')";
        return $this->conn->query($insertQuery);
    }
    public function connStop()
    {
       return $this->conn->close();
    }





    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function select($selectData){
        $this->result = "SELECT $selectData FROM ";
        return  $this;

    }
    public function getTable(){
       $this->result .= "$this->table ";
       return  $this;
    }
    public function fetchAll(){
      return $this->conn->query($this->result)->fetch_all();
    }
    public function where($arr){
        $this -> result .= 'where ';
        $conditions = [];
        foreach ($arr as $key=>$value){
            $conditions[]= "$key='$value'";
            echo 'kjdkcdscsdcsadcsdkjmc';
            print_r($conditions);
        }
        $this->result.=implode(' and ', $conditions);
        print_r($this->result);

        return $this;
    }
    public function andWhere($arr){
        $this -> result .= 'where ';
        $conditions = [];

        foreach ($arr as $x){
            $conditions[]= "$x[0] $x[1] '$x[2]'";
        }
        $this->result.=implode(" and ", $conditions);
        print_r($this->result);

        return $this;
    }
    public function orWhere(){
        $this -> result .= "or ";
        return $this;
    }
    public function condition($condition){
        $this -> result .= $condition;
        return $this;
    }
    public function limit($num){
        $this -> result .= "limit $num ";
        return $this;
    }


}