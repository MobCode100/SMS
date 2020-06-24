<?php
if (isset($_POST['login'])) {
  require("Connection.php");
  $con = new Connection();
  $email = trim($_POST['u_email']);
  $pass = $_POST['u_pass'];
  $result = $con->query("SELECT * FROM EMPLOYEE WHERE EMAIL = ? AND PASSWORD = ? ", [$email, $pass]);

  if ($result != null) {
    session_start();
    $_SESSION['JOB_ID'] = $result[0]['JOB_ID'];
    $_SESSION['EMP_ID'] = $result[0]['EMP_ID'];
    $_SESSION['NAME'] = $result[0]['NAME'];

    echo "<script Language = 'javascript'>
               window.location='dashboard.php';</script>";
  } else {
    echo "<script Language = 'javascript'>
          alert ('Invalid username/password!' ) ;
           window.location='login.php';</script>";;
  }
}
