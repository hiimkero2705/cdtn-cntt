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
        include 'home.php';
    }elseif ($tam == 'login') {
        include 'login.php';
    }elseif ($tam == 'phimdangchieu') {
        include 'phimdangchieu.php';
    }elseif ($tam == 'chitietphim' && isset($_GET['IDPhim'])) {
        include 'chitietphim.php';
    }elseif ($tam == 'trailerphim' && isset($_GET['IDPhim'])) {
        include 'trailerphim.php';
    }elseif ($tam == 'dangky') {
        include 'dangky.php';
    }elseif ($tam == 'thongtinkh') {
        include 'thongtinkh.php';
    }elseif ($tam == 'quenmatkhau') {
        include 'quenmatkhau.php';
    }elseif ($tam == 'datve') {
        include 'datve.php';
    }elseif ($tam == 'chonghe') {
        include 'chonghe2.php';
    }elseif ($tam == 'lichsudatve') {
        include 'lichsudatve.php';
    }elseif ($tam == 'chitietve') {
        include 'chitietve.php';
    }elseif ($tam == 'chitietthanhtoan') {
        include 'chitietthanhtoan.php';
    }elseif ($tam == 'camon') {
        include 'camon.php';
    }
    else {
        include 'home.php';
    }
    ?>
</body>

</html>