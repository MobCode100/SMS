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

if (isset($_POST['delete'])) {
    require("Connection.php");
    $con = new Connection();
    $data = $con->query("SELECT * FROM TRANSACTION WHERE transaction_id = ?", [$_POST['id']]);
    if ($data != null) {
        $con->query(
            "delete from transaction where transaction_id = ?",
            [$_POST['id']]
        );
        $con->query("UPDATE PRODUCT set quantity = quantity - ? where product_id = ?", [$data[0]['QUANTITY'], $data[0]['PRODUCT_ID']]);
    }

    echo "<script language='javascript'>window.location='view_transaction.php';alert('Transaction deleted successfully!');</script>";
}
