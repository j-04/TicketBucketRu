<?php include("php/regauth.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Bucket</title>
    <link rel="stylesheet" href="/ticketbucket/static/signin-form.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div>
        <?php include("php/navbar.php") ?>
    </div>
    <div class="signin-form">
        <?php include('php/errors.php'); ?>
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <form action="signin.php" method="POST">
            <div class="form-group">
                <label for="exampleInputLogin1">Логин</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Enter username" name="username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login_user">Submit</button>
        </form>
    </div>
</body>

</html>