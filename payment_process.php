<?php
session_start();
include('db.php');
if(isset($_POST['amt']) && isset($_POST['name'])){
    $amt=$_POST['amt'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $payment_status="pending";
    $payment_mode=$_POST['payty'];
    date_default_timezone_set('Asia/Kolkata');
    $added_on=date('Y-m-d h:i:s A');
    mysqli_query($con,"insert into payment(name,email,amount,paymeny_mode,payment_status,added_on) values('$name','$email','$amt','$payment_mode','$payment_status','$added_on')");
    $_SESSION['OID']=mysqli_insert_id($con);
}


if(isset($_POST['payment_id']) && isset($_SESSION['OID'])){
    $payment_id=$_POST['payment_id'];
    mysqli_query($con,"update payment set payment_status='SUCCESS',payment_id='$payment_id' where id='".$_SESSION['OID']."'");
}
?>