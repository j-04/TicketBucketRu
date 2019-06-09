<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

session_start();
// инициализация полей
$username = "";
$email = "";
$errors = array();
$currentUserName = "";
$currentUserEmail = "";
$buy_success = false;
$buy_message = "";

$db = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'ticketbucket_db');

if (!$db) {
    echo "Error: Cant connect to database" . PHP_EOL;
    echo "Error code: " . mysqli_connect_error() . PHP_EOL;
    echo "Error content: " . mysqli_connect_error() . PHP_EOL;
}

if ($db) {
    // REGISTER USER
    if (isset($_POST['reg_user'])) {
        // receive all input values from the form
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password2']);

        // form validation: ensure that the form is correctly filled
        if (empty($username)) {
            array_push($errors, "вы не ввели имя");
        }
        if (empty($email)) {
            array_push($errors, "Вы не ввели адрес электронной почты");
        }
        if (empty($password_1)) {
            array_push($errors, "Вы не ввели пароль");
        }

        $login_pattern = "/^[a-zA-Z][a-z0-9-_\.]{1,20}/";
        $match = [];
        if (!preg_match($login_pattern, $username, $match)) {
            array_push($errors, "Имя пользователя должно состоят из 2-20 символов, включающие буквы и цифры. Первый символ должен быть буквой.");
        }
        $password_pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/";
        if (!preg_match($password_pattern, $password_1, $match)) {
            array_push($errors, "TПароль должен содержать буквы в верхнем и нижнем регистре и цифры.");
        }

        $email_pattern = "/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/";
        if (!preg_match($email_pattern, $email, $match)) {
            array_push($errors, "Вы ввели некоректный адресс электронной почты.");
        }

        if ($password_1 != $password_2) {
            array_push($errors, "Пароли не совпадают.");
        }

        $user_check_query = "SELECT * FROM user WHERE username = '$username' OR email = '$email' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if ($user['username'] === $username) {
                array_push($errors, "Имя уже используется");
            }

            if ($user['email'] === $email) {
                array_push($errors, "Адрес электронной почты уже используется");
            }
        }

        // register user if there are no errors in the form
        if (count($errors) == 0) {
            try {
            //     $mail = new PHPMailer(true);
            //     $mail->isSMTP();
            //     $mail->SMTPAuth = true;
            //     $mail->SMTPSecure = 'ssl';
            //     $mail->Host = 'smtp.yandex.ru';
            //     $mail->Port = '465';
            //     $mail->Username = 'ida-99-p';
            //     $mail->Password = 'yandex714mail';
            //     $mail->setFrom('ida-99-p@yandex.ru');
            //     $mail->Subject = 'Ticketbucket.ru';
            //     $mail->addAddress($email);
            //     $mail->Body = 'Вы были успешно зарегистрированы!';
            //     $mail->send();
                $password = md5($password_1); //encrypt the password before saving in the database
                $query = "INSERT INTO user (username, email, password, role) 
                        VALUES('$username', '$email', '$password', 'user')";
                mysqli_query($db, $query);
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 'user';
                $_SESSION['success'] = "You are now logged in";
                header('location: index.php');
            } catch (Exception $ex) {
                array_push($errors, "Неудалось совершить регистрацию. Какие - то неполадки на сервере, извините за доставленные неудобства.");
            
            }
        }
    }
}

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "вы не ввели имя");
    }
    if (empty($password)) {
        array_push($errors, "Вы не ввели пароль");
    }

    $login_pattern = "/^[a-zA-Z][a-z0-9-_\.]{1,20}/";
    $match = [];
    if (!preg_match($login_pattern, $username, $match)) {
        array_push($errors, "Имя пользователя должно состоят из 2-20 символов, включающие буквы и цифры. Первый символ должен быть буквой.");
    }

    $password_pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/";
    if (!preg_match($password_pattern, $password, $match)) {
        array_push($errors, "Пароль должен содержать буквы в верхнем и нижнем регистре и цифры.");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM user WHERE username = '$username' AND password='$password' LIMIT 1";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            array_push($errors, "Неверное имя или пароль");
        }
    }
}

if (isset($_POST['logout_user'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['role']);
    header("location: index.php");
}

//Изменение данных учетной записи
if (isset($_POST['change_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "вы не ввели имя");
    }
    if (empty($password_1)) {
        array_push($errors, "Вы не ввели пароль");
    }

    $login_pattern = "/^[a-zA-Z][a-z0-9-_\.]{1,20}/";
    $match = [];
    if (!preg_match($login_pattern, $username, $match)) {
        array_push($errors, "Имя пользователя должно состоят из 2-20 символов, включающие буквы и цифры. Первый символ должен быть буквой.");
    }
    $password_pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/";
    if (!preg_match($password_pattern, $password_1, $match)) {
        array_push($errors, "Пароль должен содержать буквы в верхнем и нижнем регистре и цифры.");
    }

    $email_pattern = "/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/";
    if (!preg_match($email_pattern, $email, $match)) {
        array_push($errors, "Вы ввели некоректный адресс электронной почты.");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $old_username = $_SESSION['username'];
        $user = "SELECT * FROM user WHERE username = '$old_username' and password = '$password'";
        $user_result = mysqli_query($db, $user);
        if (mysqli_num_rows($user_result) == 0) {
            array_push($errors, "Wrong password!");
        } else {
            $query = "SELECT * FROM user WHERE (username = '$username' or email = '$email') and username != '$old_username' LIMIT 1";
            $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 0) {
                $query = "UPDATE user SET username ='$username', email = '$email' WHERE username = '$old_username'";
                mysqli_query($db, $query);
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: index.php');
            } else {
                array_push($errors, "Пользователь с такими данными уже существует");
            }
        }
    }
}

if (isset($_POST['delete_user'])) {
    $password_1 = mysqli_real_escape_string($db, $_POST['password1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password2']);
    $username = $_SESSION['username'];
    if (empty($password_1) || empty($password_2)) {
        array_push($errors, "Вы не ввели пароль");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Пароли не совпадают");
    }
    if (count($errors) == 0) {
        $password = md5($password_1);
        $query = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $query = "DELETE FROM user WHERE username = '$username'";
            mysqli_query($db, $query);
            session_destroy();
            unset($_SESSION['username']);
            header("location: index.php");
        } else {
            array($errors, "Неверный пароль");
        }
    }
}

if (isset($_POST['buy_ticket'])) {
    $id = $_POST['id'];
    $number_card = $_POST['num_card'];
    $cvv = $_POST['cvv'];
    $quantity = $_POST['quantity'];
    $day = $_POST['day'];
    $card_pattern = "/[0-9]{13,16}/";
    $match = [];
    if (!preg_match($card_pattern, $number_card, $match)) {
        array_push($errors, "Неверный формат номера банковской карты. Пример: 7777888899990000");
    }

    $cvv_pattern = "/[0-9]{3}/";
    if (!preg_match($cvv_pattern, $cvv, $match)) {
        array_push($errors, "Неверный формат кода cvv. Пример: 777");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM tickets WHERE id = '$id'";
        $result = mysqli_query($db, $query);
        $ticket = mysqli_fetch_assoc($result);
        $ticket_name = $ticket['name'];
        $ticket_price = $ticket['price'];
        $email = $_SESSION['email'];

        try {
            // $message = "Вы купили билет на фильм " . $ticket_name . ".\nДень сеанса: " . $day . ".\n";
            // $mail = new PHPMailer(true);
            // $mail->isSMTP();
            // $mail->SMTPAuth = true;
            // $mail->SMTPSecure = 'ssl';
            // $mail->Host = 'smtp.yandex.ru';
            // $mail->Port = 465;
            // $mail->Username = 'ida-99-p';
            // $mail->Password = 'yandex714mail';
            // $mail->setFrom('ida-99-p@yandex.ru');
            // $mail->Subject = 'Ticketbucket.ru';
            // $mail->addAddress($email);
            // $mail->Body = $message;
            // $mail->send();
            $buy_success = true;
            $buy_message = "Вы успешно купили билет на фильм: $ticket_name. Количество билетов: $quantity. Исходная стоимость: " . $quantity*$ticket_price;
        } catch (Exception $ex) {
            array_push($errors, "Неудалось совершить покупку блиета. Какие - то неполадки на сервере, извините за доставленные неудобства.");
            $buy_success = false;
        }
    }
}

if (isset($_POST['delete_ticket'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM tickets WHERE id = $id";
    mysqli_query($db, $query);
    header("/tickets.php");
}
