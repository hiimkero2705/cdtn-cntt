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
    <style>
        #seatMap {
            text-align: center;
            margin: 0 auto;
        }
        .seat {
            width: 40px;
            height: 40px;
            background-color: #ccc;
            border: 1px solid #999;
            margin: 5px;
            display: inline-block;
            cursor: pointer;
        }

        .selected {
            background-color: #ff0000;
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
            text-align: center;
            line-height: 50px;
            margin: 0 auto;
            /* Căn giữa */
        }

        .row {
            text-align: center;
        }
    </style>
    </head>

    <body>
        <h2>Chọn Ghế</h2>
        <div id="seatMap">
            <!-- Sẽ được tạo bởi JavaScript -->
        </div>
        <script>
            // Mô phỏng dữ liệu về các ghế đã được đặt
            var bookedSeats = []; // Giả sử các ghế 3, 5, 8 đã được đặt

            // Tạo giao diện chọn ghế bằng JavaScript
            var seatMap = document.getElementById("seatMap");

            // Thêm phần "Screen"
            var screen = document.createElement("div");
            screen.className = "screen";
            screen.innerText = "Screen";
            seatMap.appendChild(screen);

            for (var i = 1; i <= 8; i++) { // Số hàng
                var row = document.createElement("div");
                row.className = "row";
                for (var j = 1; j <= 9; j++) { // Số ghế trong mỗi hàng
                    var seatNumber = (i - 1) * 9 + j;
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
                        });
                    }

                    row.appendChild(seat);
                }
                seatMap.appendChild(row);
            }
        </script>
        <!-- Search model Begin -->
        <div class="search-model">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <div class="search-close-switch"><i class="icon_close"></i></div>
                <form class="search-model-form">
                    <input type="text" id="search-input" placeholder="Search here.....">
                </form>
            </div>
        </div>

    </body>

</html>