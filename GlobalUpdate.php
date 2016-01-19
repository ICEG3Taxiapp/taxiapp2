<?php
    include"header.php";
    if (isset($_POST['requestId'])) {
        $_SESSION['requestId'] = $_POST['requestId'];
    }
?>