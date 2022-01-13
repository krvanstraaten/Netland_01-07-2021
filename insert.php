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
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        th {
            display: flex;
            justify-content: start;
            padding-right: 10px;
        }
    </style>
    <title>Add Media</title>
</head>
<body>

<a href="index.php">< Terug</a><br>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'media_type' => $_POST["media_type"],
        'title' => $_POST["title"],
        'description' => $_POST["description"],
        'rating' => $_POST["rating"],
        'has_won_awards' => $_POST["has_won_awards"],
        'seasons' => $_POST["seasons"],
        'duration' => $_POST["duration"],
        'country_of_origin' => $_POST["country_of_origin"],
        'language' => $_POST["language"],
        'release_date' => $_POST["release_date"],
        'youtube_trailer_id' => $_POST["youtube_trailer_id"]
    ];

    $add = "INSERT INTO media
    SET media_type=:media_type, title=:title, description=:description, rating=:rating, has_won_awards=:has_won_awards, seasons=:seasons,
    duration=:duration, country_of_origin=:country_of_origin, language=:language, release_date=:release_date, youtube_trailer_id=:youtube_trailer_id";
    $pdo->prepare($add)->execute($data);

    header("Location: index.php");
}
?>

<h1>Nieuwe serie</h1>
<form method = "POST">
    <table>
        <tr>
            <th><b>Title</b></th>
            <td><input type="text" name="title"></td>
        </tr>
        <tr>
            <th><b>Media type</b></th>
            <td><label>Series</label><input type="radio" name="media_type" value="series"><label>Movie</label><input type="radio" name="media_type" value="movie"></td>
        </tr>
        <tr>
            <th><b>Rating</b></th>
            <td><input type="text" name="rating"></td>
        </tr>
        <tr>
            <th><b>Has won awards</b></th>
            <td><input type="number" name="has_won_awards""></td>
        </tr>
        <tr>
            <th><b>Seasons</b></th>
            <td><input type="number" name="seasons"></td>
        </tr>
        <tr>
            <th><b>Duration</b></th>
            <td><input type="number" name="duration"></td>
        </tr>
        <tr>
            <th><b>Country of origine</b></th>
            <td><input type="text" name="country_of_origin"></td>
        </tr>
        <tr>
            <th><b>Language</b></th>
            <td><input type="text" name="language"></td>
        </tr>
        <tr>
            <th><b>Release date</b></th>
            <td><input type="date" name="release_date"></td>
        </tr>
        <tr>
            <th><b>Description</b></th>
            <td><textarea name="description" style="width:300px; height:300px; resize: none;"></textarea></td>
        </tr>
        <tr>
            <th><b>YouTube trailer id</b></th>
            <td><input type="text" name="youtube_trailer_id"></td>
        </tr>
    </table>
    <input type="submit" value="add">
    </form>

</body>
</html>