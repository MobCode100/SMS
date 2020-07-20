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

    $job_title = $con->query('SELECT * from JOB order by job_id asc', []);
    $jobposition[0] = $job_title[$jobposition[0]]['JOB_ID'];

    $validemail = validateEmail($email);
    $validphoneno = validatePhoneNo($phoneno);
    $validpass = checkPassword($pass);
    $salaryform = formatsalary($salary);
    $allowanceform = formatsalary($allowance);
    $hourlyform = formatsalary($hourlyrate);

    if ($jobposition[1] == '' || $jobposition[1] == null) {
        $_SESSION['t'] = 1;
        $_SESSION['message'] = 'Please Insert Your Job Position';
        echo "<script language='javascript'>window.location='register_employee.php';</script>";
    }
    if ($jobposition[1] != 'MANAGER' || $jobposition[1] != 'SUPERVISOR') {
        if ($emptype == null) {
            $_SESSION['t'] = 1;
            $_SESSION['message'] = 'Please Insert Your Employee Type';
            echo "<script language='javascript'>window.location='register_employee.php';</script>";
        }
    }
    if ($allowance == '' || $allowance == null) {
        $allowance = 0;
    }

    if ($validemail != '') {
        $compareemail = $con->query('SELECT EMAIL FROM EMPLOYEE', []);
        for ($c = 0; $c < count($compareemail); ++$c) {
            $compareemailvalid = validateEmail($compareemail[$c][0]);
            if ($email === $compareemail[$c][0] && ($compareemailvalid == true)) {
                $_SESSION['t'] = 1;
                $_SESSION['message'] = 'The Email Already Exist';
                echo "<script language='javascript'>window.location='register_employee.php';</script>";
            }
        }
        if ($validphoneno != '') {
            $comparephoneno = $con->query('SELECT PHONENO FROM EMPLOYEE', []);
            for ($t = 0; $t < count($comparephoneno); ++$t) {
                $comparephonenovalid = validatePhoneNo($comparephoneno[$t][0]) . '<br>';
                $convert = (int) $comparephonenovalid;
                $convert2 = (int) $validphoneno;
                if ($convert == $convert2) {
                    $_SESSION['t'] = 1;
                    $_SESSION['message'] = 'The Phone Number Already Exist';
                    echo "<script language='javascript'>window.location='register_employee.php';</script>";
                }
            }

            if ($validpass == true) {
                if ($salaryform == true) {
                    if ($jobposition[1] == 'MANAGER' || $jobposition[1] == 'SUPERVISOR') {
                        $con->query("INSERT INTO EMPLOYEE(NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID) VALUES (?,?,?,?,?,?,to_date(?,'fxYYYY-MM-DD'),?,null)", [$name, $email, $address, $phoneno, $pass, $salary, $hiredate, $jobposition[0]]);
                        $last_id = $con->query('SELECT EMP_AUTOINC.currval from dual', [])[0][0];

                        $con->query('INSERT INTO FULL_TIME (EMP_ID,ALLOWANCE) VALUES (?,?)', [$last_id, $allowance]);
                        $_SESSION['t'] = 0;
                        $_SESSION['message'] = 'Successfully Register';
                        echo "<script language='javascript'>window.location='register_employee.php';</script>";
                    } else {
                        if ($emptype == 'fullTime' && $allowanceform == true) {
                            $con->query("INSERT INTO EMPLOYEE(NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID) VALUES (?,?,?,?,?,?,to_date(?,'fxYYYY-MM-DD'),?,null)", [$name, $email, $address, $phoneno, $pass, $salary, $hiredate, $jobposition[0]]);
                            $last_id = $con->query('SELECT EMP_AUTOINC.currval from dual', [])[0][0];

                            $con->query('INSERT INTO FULL_TIME(EMP_ID,ALLOWANCE)VALUES (?,?)', [$last_id, $allowance]);
                            $_SESSION['t'] = 0;
                            $_SESSION['message'] = 'Successfully Register';
                            echo "<script language='javascript'>window.location='register_employee.php';</script>";
                        } else {
                            if ($emptype == 'fullTime' && ($allowanceform == null || $allowanceform == '')) {
                                $_SESSION['t'] = 1;
                                $_SESSION['message'] = 'Incorrect Allowance Input';
                                echo "<script language='javascript'>window.location='register_employee.php';</script>";
                            }
                        }
                        if ($emptype == 'partTime' && $hourlyform == true) {
                            $con->query("INSERT INTO EMPLOYEENAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID)VALUES (?,?,?,?,?,?,to_date(?,'fxYYYY-MM-DD'),?,null)", [$name, $email, $address, $phoneno, $pass, $salary, $hiredate, $jobposition[0]]);
                            $last_id = $con->query('SELECT EMP_AUTOINC.currval from dual', [])[0][0];
                            $con->query('INSERT INTO PART_TIME(EMP_ID,HOURLY_RATE)VALUES (?,?)', [$last_id, $hourlyrate]);
                            $_SESSION['t'] = 0;
                            $_SESSION['message'] = 'Successfully Register';
                            echo "<script language='javascript'>window.location='register_employee.php';</script>";
                        } else {
                            if ($emptype == 'partTime' && ($hourlyform == null || $hourlyform == '')) {
                                $_SESSION['t'] = 1;
                                $_SESSION['message'] = 'Incorrect Hourly Rate Input';
                                echo "<script language='javascript'>window.location='register_employee.php';</script>";
                            }
                        }
                    }
                } else {
                    $_SESSION['t'] = 1;
                    $_SESSION['message'] = 'Incorrect Salary Input';
                    echo "<script language='javascript'>window.location='register_employee.php';</script>";
                }
            } else {
                $_SESSION['t'] = 1;
                $_SESSION['message'] = $validpass;
                echo "<script language='javascript'>window.location='register_employee.php';</script>";
            }
        } else {
            $_SESSION['t'] = 1;
            $_SESSION['message'] = 'Incorrect Phone Number';
            echo "<script language='javascript'>window.location='register_employee.php';</script>";
        }
    } else {
        $_SESSION['t'] = 1;
        $_SESSION['message'] = 'Incorrect Email format';
        echo "<script language='javascript'>window.location='register_employee.php';</script>";
    }
} else {
    $_SESSION['t'] = 1;
    $_SESSION['message'] = 'Ungranted User Detected';
    echo "<script language='javascript'>window.location='index.php';</script>";
}
