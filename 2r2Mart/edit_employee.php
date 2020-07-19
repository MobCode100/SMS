<?php

if (isset($_POST['submit'])) {
    session_start();
    include 'functions.php';
    require 'connection.php';

    function formatsalary($salarychange)
    {
        if (preg_match('/^\d|\d,\d+(\.(\d{2}))?$/', $salarychange)) {
            return true;
        }
    }

    $con = new Connection();

    $name = $_POST['empname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phoneno = $_POST['phoneNO'];
    $pass = $_POST['password'];
    $salary = $_POST['salary'];
    $hiredate = $_POST['hiredate'];
    $jobposition = json_decode($_POST['jobPosition']);
    $emptype = $_POST['employeeType'];
    $allowance = $_POST['allowance'];
    $hourlyrate = $_POST['hourlyrate'];
    $empid = $_POST['empid'];

    $job_title = $con->query('SELECT * from JOB order by job_id asc', []);
    $jobposition[0] = $job_title[$jobposition[0]]['JOB_ID'];

    $validemail = validateEmail($email);
    $validphoneno = validatePhoneNo($phoneno);
    $validpass = checkPassword($pass);
    $salaryform = formatsalary($salary);
    $allowanceform = formatsalary($allowance);
    $hourlyform = formatsalary($hourlyrate);

    $supervisorid = $con->query('SELECT SUPERVISOR_ID FROM EMPLOYEE WHERE EMP_ID=?', [$empid])[0][0];
    $currentemail = $con->query('SELECT EMAIL FROM EMPLOYEE WHERE EMP_ID=?', [$empid])[0][0];
    $currentphoneno = (int) validatePhoneNo($con->query('SELECT PHONENO FROM EMPLOYEE WHERE EMP_ID=?', [$empid])[0][0]);

    if ($jobposition[1] == '' || $jobposition[1] == null) {
        echo "<script language='javascript'>window.location='view_employee.php';alert('Please Insert Your Job Position ');</script>";
    }
    if ($jobposition[1] != 'MANAGER' || $jobposition[1] != 'SUPERVISOR') {
        if ($emptype == null) {
            echo "<script language='javascript'>window.location='view_employee.php';alert('Please Insert Your Employee Type ');</script>";
        }
    }
    if ($allowance == '' || $allowance == null) {
        $allowance = 0;
    }
    if ($validemail != '') {
        $compareemail = $con->query('SELECT EMAIL FROM EMPLOYEE', []);
        for ($c = 0; $c < count($compareemail); ++$c) {
            if ($email === $currentemail) {
                break;

                $compareemailvalid = validateEmail($compareemail[$c][0]);
                if ($email === $compareemail[$c][0] && ($compareemailvalid == true)) {
                    if ($compareemail[$c][0] != $currentemail) {
                        echo "<script language='javascript'>window.location='view_employee.php';alert('The Email Already Exist');</script>";
                        die();
                    }
                }
            }
        }
        if ($validphoneno != '') {
            $comparephoneno = $con->query('SELECT PHONENO FROM EMPLOYEE', []);
            for ($t = 0; $t < count($comparephoneno); ++$t) {
                if ((int) $validphoneno == $currentphoneno) {
                    break;
                }
                $comparephonenovalid = validatePhoneNo($comparephoneno[$t][0]).'<br>';
                $convert = (int) $comparephonenovalid;
                $convert2 = (int) $validphoneno;
                if ($convert == $convert2) {
                    if ($convert != $currentphoneno) {
                        echo "<script language='javascript'>window.location='view_employee.php';alert('The Phone Number Already Exist');</script>";
                        die();
                    }
                }
            }

            if ($validpass == true) {
                if ($salaryform == true) {
                    if ($jobposition[1] == 'MANAGER' || $jobposition[1] == 'SUPERVISOR') {
                        $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,PASSWORD=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=?,SUPERVISOR_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $pass, $salary, $hiredate, $jobposition[0], $supervisorid, $empid]);
                        $con->query('UPDATE FULL_TIME SET ALLOWANCE=? WHERE EMP_ID=?', [$allowance, $empid]);
                        echo "<script language='javascript'>window.location='view_employee.php';alert('Successfully Updated');</script>";
                    } else {
                        if ($emptype == 'fullTime' && $allowanceform == true) {
                            $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,PASSWORD=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=?,SUPERVISOR_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $pass, $salary, $hiredate, $jobposition[0], $supervisorid, $empid]);
                            $con->query('UPDATE FULL_TIME SET ALLOWANCE=? WHERE EMP_ID=?', [$allowance, $empid]);
                            echo "<script language='javascript'>window.location='view_employee.php';alert('Successfully Updated');</script>";
                        } else {
                            if ($emptype == 'fullTime' && ($allowanceform == null || $allowanceform == '')) {
                                echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Allowance Input');</script>";
                                die();
                            }
                        }
                        if ($emptype == 'partTime' && $hourlyform == true) {
                            $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,PASSWORD=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=?,SUPERVISOR_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $pass, $salary, $hiredate, $jobposition[0], $supervisorid, $empid]);
                            $con->query('UPDATE FULL_TIME SET HOURLY_RATE=? WHERE EMP_ID=?', [$hourlyrate, $empid]);
                            echo "<script language='javascript'>window.location='view_employee.php';alert('Successfully Updated');</script>";
                        } else {
                            if ($emptype == 'partTime' && ($hourlyform == null || $hourlyform == '')) {
                                echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Hourly Rate Input');</script>";
                                die();
                            }
                        }
                    }
                } else {
                    echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Salary Input');</script>";
                    die();
                }
            } else {
                echo "<script language='javascript'>window.location='view_employee.php';alert('$validpass');</script>";
                die();
            }
        } else {
            echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Phone Number');</script>";
            die();
        }
    } else {
        echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Email format');</script>";
        die();
    }
} else {
    echo "<script language='javascript'>window.location='index.php';alert('Ungranted User Detected');</script>";
    die();
}
