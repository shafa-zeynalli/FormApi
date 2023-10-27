<?php
$servername = 'localhost';
$username = 'root';
$serverpassword = '';
$dbname = 'test';


if (isset($_GET['action'])) {
    $emailError = '';
    $passwordError = '';
    $nameError = '';
    $n1emailError = '';
    $n1passwordError = '';
    $n2passwordError = '';
    $errorMessage = '';
    $errorMessage2 = '';
    $errorMessage3 = '';


    $email = $_GET['email'] ?? '';
    $password = $_GET['password'] ?? '';

    $name = $_GET['name'] ?? '';
    $n1email = $_GET['n1email'] ?? '';
    $n1password = $_GET['n1password'] ?? '';
    $n2password = $_GET['n2password'] ?? '';

    if ($email === '') {
        $emailError = 'Email bos buraxilmamalidi';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Emailde @ simvolu olmalidi';
    }

    if ($n1email === '') {
        $n1emailError = 'Email bos buraxilmamalidi';
    }
    if ($n1email !== '' && !filter_var($n1email, FILTER_VALIDATE_EMAIL)) {
        $n1emailError = 'Emailde @ simvolu olmalidi';
    }

    if ($name === '') {
        $nameError = 'Istifadeci adi bos buraxilmamalidi';
    }

    if ($n1password === '') {
        $n1passwordError = 'Password bos buraxilmamalidi';
    }

    if ($n2password === '') {
        $n2passwordError = 'Password bos buraxilmamalidi';
    }

    if ($n1password !== $n2password) {
        $errorMessage2 = 'Yuxaridaki password ile asagidaki password eyni olmalidi';
    }

    $passwordToUpper = substr($password, 0, 1) === strtoupper(substr($password, 0, 1));

    if ($password === '') {
        $passwordError .= 'Password bos buraxilmamalidi <br>';
    }



    $conn = new mysqli($servername, $username, $serverpassword, $dbname);

    if ($conn->connect_error) {
        die('connection failed: ' . $conn->connect_error);
    }


    $errors = array(
        'name' => $nameError,
        'email' => $emailError,
        'email1' => $n1emailError,
        'password' => $passwordError,
        'password1' => $n1passwordError,
        'password2' => $n2passwordError,
        'erMessage' => $errorMessage,
        'erMessage2' => $errorMessage2,
        'erMessage3' => $errorMessage3,
    );


    if (!$emailError && !$passwordError) {
        $isQuery = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $resultQuery = $conn->query($isQuery);

        if ($resultQuery->num_rows == 0) {
            $errorMessage = 'İstifadeçi adı ve ya şifrə yalnışdı ';

        }
        if ($errorMessage) {
            $errors['erMessage'] = $errorMessage;
        } else {
            $errors['success'] = true;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($errors);

    } else if (!$nameError && !$n1emailError && !$n1passwordError && !$n2passwordError && $n1password === $n2password) {
        $isQuery2 = "SELECT * FROM user WHERE email = '$n1email'";
        $resultQuery = $conn->query($isQuery2);

        if ($resultQuery->num_rows > 0) {
            $errorMessage3 = 'Bu email ile giris olunub basqa email yazin';
        } else {
            $insertQuery = "INSERT INTO user (name, email, password) VALUES ('$name','$n1email', '$n1password')";
            $conn->query($insertQuery);
        }

        if ($errorMessage3) {
            $errors['erMessage3'] = $errorMessage3;
            $errors['success2'] = false;
        }
        else {
            $errors['success2'] = true;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($errors);
    } else {
        $errors['success'] = false;
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($errors);
    }
    exit();
    $conn -> stop();
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
    <style>
        form {
            display: flex;
            box-sizing: border-box;
            flex-direction: column;
            width: 50%;
            margin: 50px auto;
        }

        form p {
            font-size: 12px;
            color: red;
        }

        input {
            box-sizing: border-box;
            margin: 5px 0;
            padding: 5px;
            width: 100%;
            border: 1px solid green;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #04a7a7;
            border: none;
            color: white;
            font-size: 18px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        form button:hover {
            background-color: #047575;
            cursor: pointer;
        }

        div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 50%;
            height: 200px;
            font-size: 54px;
            background-color: #04a7a7;
            color: white;
            text-align: center;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            padding: 50px 30px 30px;
            box-shadow: 3px 4px 4px rgba(0, 0, 0, 0.4);
            display: none;
        }

        #myForm2 {
            display: none
        }
    </style>
</head>
<body>
<form action="" method="get" id="myForm">
    <h2>Login  Form </h2>
    <label for="email"> Emaili daxil edin:
        <input id="email" name="email">
    </label>
    <p id="errorEmail"></p>
    <label for="password">Passwordu daxil edin:
        <input id="password" name="password">
    </label>
    <p id="errorPassword"></p>
    <button type="submit" id="btn">LOGIN</button>
    <button id="btnSignUp">Sign Up</button>
</form>


<form action="" method="get" id="myForm2">
    <h2>Sign Up Form </h2>
    <label for="name"> İstifadəçi adınızı daxil edin:
        <input id="name" name="name">
    </label>
    <p id="errorName"></p>

    <label for="n1email"> Emaili daxil edin:
        <input id="n1email" name="n1email">
    </label>
    <p id="n1errorEmail"></p>

    <label for="n1password">Yeni passwordu daxil edin:
        <input id="n1password" name="n1password">
    </label>
    <p id="n1errorPassword"></p>

    <label for="n2password">Passwordu yenidən daxil edin:
        <input id="n2password" name="n2password">
    </label>
    <p id="n2errorPassword"></p>

    <button type="submit" id="btnSignUp2">SIGN UP</button>
    <button id="btn2">LOGIN</button>

</form>


<div></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>

    $('#myForm').on('submit', (e) => {
        e.preventDefault();

        let data = $('#myForm').serialize();
        // console.log(data)

        $.ajax({
            url: 'loginForm.php?action=save',
            method: 'GET',
            data: data,
            success: (res) => {
                console.log(res)
                if (res.success) {
                    var emailValue = $('#email').val();
                    var passwordValue = $('#password').val();
                    var combinedValue = 'Email: ' + emailValue + " " + '<br>Password: ' + passwordValue;

                    $('div').html(combinedValue);
                    $('#myForm').css('display', 'none');
                    $('div').css('display', 'block');
                    $('#errorPassword').html('');

                } else {
                    if (res.email) {
                        $('#email').css('border', '1px solid red')
                        $('#errorEmail').html(res.email);
                    } else {
                        $('#email').css('border', '1px solid green')
                        $('#errorEmail').html('');

                    }

                    if (res.password) {
                        $('#password').css('border', '1px solid red')
                        $('#errorPassword').html(res.password);
                    } else {
                        $('#password').css('border', '1px solid green')
                        $('#errorPassword').html('');
                    }

                    if (!res.password && !res.email && res.erMessage) {
                        $('#errorPassword').html(res.erMessage);
                    }
                }

            }
        })

    })

    $('#myForm2').on('submit', (e) => {
        e.preventDefault();

        let data = $('#myForm2').serialize();
        // console.log(data)

        $.ajax({
            url: 'loginForm.php?action=save',
            method: 'GET',
            data: data,
            success: (res) => {
                console.log(res)
                // if (res.success) {
                //     $('#myForm').css('display', 'none');
                //     $('div').css('display', 'block');
                //     $('#errorPassword').html('');
                //
                // } else {

                if (res.name) {
                    $('#name').css('border', '1px solid red')
                    $('#errorName').html(res.name);
                } else {
                    $('#name').css('border', '1px solid green')
                    $('#errorName').html('');
                }
                if (res.email1) {
                    $('#n1email').css('border', '1px solid red')
                    $('#n1errorEmail').html(res.email1);
                } else {
                    $('#n1email').css('border', '1px solid green')
                    $('#n1errorEmail').html('');
                }

                if (res.password2) {
                    $('#n2password').css('border', '1px solid red')
                    $('#n2errorPassword').html(res.password2);
                } else {
                    $('#n2password').css('border', '1px solid green')
                    $('#n2errorPassword').html('');
                }

                if (res.password1) {
                    $('#n1password').css('border', '1px solid red')
                    $('#n1errorPassword').html(res.password1);
                } else {
                    $('#n1password').css('border', '1px solid green')
                    $('#n1errorPassword').html('');
                }

                if (!res.password1 && !res.password2 && res.erMessage2) {
                    $('#n2errorPassword').html(res.erMessage2);
                }
                if (!res.password1 && !res.password2 && res.erMessage3) {
                    $('#n2errorPassword').html(res.erMessage3);
                }

                if(res.success2){
                    $('#myForm2').css('display', 'none');
                    $('div').css('display', 'block');
                    $('div').html('Təbriklər qeydiyyatdan ugurla kecdiniz')
                    $('#n2errorPassword').html('');
                }


            }
        })

    })

    $('#btnSignUp').on('click', () => {
        $('#myForm').css('display', 'none');
        $('#myForm2').css('display', 'block');
    })
    $('#btn2').on('click', () => {
        $('#myForm').css('display', 'block');
        $('#myForm2').css('display', 'none');
    })


</script>
</body>
</html>