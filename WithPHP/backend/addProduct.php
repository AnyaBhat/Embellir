<?php


$productid = $_POST['productid'];
$productName = $_POST['productName'];
$productPrice = $_POST['productPrice'];
$productStock = $_POST['productStock'];
$productDescription = $_POST['productDescription'];
$productCap = $_POST['productCap'];
$productPhoto = $_POST['productPhoto'];

include 'databaseConnect.php';




    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
    die('Connection Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
    $SELECT = "SELECT productid from product where productid = ? limit 1";
    $INSERT = "INSERT into product (productid, productName, productPrice, productStock, productDescription, productCap, productPhoto) values(?, ?, ?, ?, ?, ?, ?)";
     //Prepare statement
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("i",$productid);
    $stmt->execute();
    $stmt->bind_result($productid);
    $stmt->store_result();
    $stmt->fetch();
    $rnum = $stmt->num_rows;
    if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("isiisis", $productid, $productName, $productPrice, $productStock, $productDescription, $productCap, $productPhoto);
      $stmt->execute();
    //   echo "New product inserted sucessfully";
        // header("Location: http://localhost/Embellir/ui/ui/dbms-Embellir/With%20PHP/adminProductManage.php");
        header("Location: ../adminProductManage.php");
      //include '../adminProductManage.php';
        exit();
    } else {
      include 'an1.html';
    }
    $stmt->close();
    $conn->close();
    }


?>
