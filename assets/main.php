<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_GET['page'])) {
        $tam = $_GET['page'];
    } else {
        $tam = '';
    }
    if ($tam == 'home') {
        include 'main/home.php';
    } elseif ($tam == 'movie' && isset($_GET['IDPhim'])) {
        include 'pages/movie-details.php';
    } else {
        include 'login.php';
    }
    ?>

</body>

</html>