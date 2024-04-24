<?php
include 'assets/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phimid = $_POST['phim'];
    // $khuvucid = $_POST['khuvuc'];
    $khuvucid = isset($_POST['khuvuc']) ? $_POST['khuvuc'] : null;
    $khuvuc_condition = "";
    if ($khuvucid !== null) {
        $khuvuc_condition = "AND IDKhuVuc = '$khuvucid'";
    }

    $sql_rap = "SELECT DISTINCT rap.IDRap, rap.TenRap 
            FROM suatchieu 
            JOIN rap ON suatchieu.IDRap = rap.IDRap
            WHERE IDPhim = '$phimid' $khuvuc_condition";
            
    $result_rap = $conn->query($sql_rap);
   
    if ($result_rap->num_rows > 0) {
        $optionrap = "";
        while ($row_rap = mysqli_fetch_assoc($result_rap)) {
            $optionrap .= "<option value='" . $row_rap['IDRap'] . "'>" . $row_rap['TenRap'] .  "</option>";
        }
        echo $optionrap;
    } else {
        
    }
}
?>
