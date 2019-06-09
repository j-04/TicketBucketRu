<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/ticketbucket/">Ticketbucket</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/ticketbucket/">Главная страница<span class="sr-only">(current)</span></a>
                    </li>

                    <?php if (isset($_SESSION['success'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/ticketbucket/tickets.php">Билеты</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/ticketbucket/changeprofile.php">Изменить параметры учетной записи</a>
                        </li>
                        <?php if ($_SESSION['role'] == 'admin') :?>
                        <li class="nav-item">
                            <a class="nav-link" href="controlpanel.php">Добавить новый билет</a>
                        </li>
                        <?php endif ?>
                    <?php endif ?>
                </ul>
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success my-2 my-lg-0 mr-2" role="alert">
                        <?php
                        echo "Welcome, ", $_SESSION['username'], "!";
                        ?>
                    </div>
                    <form class="form-inline my-2 my-lg-0" action="index.php" method="POST">
                        <a href="deleteaccount.php" class="btn btn-danger my-2 my-sm-0 mr-2">Удалить аккаунт</a>
                        <button type="submit" class="btn btn-dark my-2 my-sm-0" name="logout_user">Выйти из аккаунта</button>
                    </form>
                <?php endif ?>
                <?php if (!isset($_SESSION['success'])) : ?>
                    <form class="form-inline my-2 my-lg-0">
                        <a class="btn btn-dark my-2 my-sm-0" href="/ticketbucket/signin.php">Авторизация</a>
                        <a class="btn btn-dark my-2 my-sm-0" href="/ticketbucket/signup.php">Регистрация</a>
                    </form>
                <?php endif ?>
            </div>
        </nav>