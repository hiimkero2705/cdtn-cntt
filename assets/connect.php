<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookingcinema";
// Kiểm tra kết nối
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    die("" . mysqli_connect_error());
} else {
}

?>