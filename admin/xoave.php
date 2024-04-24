<?php
include '../assets/connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Lấy ID của vé từ URL và làm sạch để tránh tấn công SQL Injection
    $ve_id = $_GET['id'];

    // Thực hiện câu truy vấn SQL để xóa vé
    $sql = "DELETE FROM ve WHERE IDVe = '$ve_id'";
    $result_delete = mysqli_query($conn, $sql);
    if ($result_delete) {
        header("Location: listve.php");
    } else {
        $msg = '<div class="alert alert-danger" role="alert">
        Xóa thất bại
    </div>';
    }
} else {
    // Nếu không có ID vé được truyền từ URL, cung cấp thông báo lỗi hoặc chuyển hướng người dùng đến trang khác
    echo "Không có ID vé được cung cấp hoặc ID vé không hợp lệ.";
}
?>