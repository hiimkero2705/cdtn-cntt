<?php 
session_start();

// Xóa toàn bộ dữ liệu session
session_unset();

// Hủy phiên session
session_destroy();
header("Location: signin.php");
?>