<?php
//<!--include 'index.php'-->

        $nameError = '';
        $emailError ='';
        $passwordError ='';

        $name = $_GET['name'] ?? '' ;
        $email = $_GET['email'] ?? '' ;
        $password  = $_GET['password'] ?? '' ;

        if($name === ''){
           $nameError = 'name bos buraxilmamalidi';
        }
        if($email === ''){
            $emailError = 'email bos buraxilmamalidi';
        }
        if($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailError = 'emailde @ simvolu olmalidi';
        }

        $passwordToUpper = substr($password, 0, 1) === strtoupper(substr($password, 0, 1));

//        $passwordError .=
//             $password ==='' ? 'Password bos buraxilmamalidi <br>' :
//             (!$passwordToUpper  ? 'Passwordun ilk herfi boyuk herf olmalidi <br>' :
//                 (strlen($password) <5 ? 'Passwordun uzunlugu 5 den boyuk olmalidi <br>' :
//                     (strlen($password) >8 ? 'Passwordun uzunlugu 8 den kicik olmalidi <br>' : '')))   ;

        if($password ===''){
            $passwordError .= 'Password bos buraxilmamalidi <br>';
        }
        else {
            if (!$passwordToUpper) {
                $passwordError .= 'Passwordun ilk herfi boyuk herf olmalidi <br>';
            }
            if (strlen($password) < 5) {
                $passwordError .= 'Passwordun uzunlugu 5 den boyuk olmalidi <br>';
            }
            if (strlen($password) > 8) {
                $passwordError .= 'Passwordun uzunlugu 8 den kicik olmalidi <br>';
            }
        }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form  method="get">
    <input type="text" name="name" id="name" value='<?=$name ?>'>
    <p><?php echo $nameError ?></p>
    <input name="email" id="email" value='<?=$email ?>' >
    <p><?php echo $emailError ?></p>
    <input name="password" id="password" value='<?=$password ?>'>
    <p><?=$passwordError?></p>
    <button type="submit" name="action" value="send">Send</button>
</form>


</body>
</html>