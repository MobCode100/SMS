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
    $jobposition = $_POST['jobPosition'];
    $emptype = $_POST['employeeType'];
    $allowance = $_POST['allowance'];
    $hourlyrate = $_POST['hourlyrate'];

    $validemail = validateEmail($email);
    $validphoneno = validatePhoneNo($phoneno);
    $validpass = checkPassword($pass);
    $salaryform = formatsalary($salary);
    $allowanceform = formatsalary($allowance);
    $hourlyform = formatsalary($hourlyrate);

    if ($jobposition == ' ') {
        echo "<script language='javascript'>window.location='register_employee.php';alert('Please Insert Your Job Position ');</script>";
    }
    if ($jobposition != 'manager') {
        if ($emptype == ' ') {
            echo "<script language='javascript'>window.location='register_employee.php';alert('Please Insert Your Employee Type ');</script>";
        }
    }
    if ($validemail != '') {
        if ($validphoneno != '') {
            if ($validpass == true) {
                if ($salaryform == true) {
                    if ($jobposition == 'manager') {
                        $con->query("INSERT INTO EMPLOYEE
                         (NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID)
                         VALUES ('$name','$email','$address','$phoneno','$pass','$salary',DATE '$hiredate',1,null)", []);
                        echo "<script language='javascript'>window.location='register_employee.php';alert('Successfully Register');</script>";
                    } else {
                        if ($emptype == 'fullTime' && $allowanceform == true) {
                            $con->query("INSERT INTO EMPLOYEE
                             (NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID)
                             VALUES ('$name','$email','$address','$phoneno','$pass','$salary',DATE '$hiredate',2,null)", []);
                            $last_id = $con->query('SELECT EMP_AUTOINC.currval from dual', []);
                            $last_id2 = $last_id[0][0];
                            $con->query("INSERT INTO FULL_TIME
                             (EMP_ID,ALLOWANCE)
                             VALUES ('$last_id2','$allowance')", []);
                            echo "<script language='javascript'>window.location='register_employee.php';alert('Successfully Register');</script>";
                        } else {
                            if ($emptype == 'fullTime' && ($allowanceform == null || $allowanceform == '')) {
                                echo "<script language='javascript'>window.location='register_employee.php';alert('Incorrect Allowance Input');</script>";
                            }
                        }
                        if ($emptype == 'partTime' && $hourlyform == true) {
                            $con->query("INSERT INTO EMPLOYEE
                             (NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID)
                             VALUES ('$name','$email','$address','$phoneno','$pass','$salary',DATE '$hiredate',2,null)", []);
                            $last_id = $con->query('SELECT EMP_AUTOINC.currval from dual', []);
                            $last_id2 = $last_id[0][0];
                            $con->query("INSERT INTO PART_TIME
                             (EMP_ID,HOURLY_RATE)
                             VALUES ('$last_id2','$hourlyrate')", []);
                            echo "<script language='javascript'>window.location='register_employee.php';alert('Successfully Register');</script>";
                        } else {
                            if ($emptype == 'partTime' && ($hourlyform == null || $hourlyform == '')) {
                                echo "<script language='javascript'>window.location='register_employee.php';alert('Incorrect Hourly Rate Input');</script>";
                            }
                        }
                    }
                } else {
                    echo "<script language='javascript'>window.location='register_employee.php';alert('Incorrect Salary Input');</script>";
                }
            } else {
                echo "<script language='javascript'>window.location='register_employee.php';alert('$validpass');</script>";
            }
        } else {
            echo "<script language='javascript'>window.location='register_employee.php';alert('Incorrect Phone Number');</script>";
        }
    } else {
        echo "<script language='javascript'>window.location='register_employee.php';alert('Incorrect Email format');</script>";
    }
} else {
    echo "<script language='javascript'>window.location='index.php';alert('Ungranted User Detected');</script>";
}
