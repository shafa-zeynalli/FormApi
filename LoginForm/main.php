<?php
include 'database.php';


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

    if ($password === '') {
        $passwordError .= 'Password bos buraxilmamalidi <br>';
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

    $database = new Database();

    if (!$emailError && !$passwordError) {
        $resultQuery = $database->getUsers($email,$password);
        session_start();
        $_SESSION['email']= $email;
        $_SESSION['pass']= $password;
        print_r($_SESSION);
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

    }
    else if (!$nameError && !$n1emailError && !$n1passwordError && !$n2passwordError && $n1password === $n2password) {
        $resultQuery = $database->getEmail($n1email);

        if ($resultQuery->num_rows > 0) {
            $errorMessage3 = 'Bu email ile giris olunub basqa email yazin';
        } else {
            $database->addQuery($name, $n1email,$n1password);
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
    }
    else {
        $errors['success'] = false;
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($errors);
    }
    exit();
    $database->connStop();
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
    <link rel="stylesheet" href="style.css">
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

<script src="script.js"></script>
</body>
</html>