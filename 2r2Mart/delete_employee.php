<?php
require 'functions.php'; // Satu file yang simpan macam2 functions kita
session_start();
/* 
  Function preload ni akan restrict user daripada access page
  Since kita ada 2 jenis user sahaja, values accepted:
  'all' maksudnya semua users/jobs boleh access page ni
  1 maksudnya job_id = 1 = MANAGER sahaja yang boleh access
*/
preload(1);
$logged_in = $_SESSION['EMP_ID']; // employee id yang login
require("Connection.php");
$con = new Connection();
if (isset($_POST['fulltime']) && isset($_POST['row'])) {
    $emp_list = $con->query("select e.emp_id from employee e join full_time f on e.emp_id = f.emp_id where e.emp_id != ? order by e.emp_id asc", [$logged_in]);
    if ($emp_list != null) {
        $emp_id = $_POST['row'] - 1;
        $con->query("delete from employee where emp_id = ?", [$emp_list[$emp_id]['EMP_ID']]);
        echo "<script>window.location='view_employee.php';alert ('Deleted successfully!') ;</script>";
    }
} else if (isset($_POST['parttime'])) {
    $emp_list = $con->query("select e.emp_id from employee e join part_time p on e.emp_id = p.emp_id where e.emp_id != ? order by e.emp_id asc", [$logged_in]);
    if ($emp_list != null) {
        $emp_id = $_POST['row'] - 1;
        $con->query("delete from employee where emp_id = ?", [$emp_list[$emp_id]['EMP_ID']]);
        echo "<script>window.location='view_employee.php';alert ('Deleted successfully!') ;</script>";
    }
}
