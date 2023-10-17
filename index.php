<?php

    $nameError = '';
    $emailError ='';
    $passwordError ='';

    $name = $_GET['name'] ?? '' ;
    $email = $_GET['email'] ?? '' ;
    $password  = $_GET['password'] ?? '' ;


    if(isset($_GET['action'])){

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

        if($password ==='') {
            $passwordError .= 'Password bos buraxilmamalidi <br>';
        }
            if (!$passwordToUpper) {
                $passwordError .= 'Passwordun ilk herfi boyuk herf olmalidi <br>';
            }
            if (strlen($password) < 5 && $password !=='') {
                $passwordError .= 'Passwordun uzunlugu 5 den boyuk olmalidi <br>';
            }
            if (strlen($password) > 8  && $password !=='') {
                $passwordError .= 'Passwordun uzunlugu 8 den kicik olmalidi <br>';
            }


        $errors = array(
            'name' => $nameError,
            'email' => $emailError,
            'password' => $passwordError
        );



        $resp = json_encode($errors);
        header('Content-Type: application/json; charset=utf-8');
        echo $resp;

        exit();
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

    <form id="myForm" action="" method="get">
        <input name="name" id="name"/>
        <p style="color: red; margin: 5px 0 " id="errName"></p>
        <input name="email"  id="email"/>
        <p style="color: red; margin: 5px 0 " id="errEmail"></p>
        <input name="password" id="password"/>
        <p style="color: red; margin: 5px 0 " id="errPass"></p>
        <button type="submit">Send</button>
    </form>

    <div>
        <p id="nameSession"></p>
        <p id="emailSession"></p>
        <p id="passwordSession"></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $('#myForm').on('submit', (e)=>{
            e.preventDefault();

            let data = $('#myForm').serialize();

            $.ajax({
                url: 'index.php?action=save',
                method: 'GET',
                data: data,
                success: (res)=>{
                    if(res.name){
                        $('#name').css('border', '1px solid red')
                        $('#errName').html(res.name);
                    }else{
                        $('#name').css('border', '1px solid green')
                        $('#errName').html('');

                    }

                    if(res.email){
                        $('#email').css('border', '1px solid red')
                        $('#errEmail').html(res.email);
                    }else{
                        $('#email').css('border', '1px solid green')
                        $('#errEmail').html('');
                    }

                    if(res.password){
                        $('#password').css('border', '1px solid red')
                        $('#errPass').html(res.password);
                    }else{
                        $('#password').css('border', '1px solid green')
                        $('#errPass').html('');
                    }
                }
            })
        })
    </script>
</body>
</html>