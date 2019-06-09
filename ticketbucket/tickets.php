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

    <?php if ($buy_success) : ?>
    <section>
        <div class="container py-3 mt-4">
            <div class="alert alert-success" role="alert">
                <?php echo $buy_message;?>
            </div>
        </div>
    </section>
    <?php endif ?>
    <section>
        <div class="container py-3">
            <?php include("php/loadtickets.php") ?>
        </div>
    </section>
</body>

</html>

<?php else : ?>
    <?php include("php/error403.php") ?>

<?php endif ?>