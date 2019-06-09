<?php
$path = "images/";
$picture_types = array('image/jpeg', 'image/png', 'image/jpg');
$errors = array();
$size = 1024000;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $discription = $_POST['discription'];
    $price = $_POST['price'];
    if (!in_array($_FILES['picture']['type'], $picture_types)) {
        array_push($errors, "Запрещенный тип файла! Допустимы типы .jpeg, .png, .jpg");
    }
    
    if ($_FILES['picture']['size'] > $size) {
        array_push($errors, "Файл слишком большой по размеру");
    }

    $price_pattern = "/^[0-9]+$/";
    $match = [];
    if (!preg_match($price_pattern, $price, $match)) {
        array_push($errors, "Введите число");
    }

    $check_exist_ticket = "SELECT * FROM user WHERE name='$name'";
    $result = mysqli_query($db, $check_exist_ticket);
    if (mysqli_num_rows($result) != 0) {
        array_push($errors, "Билет с таким именем уже существует");
    }

    if (count($errors) == 0) {
        $id_3 = uniqid("pref_", true);
        $picture_path = $path . $id_3 . $_FILES['picture']['name'];
        copy($_FILES['picture']['tmp_name'], $picture_path);
        $web_picture_path = "/" . "ticketbucket/" . $picture_path;
        $query = "INSERT INTO tickets(name, discription, price, picture_path) 
                        VALUES('$name', '$discription', '$price', '$web_picture_path')";
        mysqli_query($db, $query);
        header('location: tickets.php');
    }
  }
?>