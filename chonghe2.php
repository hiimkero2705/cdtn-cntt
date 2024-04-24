<?php
if (!isset($_SESSION['loggedin_customer'])) {
    header('Location: ?page=login');
}

// Kiểm tra xem dữ liệu đã được gửi từ form chưa
if (isset($_POST['phim']) && isset($_POST['rap']) && isset($_POST['suatchieu'])) {
    // Lấy dữ liệu từ form
    $idphim = $_POST['phim'];
    $idrap = $_POST['rap'];
    $idSuatChieu = $_POST['suatchieu'];
    $idkh = $_SESSION['IDKH'];

    // Đoạn mã xử lý dữ liệu ở đây (nếu cần)

    // Kết nối đến cơ sở dữ liệu
    include 'assets/connect.php';

    $bookedSeats = array();
    // Thực hiện truy vấn SQL để lấy danh sách các ghế đã đặt
    $sql_ghebooked = "SELECT IDGhe FROM Ve WHERE IDPhim = '$idphim' AND IDRap = '$idrap' AND IDSuat = '$idSuatChieu'";
    $result_ghebooked = mysqli_query($conn, $sql_ghebooked);

    // Kiểm tra nếu có kết quả từ truy vấn
    if (mysqli_num_rows($result_ghebooked) > 0) {
        // Lặp qua các hàng kết quả và lưu IDGhe vào mảng $bookedSeats
        while ($row_ghebooked = mysqli_fetch_assoc($result_ghebooked)) {
            $bookedSeats[] = $row_ghebooked['IDGhe'];
        }
    }
    // Truy vấn cơ sở dữ liệu để lấy ID của phim dựa trên tên phim
    $sqlPhim = "SELECT * FROM phim WHERE IDPhim = '$idphim'";
    $resultPhim = mysqli_query($conn, $sqlPhim);


    if (mysqli_num_rows($resultPhim) > 0) {
        $rowPhim = mysqli_fetch_assoc($resultPhim);
        $tenPhim = $rowPhim['TenPhim'];

        // Truy vấn cơ sở dữ liệu để lấy ID của rạp dựa trên tên rạp
        $sqlRap = "SELECT * FROM rap WHERE IDRap = '$idrap'";
        $resultRap = mysqli_query($conn, $sqlRap);
        if (mysqli_num_rows($resultRap) > 0) {
            $rowRap = mysqli_fetch_assoc($resultRap);
            $tenRap = $rowRap['TenRap'];

            // Truy vấn cơ sở dữ liệu để lấy thông tin về suất chiếu
            $sqlSuatChieu = "SELECT GioChieu, NgayChieu FROM suatchieu WHERE IDSuat = '$idSuatChieu'";
            $resultSuatChieu = mysqli_query($conn, $sqlSuatChieu);
            if (mysqli_num_rows($resultSuatChieu) > 0) {
                $rowSuatChieu = mysqli_fetch_assoc($resultSuatChieu);
                $gioChieu = $rowSuatChieu['GioChieu'];
                $ngaychieu = $rowSuatChieu['NgayChieu'];

            } else {
                echo "Không tìm thấy thông tin suất chiếu";
            }
        } else {
            echo "Không tìm thấy rạp";
        }
    } else {
        echo "Không tìm thấy phim";
    }
}
?>


<!DOCTYPE html>
<html lang="zxx">


<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="img/normal-breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>CHỌN GHẾ</h2>
                        <p>ALL ROADS LEAD TO ME.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->
    <div class="info">
        <p class="info-item text-white">Phim: <?php echo $tenPhim ?></p>
        <p class="info-item text-white">Rạp: <?php echo $tenRap ?></p>
        <p class="info-item text-white">Suất: <?php echo $gioChieu ?> vào <?php echo $ngaychieu ?></p>
    </div>

    <div id="seatMap" class="seatMap">
        <!-- Sẽ được tạo bởi JavaScript -->
    </div>
    <script>
        // Mô phỏng dữ liệu về các ghế đã được đặt
        var bookedSeats = <?php echo json_encode($bookedSeats); ?>;

        // Tạo giao diện chọn ghế bằng JavaScript
        var seatMap = document.getElementById("seatMap");

        var seatPrice = 60000; // Giá của mỗi ghế
        var selectedSeatsCount = 0; // Số lượng ghế đã chọn
        // Thêm phần "Screen"
        var screen = document.createElement("div");
        screen.className = "screen ";
        screen.innerText = "MÀN HÌNH";
        seatMap.appendChild(screen);

        // Mảng chứa các chữ cái đại diện cho các hàng
        var rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        for (var i = 0; i < 8; i++) { // Số hàng
            var row = document.createElement("div");
            row.className = "row d-flex justify-content-center";
            for (var j = 1; j <= 9; j++) { // Số ghế trong mỗi hàng
                var seatNumber = rows[i] + j;
                var seat = document.createElement("div");
                seat.className = "seat";
                seat.innerText = seatNumber;
                seat.dataset.seatNumber = seatNumber;

                // Kiểm tra xem ghế có trong danh sách ghế đã đặt hay không
                if (bookedSeats.includes(seatNumber)) {
                    seat.classList.add("booked");
                    seat.disabled = true;
                } else {
                    seat.addEventListener("click", function () {
                        // Chuyển đổi trạng thái của ghế khi được chọn
                        this.classList.toggle("selected");
                        if (this.classList.contains("selected")) {
                            selectedSeatsCount++;
                        } else {
                            selectedSeatsCount--;
                        }
                        // Cập nhật tổng tiền dựa trên số lượng ghế đã chọn
                        updateTotalPrice(selectedSeatsCount);
                        updateSelectedSeats();
                    });
                }

                row.appendChild(seat);
            }
            seatMap.appendChild(row);
        }

        // Cập nhật danh sách ghế đã chọn
        function updateSelectedSeats() {
            var selectedSeats = document.querySelectorAll(".seat.selected");
            var selectedSeatsText = "";
            for (var i = 0; i < selectedSeats.length; i++) {
                selectedSeatsText += selectedSeats[i].dataset.seatNumber;
                if (i < selectedSeats.length - 1) {
                    selectedSeatsText += ", ";
                }
            }
            document.getElementById("selectedSeats").innerText = "Ghế đã chọn: " + selectedSeatsText;
        }
        function updateTotalPrice(selectedSeatsCount) {
            var totalPrice = selectedSeatsCount * seatPrice;
            var formattedTotalPrice = totalPrice.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
            document.getElementById("totalPrice").innerText = "Tổng tiền: " + formattedTotalPrice;
        }

    </script>

    <div>
        <p id="selectedSeats" class="ghedachon text-white container">Ghế đã chọn: </p>
        <div id="totalPrice" class="ghedachon text-white container">Tổng tiền: 0VND</div>
        <div class="payment-container container">
            <button id="paymentButton" class="btn btn-success">Thanh toán</button>
        </div>
    </div>

    <script>

        // document.getElementById("paymentButton").addEventListener("click", function () {
        //     var selectedSeats = document.querySelectorAll(".seat.selected");
        //     if (selectedSeats.length === 0) {
        //         alert("Vui lòng chọn ít nhất một ghế trước khi thanh toán.");
        //     } else {
        //         var seatNumbers = [];
        //         selectedSeats.forEach(function (seat) {
        //             seatNumbers.push(seat.dataset.seatNumber);
        //         });
        //         var formData = new FormData();
        //         formData.append('phim', '<?php echo $idphim; ?>');
        //         formData.append('rap', '<?php echo $idrap; ?>');
        //         formData.append('suatchieu', '<?php echo $idSuatChieu; ?>');
        //         formData.append('idkh', '<?php echo $idkh; ?>');
        //         formData.append('ghes', seatNumbers.join(','));

        //         var xhr = new XMLHttpRequest();
        //         xhr.open("POST", "thanhtoan.php", true);
        //         xhr.onload = function () {
        //             if (xhr.status === 200) {
        //                 // alert("Đã thanh toán thành công!");
        //                 location.reload();
        //             } else {
        //                 alert("Đã xảy ra lỗi khi thanh toán. Vui lòng thử lại sau.");
        //             }
        //         };
        //         xhr.send(formData);
        //     }
        // });

        document.getElementById("paymentButton").addEventListener("click", function () {
            var selectedSeats = document.querySelectorAll(".seat.selected");
            if (selectedSeats.length === 0) {
                alert("Vui lòng chọn ít nhất một ghế trước khi thanh toán.");
            } else {
                var seatNumbers = [];
                selectedSeats.forEach(function (seat) {
                    seatNumbers.push(seat.dataset.seatNumber);
                });

                // Tạo form và cập nhật giá trị vào các trường input của form
                var paymentForm = document.createElement('form');
                paymentForm.method = 'post';
                paymentForm.action = '?page=chitietthanhtoan';

                var idphimField = document.createElement('input');
                idphimField.type = 'hidden';
                idphimField.name = 'idphim';
                idphimField.value = '<?php echo $idphim; ?>';
                paymentForm.appendChild(idphimField);

                var idrapField = document.createElement('input');
                idrapField.type = 'hidden';
                idrapField.name = 'idrap';
                idrapField.value = '<?php echo $idrap; ?>';
                paymentForm.appendChild(idrapField);

                var idSuatchieuField = document.createElement('input');
                idSuatchieuField.type = 'hidden';
                idSuatchieuField.name = 'idSuatchieu';
                idSuatchieuField.value = '<?php echo $idSuatChieu; ?>';
                paymentForm.appendChild(idSuatchieuField);

                var idgheField = document.createElement('input');
                idgheField.type = 'hidden';
                idgheField.name = 'idghe';
                idgheField.value = seatNumbers.join(',');
                paymentForm.appendChild(idgheField);

                var tongtienField = document.createElement('input');
                tongtienField.type = 'hidden';
                tongtienField.name = 'tongtien';
                tongtienField.value = selectedSeats.length * 60000; // Tính tổng tiền
                paymentForm.appendChild(tongtienField);

                document.body.appendChild(paymentForm);
                paymentForm.submit();
            }
        });
    </script>
</body>
<style>
    .ghedachon {
        font-weight: bold;
        font-size: 20px;
    }

    .seatMap {
        padding: 10px;
    }

    .payment-container {
        /* Căn giữa nút thanh toán */
        margin-top: 20px;
        margin-bottom: 20px;
        /* Để tạo khoảng cách giữa nút thanh toán và phần trên */
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: 10%;
        font-weight: bold;
        background-color: #ffffff;
        border: 1px solid #999;
        margin: 5px;
        display: inline-block;
        cursor: pointer;
    }

    .seat:hover {
        background-color: #fb835b;
    }

    .selected {
        background-color: #7efa2c;
    }

    .booked {
        background-color: #999;
        cursor: not-allowed;
    }

    .screen {
        width: 30%;
        height: 50px;
        background-color: #000;
        color: #fff;
        font-size: 20px;
        font-weight: 900;
        text-align: center;
        line-height: 50px;
        margin: 0 auto;
        margin-bottom: 5px;
        /* Căn giữa */
    }

    @media (max-width: 768px) {
        .screen {
            width: 100%;
            /* Full width */
        }
    }

    .row {
        text-align: center;
    }

    .info {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    .info-wrapper {
        text-align: center;
    }

    .info-item {
        margin: 0 10px;
        font-size: 20px;
        font-weight: bold;
        /* Khoảng cách giữa các phần tử */
    }
</style>

</html>