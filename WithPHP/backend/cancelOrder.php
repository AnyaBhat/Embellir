<?php
include 'databaseConnect.php';

    //create connection
   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
   if (mysqli_connect_error()) 
   {
      die('Connection Error('. mysqli_connect_errno().')'. mysqli_connect_error());
   }

   $email=$_POST['email']; 
   $delID=$_POST['cancelOrderID']; 
   $delStatus="Order Canceled";
   $delStatus2="Requested Cancellation";

   $status1=$conn->query("select deliveryStatus from orderlist where orderid=".$delID);
   $status=mysqli_fetch_array($status1);

   if($status[0]==$delStatus){
      require "orderCancelFailed.html";


   }
   else{



$returnTOStock=$conn->query("select product.productid,cart.quantity from product,cart where cart.productid=product.productid and cart.orderid=".$delID);

while($row = mysqli_fetch_array($returnTOStock))
      {
         $prodid = $row[0];
         $prodqty = $row[1];
         $conn->query("UPDATE product SET productStock = productStock + ".$prodqty." WHERE productid = ".$prodid);
      }
      


$result=mysqli_query($conn,"update orderlist set deliveryStatus='".$delStatus2."' where orderid =".$delID);

sleep(1);

require "orderCancelSuccess.html";
}



?>
