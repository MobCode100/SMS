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

if (isset($_POST['sBut'])) {
    require("Connection.php");
    $con = new Connection();
    $con->query("insert into transaction (emp_id,product_id,quantity,date_time) values(?,?,?,sysdate)",
    [$_SESSION['EMP_ID'],$_POST['product'],$_POST['quantity']]);
    $con->query("UPDATE PRODUCT set quantity = quantity + ? where product_id = ?",[$_POST['quantity'],$_POST['product']]);
    echo "<script language='javascript'>window.location='add_transaction.php';alert('Transaction entered successfully!');</script>";
}
