<?php
//var_dump($_GET);
//include "index.php";
//require_once 'index.php';

if(isset($_GET['action'])){
//    foreach ($_GET as $key => $val){
//        echo '<br>'.$key.': '.$val;
//    }

//    name($_GET['name'], $_GET['email']);

//    if(empty($_GET['name'])){
//        echo '<br>'.'Name is required';
//    }else{
//        echo $_GET['name'];
//    }

    if(empty($_GET['email'])){
//        echo '<br>'.'Email bos buraxilmamalidir';
    }
    else if(!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
//        echo '<br>'.'emailde @ simvolu olmalidi';
    }else{
//        echo $_GET['email'];
    }
}


////////////////////////////sade ededler////////////////

//function isPrime($num){
//    if($num<=1) return false;
//    if ($num<= 3) return true;
//    if($num%2===0 || $num%3===0)return  false;
//    $i = 5;
//    while ($i*$i <= $num) {
//        if ($num % $i === 0 || $num % ($i + 1) === 0) return false;
//        $i += 6;
//    }
//    return true;
//}
//
//for ($x=0; $x<=100; $x++){
//    if(isPrime($x)){
//        echo $x.PHP_EOL;
//    }
//}





?>