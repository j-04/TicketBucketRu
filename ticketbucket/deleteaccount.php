<?php include("php/regauth.php") ?>

<?php if (isset($_SESSION['role'])) :?>

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
        <form action="deleteaccount.php" method="POST">
            <div class="alert alert-danger" role="alert">
                <h3>Дважды введите свой пароль, чтобы подтвердить удаление аккаунта</h3>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="" name="password1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword2">Подтвердите пароль</label>
                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" value="" name="password2">
            </div>
            <button type="submit" class="btn btn-danger" name="delete_user">Удалить аккаунт</button>
        </form>
    </div>

</body>

</html>
<?php else : ?>
    <?php include("php/error403.php") ?>
<?php endif ?>