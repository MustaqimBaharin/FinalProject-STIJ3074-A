<?php
error_reporting(0);
include_once("dbconnect.php");
$userid = $_GET['userid'];
$mobile = $_GET['mobile'];
$amount = $_GET['amount'];

$data = array(
    'id' =>  $_GET['billplz']['id'],
    'paid_at' => $_GET['billplz']['paid_at'] ,
    'paid' => $_GET['billplz']['paid'],
    'x_signature' => $_GET['billplz']['x_signature']
);

$paidstatus = $_GET['billplz']['paid'];

if ($paidstatus=="true"){
  $receiptid = $_GET['billplz']['id'];
  $signing = '';
    foreach ($data as $key => $value) {
        $signing.= 'billplz'.$key . $value;
        if ($key === 'paid') {
            break;
        } else {
            $signing .= '|';
        }
    }
        
    $signed= hash_hmac('sha256', $signing, 'S-9--4DGcbV0FqERNN7ibIQA');
    if ($signed === $data['x_signature']) {
        

    }
    
    $sqlinsertpurchased = "INSERT INTO tbl_purchased(orderid,email,paid,status) VALUES('$receiptid','$userid', '$amount','paid')";
    $sqldeletecart = "DELETE FROM tbl_carts WHERE email='$userid'";

    if ($conn->exec($sqlinsertpurchased) && $conn->exec($sqldeletecart)) {
        echo "<script>alert('Payment Completed')</script>";
        echo "<script>window.location.replace('cart.php')</script>";
    }

    echo '<br><br><body><div><h2><br><br><center>Your Receipt</center>';
    echo '<table border=1 width=80% align=center>';
   echo '<tr><td>Receipt ID</td><td>'.$receiptid.'</td></tr><tr><td>Email to </td>';
    echo '<td>'.$userid. ' </td></tr><td>Amount </td><td>RM '.$amount.'</td></tr>';
    echo '<tr><td>Payment Status </td><td>'.$paidstatus.'</td></tr>';
    echo '<tr><td>Date </td><td>'.date("d/m/Y").'</td></tr>';
    echo '<tr><td>Time </td><td>'.date("h:i a").'</td></tr>';
    echo '</table><br>';
    echo '<p><center>Click Return button to return Fatimah Nasi Kandar</center></p></div></body>';
    echo '<a href="menu.php"><p><center>Return</center></p> </a>';
}
else{
     echo 'Payment Failed!';
}
