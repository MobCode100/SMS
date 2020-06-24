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
                echo "<script language='javascript'>window.location='change_password.php';alert('Password updated');</script>";
            } else {
                echo "<script language='javascript'>window.location='change_password.php';alert('New passwords do not match!');</script>";
            }
        } else {
            echo "<script language='javascript'>window.location='change_password.php';alert('". $validPassword . "');</script>";
        }
    } else {
        echo "<script language='javascript'>window.location='change_password.php';alert('Wrong current password!');</script>";
    }
}
