
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idve = $_POST['idve'];
    $idphim = $_POST['idphim'];
    $idrap = $_POST['idrap'];
    $idSuatchieu = $_POST['idSuatchieu'];
    $idghe = $_POST['idghe'];
    $tongtien = $_POST['tongtien'];
    $idkh = $_POST['idkh'];
    $payment_method = $_POST['payment_method'];

    // Xử lý thanh toán tương ứng với phương thức được chọn
    if ($payment_method == 'momo') {
        require_once 'thanhtoanmomo.php';
    } elseif ($payment_method == 'atm') {
        require_once 'thanhtoanatm.php';
    } elseif ($payment_method == 'cod') {
        require_once 'thanhtoancod.php';
    }elseif ($payment_method == 'vnpay') {
        require_once 'thanhtoanvnpay.php';
    } else {
        // Phương thức thanh toán không hợp lệ, xử lý tương ứng
        echo "Phương thức thanh toán không hợp lệ!";
    }
}
?>