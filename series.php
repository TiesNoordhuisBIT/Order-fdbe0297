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
    $series = $pdo->query('SELECT * FROM netland.series WHERE id=' . $id)->fetchAll();
} catch (\PDOException $e) {
    // echo $e->getMessage();
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netland! - Series</title>
    <style>
        #td {
            font-weight: bold
        }
        body {background-image: linear-gradient(120deg, #a6c0fe 0%, #f68084 100%);};
    </style>
</head>

<body>
    <a href="index.php">Terug</a>
    <h1><?php echo $series[0]["title"] ?></h1>
    <table>
        <tr>
            <td id="td">Awards?</td>
            <td><?php if ($series[0]["has_won_awards"] > 1) {
                    echo "Ja, " . $series[0]["has_won_awards"] . " awards";
                } elseif ($series[0]["has_won_awards"] = 1) {
                    echo "Ja, " . $series[0]["has_won_awards"] . " award";
                } else {
                    echo "Nee";
                } ?></td>
        </tr>
        <tr>
            <td id="td">Seasons</td>
            <td><?php echo $series[0]["seasons"] ?></td>
        </tr>
        <tr>
            <td id="td">Country</td>
            <td><?php echo $series[0]["country"] ?></td>
        </tr>
        <tr>
            <td id="td">Language</td>
            <td><?php echo $series[0]["language"] ?></td>
        </tr>
    </table>

    <p><?php echo $series[0]["description"] ?></p>
</body>

</html>