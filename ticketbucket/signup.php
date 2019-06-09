<?php include("php/regauth.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Bucket</title>
    <link rel="stylesheet" href="/ticketbucket/static/signup-form.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div>
        <?php include("php/navbar.php") ?>
    </div>
    <div class="signup-form">
        <?php include('php/errors.php'); ?>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="exampleInputLogin1">Логин</label>
                <input type="login" class="form-control" id="exampleInputLogin1" placeholder="username" name="username">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Адрес электронной почты</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email">
                <small id="emailHelp" class="form-text text-muted">Мы не будем ни с кем делиться вашим персональными данными.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword2">Подтвердите пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name="password2">
            </div>
            <button type="submit" class="btn btn-primary" name="reg_user">Зарегистрироваться</button>
        </form>
    </div>

</body>

</html>