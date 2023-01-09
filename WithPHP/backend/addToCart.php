<?php

    $productid = $_POST['productid'];
    $productQty = $_POST['productQty'];
    $personEmail = $_POST['personEmail'];
    $productStock = $_POST['productStock'];

    // $productid = 1;
    // $productQty = 1;
    // $personEmail = 'test1@gmail.com';
    // $productStock = 400;

    include 'databaseConnect.php';


    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    // Decrease Stock
    $conn->query("UPDATE product SET productStock = ".($productStock-$productQty)." WHERE productid = ".$productid);

    $myCost = $conn->query("SELECT productprice from product where productid=".$productid);
    $oneCost = mysqli_fetch_array($myCost);
    $personidTEMP = $conn->query("SELECT personid from persons where email='".$personEmail."'");
    $personid = mysqli_fetch_array($personidTEMP);

    $costPrice = $oneCost[0]*$productQty;

    $tempResultTEMP = $conn->query("SELECT * from cart where personid=".$personid[0]." and productid=".$productid." and orderid = 0");
    $tempResult = mysqli_fetch_array($tempResultTEMP);
    sleep(1);

    if(is_array($tempResult))
    {
        $alreadyQtyTEMP = $conn->query("SELECT quantity,cost from cart where personid=".$personid[0]." and productid=".$productid." and orderid = 0");
        $alreadyQty = mysqli_fetch_array($alreadyQtyTEMP);
        sleep(1);
        $conn->query("UPDATE cart SET quantity = ".($alreadyQty[0]+$productQty).",cost = ".($alreadyQty[1]+$costPrice)." WHERE personid=".$personid[0]." and productid=".$productid." and orderid = 0" );
    }
    else
    {
        $conn->query("INSERT into cart values (".$personid[0].",".$productid.",".$productQty.",".$costPrice.",'NULL')");
    }


    
    sleep(1);
    header("Location: ../customerProductView.php");
    exit();
    $conn->close();

// IGNORE
    // if (mysqli_connect_error()) {
    // die('Connection Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    // } else {
    // $oneCost = $conn->query("SELECT productprice from product where productid=".$productid);
    // sleep(1);
    // $personid = $conn->query("SELECT personid from persons where email=".$personEmail);
    // sleep(1);
    // // $conn->query("INSERT into cart values (".$personid.",".$productid.",".$productQty.",".(int)$productQty*(int)$oneCost['productprice'].")");
    // sleep(1);
    // // header("Location: http://localhost/Embellir/ui/ui/dbms-Embellir/With%20PHP/adminProductManage.php");
    // header("Location: http://localhost/Embellir-v2/With%20PHP/customerProductView.php");
    // exit();
    // } 
    // $conn->close();


?>
