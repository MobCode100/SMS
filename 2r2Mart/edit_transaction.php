<?php 
require 'functions.php'; // Satu file yang simpan macam2 functions kita
session_start();
/*
  Function preload ni akan restrict user daripada access page
  Since kita ada 2 jenis user sahaja, values accepted:
  'all' maksudnya semua users/jobs boleh access page ni
  1 maksudnya job_id = 1 = MANAGER sahaja yang boleh access
*/
preload('all');
if(isset($_POST['sBut'])){
    require("Connection.php");
    $con = new Connection();
    if($_POST['product'] == $_POST['old_product']){
        $current_stock = $con->query("SELECT quantity from product where product_id = ?",[$_POST['product']]);
        $difference = $_POST['old_quantity'] - $_POST['quantity'];
        
        if( $difference > 0){
            $con->query("UPDATE PRODUCT set quantity = quantity - ? where product_id = ?",[$difference,$_POST['product']]);
            $con->query("UPDATE TRANSACTION set quantity = quantity - ? where transaction_id = ?",[$difference,$_POST['tid']]);
        } else if ($difference < 0){
            $con->query("UPDATE PRODUCT set quantity = quantity - ? where product_id = ?",[$difference,$_POST['product']]);
            $con->query("UPDATE TRANSACTION set quantity = quantity - ? where transaction_id = ?",[$difference,$_POST['tid']]);
        }
    } else {
        $con->query("UPDATE PRODUCT set quantity = quantity - ? where product_id = ?",[$_POST['old_quantity'],$_POST['old_product']]);
        $con->query("UPDATE TRANSACTION set quantity = ?,product_id = ? where transaction_id = ?",[$_POST['quantity'],$_POST['product'],$_POST['tid']]);
        $con->query("UPDATE PRODUCT set quantity = quantity + ? where product_id = ?",[$_POST['quantity'],$_POST['product']]);
    }
    echo "<script language='javascript'>window.location='view_transaction.php';alert('Transaction edited successfully!');</script>";
}
?>