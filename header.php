<?php 
if (isset($_SESSION['loggedin_customer'])) {
    $sql = "SELECT * FROM khachhang WHERE IDKH = '" . $_SESSION['IDKH'] . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $info = mysqli_fetch_assoc($result);
    }}
?>

<header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="./img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="?page=home">Trang chủ</a></li>
                                <li><a href="?page=phimdangchieu">Góc Điện Ảnh <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="?page=phimdangchieu">Đang công chiếu</a></li>
                                        <li><a href="./anime-watching.php">Anime Watching</a></li>
                                        <li><a href="./blog-details.php">Blog Details</a></li>
                                        <li><a href="./login.php">Đăng Nhập</a></li>
                                    </ul>
                                </li>
                                <li><a href="./blog.php">Our Blog</a></li>
                                <li><a href="#">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <?php 
                        if (isset($_SESSION['loggedin_customer']) && $_SESSION['loggedin_customer'] === true) {
                            echo '<a href="?page=thongtinkh"><span class="icon_profile"></span>' . $info['TenKH'] . '</a>
                            <a href="./confirm-logout.php"><span class="fa fa-sign-out"></span></a>
                            <a href="#"><span class="fa fa-history"></span></a>';
                        } else {
                            echo '<a href="?page=login"><span class="icon_profile"></span></a>';
                        } ?>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>