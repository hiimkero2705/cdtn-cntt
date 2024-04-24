<?php
include 'assets/connect.php';
// Kiểm tra xem dữ liệu đã được gửi từ yêu cầu POST chưa
if (isset($_POST['idphim']) && isset($_POST['idrap']) && isset($_POST['idSuatchieu']) && isset($_POST['idghe']) && isset($_POST['idkh'])) {
    // Lấy thông tin từ yêu cầu POST
    $idPhim = $_POST['idphim'];
    $idRap = $_POST['idrap'];
    $idSuatChieu = $_POST['idSuatchieu'];
    $ghes = explode(',', $_POST['idghe']);
    $idkh = $_POST['idkh'];
    $tongtien = $_POST['tongtien'];
    $diemTichLuy = count($ghes) * 10; // Tính điểm tích lũy dựa trên số lượng ghế đặt vé
    
    $sqlGetDiemTichLuy = "SELECT diemtichluy, bac FROM KhachHang WHERE IDKH = '$idkh'";
    $result = mysqli_query($conn, $sqlGetDiemTichLuy);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $diemHienTai = $row['diemtichluy'];
        $bacHienTai = $row['bac'];
    
        $diemMoi = $diemHienTai + $diemTichLuy;
        if ($diemMoi >= 100) {
            $diemMoi = $diemMoi - 100; // Trở về 0 nếu đạt 100 điểm
            $bacMoi = $bacHienTai + 1; // Tăng bậc lên 1
        } else {
            $bacMoi = $bacHienTai; // Giữ nguyên bậc nếu chưa đạt 100 điểm
        }
    
        $sqlUpdateDiem = "UPDATE KhachHang SET diemtichluy = $diemMoi, bac = $bacMoi WHERE IDKH = '$idkh'";
        if (mysqli_query($conn, $sqlUpdateDiem)) {
            
        } else {
            // Xử lý lỗi khi cập nhật điểm tích lũy
        }
    } else {
        // Xử lý lỗi khi lấy thông tin điểm tích lũy
    }
    $IDHoaDon = ""; // Khởi tạo biến IDHoaDon để lưu ID của hóa đơn
    foreach ($ghes as $idGhe) {
        $currentDateTime = date("YmdHis");
        $timebooking = date("Y/m/d H:i:s"); // Định dạng Y/m/d H:i:s: Year/Month/Day Hour:Minute:Second
        $IDVe = "VE" . $currentDateTime . $idGhe;
        $sql = "INSERT INTO Ve (IDVe, IDSuat, IDPhim, IDGhe, IDKH, TimeBooking, IDRap) VALUES ('$IDVe', '$idSuatChieu', '$idPhim', '$idGhe', '$idkh', '$timebooking', '$idRap')";
        if (mysqli_query($conn, $sql)) {
            $IDHoaDon = "HD" . $currentDateTime;
        } else {
            // Xử lý lỗi khi thêm dữ liệu
        }
    }
    if (!empty($IDHoaDon)) {
        $ghesStr = implode(',', $ghes); // Chuyển mảng $ghes thành chuỗi để lưu vào cột 'Ghe'
        $sqlInsertHoaDon = "INSERT INTO hoadon (IDHoaDon, IDKH, IDPhim, IDSuat, IDRap, Ghe, TongTien, ThoiGianThanhToan) VALUES ('$IDHoaDon', '$idkh', '$idPhim', '$idSuatChieu', '$idRap', '$ghesStr', '$tongtien', '$timebooking')";
        if (!mysqli_query($conn, $sqlInsertHoaDon)) {
            // Xử lý lỗi khi thêm dữ liệu vào bảng hoadon
        }
        header('Location: index.php?page=camon'); // Chuyển hướng đến trang thành công
    }
} else {
    // Xử lý lỗi nếu dữ liệu không được gửi đến
}
?>