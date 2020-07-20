<?php
if (isset($_POST['login'])) {
  require("Connection.php");
  $con = new Connection();
  $email = trim($_POST['u_email']);
  $pass = $_POST['u_pass'];
  $result = $con->query("SELECT * FROM EMPLOYEE WHERE EMAIL = ? AND PASSWORD = ? ", [$email, $pass]);
  session_start();
  if ($result != null) {
    $_SESSION['JOB_ID'] = $result[0]['JOB_ID'];
    $_SESSION['EMP_ID'] = $result[0]['EMP_ID'];
    $_SESSION['NAME'] = $result[0]['NAME'];

    echo "<script Language = 'javascript'>
               window.location='dashboard.php';</script>";
  } else {
    $_SESSION['t'] = 1;
    $_SESSION['message'] = 'Incorrect password or email';
    echo "<script Language = 'javascript'>
           window.location='index.php';</script>";
  }
}
