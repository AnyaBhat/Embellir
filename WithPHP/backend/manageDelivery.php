<?php
    $orderid = $_POST['orderid'];
    $deliverydate = $_POST['deliverydate'];
    $deliverystatus = $_POST['deliverystatus'];

    include 'databaseConnect.php';


    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);


    $SELECT_ONE = "SELECT deliveryStatus from orderlist where orderid = ? limit 1";

    $stmt = $conn->prepare($SELECT_ONE);
    $stmt->bind_param("i",$orderid);
    $stmt->execute();
    $stmt->bind_result($TEMP_DELIVERY_STATUS);
    $stmt->store_result();
    $stmt->fetch();
    $rnum = $stmt->num_rows;
    if($rnum==0)
    {
        $stmt->close();
        require "failedDeliveryModify.html";
    }
    else
    {
        $conn->query("UPDATE orderlist SET deliveryStatus = '".($deliverystatus)."' , deliveryDate = '".($deliverydate)."' WHERE orderid = ".$orderid);
        sleep(1);
        require "successDeliveryModify.html";
    }
    $conn->close();

?>
