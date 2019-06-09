<?php include("php/regauth.php") ?>
<?php include("php/newticket.php") ?>

<?php if ($_SESSION['role'] == 'admin') : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ticket Bucket</title>
        <link rel="stylesheet" href="/ticketbucket/static/style.css">
        <link rel="stylesheet" href="/ticketbucket/static/signin-form.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <div>
            <?php include("php/navbar.php") ?>
        </div>

        <div class="signin-form">
            <?php include("php/errors.php")?>
            <form enctype="multipart/form-data" action="controlpanel.php" method="POST">
                <div class="from-group">
                    <h4>Обложка фильма</h4>
                    <div class="input-group mt-4">
                        <div class="custom-file">
                            <input type="file" name="picture" class="custom-file-input" id="inputGroupFile04">
                            <label class="custom-file-label" for="inputGroupFile04">Выберите файл</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <h4>Название фильма</h4>
                    <input type="text" class="form-control mt-4" id="exampleInputText1" aria-describedby="textHelp" name="name" placeholder="Введите название фильма">
                </div>
                <div class="form-group mt-4">
                    <h4>Краткое описание сюжета фильма</h4>
                    <label for="exampleFormControlTextarea1"></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="discription"></textarea>
                </div>
                <div class="form-group mt-4">
                    <h4>Цена билета</h4>
                    <input type="text" class="form-control mt-4" id="exampleInputText1" aria-describedby="textHelp" name="price" placeholder="Введите цену одного билета">
                </div>
                <button class="btn btn-outline-secondary mt-3" type="submit">Создать</button>
                <div class="form-group mt-4"></div>
            </form>
        </div>
    </body>

    </html>
<?php else : ?>
    <?php include("php/error403.php") ?>
<?php endif ?>