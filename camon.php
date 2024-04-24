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
                        <img src="img/gif/gif.gif" alt="gif">
                        <h2>CẢM ƠN BẠN ĐÃ THANH TOÁN</h2>
                        <p class="font-weight-bold">CẢM ƠN BẠN ĐÃ LUÔN TIN TƯỞNG VÀ ĐỒNG HÀNH CÙNG CHÚNG TÔI.</p>
                        <p id="countdown" class="font-italic ">

                        </p>

                        <br />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var seconds = 5; // số giây cần đếm ngược

            function countdown() {
                var countdownElement = document.getElementById('countdown');
                countdownElement.innerHTML = "Sẽ chuyển hướng sau " + seconds + " giây";
                seconds--;

                if (seconds >= 0) {
                    setTimeout(countdown, 1000); // đợi 1 giây trước khi giảm số giây đi 1 và gọi lại hàm countdown
                } else {
                    window.location.href = "http://localhost/anime/?page=home"; // chuyển hướng sau khi đếm ngược kết thúc
                }
            }

            countdown(); // bắt đầu đếm ngược khi trang web được tải
        });
    </script>

    <!-- Footer Section Begin -->
    <!-- Footer Section End -->

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