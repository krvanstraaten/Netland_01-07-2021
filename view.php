<?php
    $host = '127.0.0.1';
    $db   = 'netland';
    $user = 'root';
    $pass = '';
    // default poort is 3306. als je een resultbase error krijgt, wissel dan van port
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
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        iframe {
            width: 600px;
            height: 350px;
        }
    </style>
    <title>View page</title>
</head>
<body>

<a href="index.php">< Terug</a><br>
    
<?php
    $result = $pdo->prepare("SELECT * FROM media WHERE id = ?");
    $result->execute([$_GET["id"]]);
    $result = $result->fetchAll()[0];

if ($result['media_type'] == "series") {
    ?>
    <h1><?= $result['title'] . " - " . $result['rating'] . "/5"?></h1>
    <?php
} else if ($result['media_type'] == "movie") {
    ?>
    <h1><?= $result['title'] . " - " . $result['duration'] . " minutes"?></h1>
    <?php
}
if (!is_null($result['media_type'])) {
    echo '<p><b>Media type </b>' . $result["media_type"] . '</p>';
}
if (!is_null($result['rating'])) {
    echo '<p><b>Rating </b>' . $result['rating'] . ' out of 5</p>
    ';
}
if (!is_null($result['duration'])) {
    echo '<p><b>Duration </b>' . $result['duration'] . ' minutes</p>
    ';
}
if (!is_null($result['has_won_awards'])) {
    echo '<p><b>Total awards won </b>' . $result['has_won_awards'] . '</p>
    ';
}
if (!is_null($result['seasons'])) {
    echo '<p><b>Seasons </b>' . $result['seasons'] . '</p>';
}
if (!is_null($result['country_of_origin'])) {
    echo '<p><b>Country </b>' . $result['country_of_origin'] . '</p>';
}
if (!is_null($result['language'])) {
    echo '<p><b>Language </b>' . $result['language'] . '</p>';
}
if (!is_null($result['release_date'])) {
    echo '<p><b>Release date </b>' . $result['release_date'] . '</p>';
}
if (!is_null($result['country_of_origin'])) {
    echo '<p><b>Country </b>' . $result['country_of_origin'] . '</p>';
}
if (!is_null($result['description'])) {
    echo '<p><b>Description </b><br>' . $result['description'] . '</p>';
}
if (!is_null($result['youtube_trailer_id'])) {
    echo "<iframe src=https://www.youtube.com/embed/" . $result['youtube_trailer_id'] . "></iframe>";
}

    $pdo = null;
?>

</body>
</html>