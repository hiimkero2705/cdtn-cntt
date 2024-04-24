<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '1086183031604-rqip5gcle7di65pi9l7krjf2n3cokuhd.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/anime/?page=login';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email = $google_account_info->email;
  $name = $google_account_info->name;
  $google_id = $google_account_info->id; // Lấy Google ID của người dùng

  $conn = new PDO("mysql:host=localhost;dbname=bookingcinema", "root", "");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Kiểm tra xem Google ID đã tồn tại trong cơ sở dữ liệu chưa
  $stmt_check_google_id = $conn->prepare("SELECT IDKH FROM khachhang WHERE IDKH = :google_id");
  $stmt_check_google_id->bindParam(':google_id', $google_id);
  $stmt_check_google_id->execute();
  $existing_user = $stmt_check_google_id->fetch(PDO::FETCH_ASSOC);

  // Nếu Google ID chưa tồn tại trong cơ sở dữ liệu
  if (!$existing_user) {
    // Thêm thông tin người dùng vào cơ sở dữ liệu
    $stmt_insert = $conn->prepare("INSERT INTO khachhang (Email, TenKH, IDKH) VALUES (:email, :name, :google_id)");
    $stmt_insert->bindParam(':email', $email);
    $stmt_insert->bindParam(':name', $name);
    $stmt_insert->bindParam(':google_id', $google_id);
    $stmt_insert->execute();

    // Lấy ID mới được tạo ra cho người dùng
    $new_user_id = $conn->lastInsertId();

    // Thiết lập session cho người dùng
    session_start();
    $_SESSION['loggedin_customer'] = true; // Đánh dấu là đã đăng nhập
    $_SESSION['IDKH'] = $new_user_id; // Lưu ID mới của người dùng vào session
    // Các thông tin khác nếu cần

    // Chuyển hướng người dùng đến trang chính của ứng dụng của bạn
    header("Location: index.php");
    exit();
  } else {
    // Nếu Google ID đã tồn tại, không thực hiện thêm bản ghi mới vào cơ sở dữ liệu
    // Có thể chỉ cần thiết lập session và chuyển hướng người dùng đến trang chính
    session_start();
    $_SESSION['loggedin_customer'] = true; // Đánh dấu là đã đăng nhập
    $_SESSION['IDKH'] = $existing_user['IDKH']; // Lưu ID của người dùng vào session
    // Các thông tin khác nếu cần

    // Chuyển hướng người dùng đến trang chính của ứng dụng của bạn
    header("Location: index.php");
    exit();
  }

} else {
  //   echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>