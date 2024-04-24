<?php
include 'assets/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rapid = $_POST['rap'];

    $sql_suatchieu = "SELECT * FROM suatchieu WHERE IDRap = '$rapid'";

    $result_suatchieu = $conn->query($sql_suatchieu);
   
    if ($result_suatchieu->num_rows > 0) {
        $optionsuatchieu = "";
        while ($row_suatchieu = mysqli_fetch_assoc($result_suatchieu)) {
            $optionsuatchieu .= "<option value='" . $row_suatchieu['IDSuat'] . "'>" . $row_suatchieu['GioChieu'] . " " . $row_suatchieu['NgayChieu'] . "</option>";
        }
        echo $optionsuatchieu;
    } else {
       
    }
}
?>
