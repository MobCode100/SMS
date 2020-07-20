<?php
if (isset($_POST["submit"])) {
    session_start();
    include 'functions.php';

    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    require("Connection.php");
    $con = new Connection();

    $result = $con->query("SELECT PASSWORD from EMPLOYEE WHERE EMP_ID = ?", [$_SESSION['EMP_ID']]);

    if ($currentPassword === $result[0]["PASSWORD"]) {
        $validPassword = checkPassword($confirmPassword);
        if ($validPassword === true) {
            if ($newPassword === $confirmPassword) {
                $con->query("UPDATE EMPLOYEE SET PASSWORD = ? where EMP_ID = ?", [$newPassword, $_SESSION['EMP_ID']]);
                $_SESSION['t'] = 0;
                $_SESSION['message'] = 'Password updated';
                echo "<script language='javascript'>window.location='change_password.php';</script>";
            } else {
                $_SESSION['t'] = 1;
                $_SESSION['message'] = 'New password do not match!';
                echo "<script language='javascript'>window.location='change_password.php';</script>";
            }
        } else {
            $_SESSION['t'] = 1;
            $_SESSION['message'] = $validPassword;
            echo "<script language='javascript'>window.location='change_password.php';</script>";
        }
    } else {
        $_SESSION['t'] = 1;
        $_SESSION['message'] = 'Wrong current password!';
        echo "<script language='javascript'>window.location='change_password.php';</script>";
    }
}
