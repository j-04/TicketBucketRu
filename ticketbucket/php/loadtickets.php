<?php
$db = mysqli_connect('127.0.0.1:3306', 'root', 'root', 'ticketbucket_db');

if (!$db) {
    echo "Error: Cant connect to database" . PHP_EOL;
    echo "Error code: " . mysqli_connect_error() . PHP_EOL;
    echo "Error content: " . mysqli_connect_error() . PHP_EOL;
}

$query = "SELECT * FROM tickets";
$results = mysqli_query($db, $query);
$array = array();
while ($row = mysqli_fetch_assoc($results)) {
    $array[] = $row;
}
?>

<?php for ($i = 0; $i < count($array); $i++) : ?>
    <section>
        <div class="container py-3">
            <?php include("php/errors.php") ?>
            <div class="card">
                <div class="row ">
                    <div class="col-md-4">
                        <img src="<?php echo $array[$i]['picture_path'] ?>" height="400" style="width: 20rem;">
                    </div>
                    <div class="col-md-8 px-3">
                        <div class="card-block px-3">
                            <form action="tickets.php" method="POST">
                                <h4 class="card-title"><?php echo $array[$i]['name'] ?></h4>
                                <p class="card-text"><?php echo $array[$i]['discription'] ?></p>
                                <h4>Цена: <?php echo $array[$i]['price'] ?></h4>
                                <select class="mt-3" name="day">
                                    <option selected value="Понедельник">Понедельник</option>
                                    <option value="Вторник">Вторник</option>
                                    <option value="Среда">Среда</option>
                                    <option value="Четверг">Четверг</option>
                                    <option value="Пятница">Пятница</option>
                                    <option value="Суббота">Суббота</option>
                                    <option value="Воскресенье">Воскресенье</option>
                                </select>
                                <h4 class="mt-3">Количество билетов</h4>
                                <input class="form-control mt-3" type="text" name="quantity" value="1" placeholder="Quantity">
                                <h4 class="mt-3">Номер банковской карты и код CVV2</h4>
                                <div class="form-row mt-3">
                                    <div class="col-7">
                                        <input type="text" class="form-control" placeholder="Номер банковской карты" name="num_card">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="CVV2" name="cvv">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $array[$i]['id'] ?>">
                                <button type="submit" class="btn btn-primary mt-3" name="buy_ticket">Купить</button>
                                <?php if ($_SESSION['role'] == 'admin') :?>
                                <button type="submit" class="btn btn-danger mt-3" name="delete_ticket">Удалить билет</button>
                                <?php endif ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endfor ?>