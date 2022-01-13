<?php
    $host = '127.0.0.1';
    $db   = 'netland';
    $user = 'root';
    $pass = '';
    // default poort is 3306. als je een database error krijgt, wissel dan van port
    // $post = "3306";
    $port = "3307";
    $charset = 'utf8mb4';

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
    try {
        $pdo = new \PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    function createOrder($tableKey, $column)
    {
        $data = $_GET;
        $data[$tableKey] = $column;
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        return $url . '?' . http_build_query($data);
    }

    ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        th, td {
            padding-right: 10px;
        }
    </style>
    <title>overview</title>
</head>

<body>
    <h1>Welkom op het netland beheerderspaneel</h1>
    <h2>Series</h2>
    <table>
        <tr>
            <th><a href=<?= createOrder("orderSeries", "title")?>>Title</a></th>
            <th><a href=<?= createOrder('orderSeries', 'rating')?>>Rating</a></th>
        </tr>
<?php
try {
    if (isset($_GET["orderSeries"])) {
        $orderS = $_GET['orderSeries'];
    } else {
        $orderS = "title";
    }
        $MediaSeries = $pdo->prepare("SELECT * FROM media WHERE media_type = 'series' ORDER BY $orderS");
        $MediaSeries->execute();
        $Series = $MediaSeries->fetchAll();

    foreach ($Series as $sArrIndex => $sArray) {
        ?>
        <tr>
            <td><?= $sArray['title']?></td>
            <td><?= $sArray['rating']?></td>
            <td><a href="view.php?id=<?= $sArray['id']?>">bekijken</a></td>
            <td><a href="edit.php?id=<?= $sArray['id']?>">edit</a></td>
        </tr>
        <?php
    }
} catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
}
?>
    </table>
    <h2>Films</h2>
    <table>
        <tr>
            <th><a href=<?= createOrder('orderMovies', 'title')?>>Title</a></th>
            <th><a href=<?= createOrder('orderMovies', 'duration')?>>Duur</a></th>
        </tr>
<?php
try {
    if (isset($_GET["orderMovies"])) {
        $orderM = $_GET['orderMovies'];
    } else {
        $orderM = "title";
    }
        $MediaMovie = $pdo->prepare("SELECT * FROM media WHERE media_type = 'movie' ORDER BY $orderM");
        $MediaMovie->execute();
        $Movie = $MediaMovie->fetchAll();

    foreach ($Movie as $mArrIndex => $mArray) {
        ?>
        <tr>
            <td><?= $mArray['title']?></td>
            <td><?= $mArray['duration']?></td>
            <td><a href="view.php?id=<?= $mArray['id']?>">bekijken</a></td>
            <td><a href="edit.php?id=<?= $mArray['id']?>">edit</a></td>
        </tr>

        <?php
    }
} catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
}
?>
    </table>
    <br>
    <button><a href="insert.php">+ ADD</a></button>

    <?PHP
        $pdo = null;
    ?>
</body>
</html>