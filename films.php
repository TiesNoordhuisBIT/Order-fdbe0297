<?php

$host = 'localhost';
$db   = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $id = $_GET["id"];
    $films = $pdo->query('SELECT * FROM netland.films WHERE id=' . $id)->fetchAll();
    $trailer = $films[0]["trailer"];
} catch (\PDOException $e) {
    // echo $e->getMessage();
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netland! - Films</title>
    <style>
        #bold {
            font-weight: bold
        }body {background-image: linear-gradient(120deg, #a6c0fe 0%, #f68084 100%);};
    </style>
</head>

<body>
    <a href="index.php">Terug</a>
    <h1><?php echo $films[0]["title"] . " - " . $films[0]["duration"] . " minuten" ?></h1>

    <table>
        <tr>
            <td id="bold">Datum van uitkomst</td>
            <td><?php echo $films[0]["release_date"] ?></td>
        </tr>
        <tr>
            <td id="bold">Land van uitkomst</td>
            <td><?php echo $films[0]["country"] ?></td>
        </tr>
    </table>

    <p id="bold">Storyline</p>
    <p><?php echo $films[0]["description"] ?></p>

    <p id="bold">Trailer</p>
    <iframe width="560" height="315" src="<?php echo $films[0]["trailer"] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</body>

</html>