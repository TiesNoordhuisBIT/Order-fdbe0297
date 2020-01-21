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
    if (isset($_GET["series"])) {
        if ($_GET['series'] === "titel") {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $series = $pdo->query('SELECT * FROM netland.series ORDER BY title ASC');
            $movies = $pdo->query('SELECT * FROM netland.films');
        } elseif ($_GET['series'] === "rating") {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $series = $pdo->query('SELECT * FROM netland.series ORDER BY rating DESC');
            $movies = $pdo->query('SELECT * FROM netland.films');
        }
    } elseif (isset($_GET["films"])) {
        if ($_GET['films'] === "duur") {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $series = $pdo->query('SELECT * FROM netland.series');
            $movies = $pdo->query('SELECT * FROM netland.films ORDER BY duration DESC');
        } elseif ($_GET['films'] === "titel") {
            $pdo = new PDO($dsn, $user, $pass, $options);
            $series = $pdo->query('SELECT * FROM netland.series');
            $movies = $pdo->query('SELECT * FROM netland.films ORDER BY title ASC');
        }
    } else {
        $pdo = new PDO($dsn, $user, $pass, $options);
        $series = $pdo->query('SELECT * FROM netland.series');
        $movies = $pdo->query("SELECT * FROM netland.films;");
    }
} catch (\PDOException $e) {
    // echo $e->getMessage();
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netland!</title>
    <style>
        body {
            background-image: linear-gradient(120deg, #a6c0fe 0%, #f68084 100%);
        }

        #sorting {
            font-style: italic;
            color: grey
        }

        ;
    </style>
</head>

<body>
    <h1>Welkom op het netland beheerderspaneel</h1>
    <h2>Series</h2>
    <table>
        <tr>
            <th><a href="index.php?series=titel">Titel</a></th>
            <th><a href="index.php?series=rating">Rating</a></th>
        </tr>
        <?php foreach ($series as $serieRow) { ?>
            <tr>
                <td><?php echo $serieRow['title']; ?></td>
                <td><?php echo $serieRow['rating']; ?> ★</td>
                <td><a href="series.php?id=<?php echo $serieRow['id']; ?>">Bekijk details</a></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (isset($_GET["series"])) { ?>
        <p id="sorting">Active sorting: <?php echo $_GET["series"] ?> </p>
    <?php } ?>

    <h2>Films</h2>
    <table>
        <tr>
            <th><a href="index.php?films=titel">Titel</a></th>
            <th><a href="index.php?films=duur">Duur</a></th>
        </tr>
        <?php foreach ($movies as $movieRow) { ?>
            <tr>
                <td><?php echo $movieRow['title']; ?></td>
                <td><?php echo $movieRow['duration']; ?> minuten</td>
                <td><a href="films.php?id=<?php echo $movieRow['id']; ?>">Bekijk details</a></td>
            </tr>
        <?php } ?>
    </table>
    <?php if (isset($_GET["films"])) { ?>
        <p id="sorting">Active sorting: <?php echo $_GET["films"] ?> </p>
    <?php } ?>
    <form action="index.php">
        <button>Reset sorting</button>
    </form>

</body>

</html>