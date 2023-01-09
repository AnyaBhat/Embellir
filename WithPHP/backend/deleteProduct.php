<?php

    $productid = $_POST["productid"];

    include 'databaseConnect.php';

    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
    die('Connection Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
    $conn -> query("DELETE from product where productid = ".$productid);
    sleep(2);
    // header("Location: http://localhost/Embellir/ui/ui/dbms-Embellir/With%20PHP/adminProductManage.php");
    header("Location: ../adminProductManage.php");
    exit();
    } 
    $conn->close();
    
?>


