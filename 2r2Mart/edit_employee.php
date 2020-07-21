<?php

if (isset($_POST['submit'])) {
    session_start();
    include 'functions.php';
    require 'connection.php';

    function formatsalary($validformat, $salary)
    {
        if ($validformat) {
            return number_format($salary, 2, '.', '');
        }
    }

    $con = new Connection();

    $name = strip_tags($_POST['empname']);
    $email = $_POST['email'];
    $address = strip_tags($_POST['address']);
    $phoneno = $_POST['phoneNO'];
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
    $salaryform = is_numeric($salary);
    $allowanceform = is_numeric($allowance);
    $hourlyform = is_numeric($hourlyrate);

    $salary = formatsalary($salaryform, $salary);
    $allowance = formatsalary($allowanceform, $allowance);
    $hourlyrate = formatsalary($hourlyform, $hourlyrate);

    $supervisorid = $con->query('SELECT SUPERVISOR_ID FROM EMPLOYEE WHERE EMP_ID=?', [$empid])[0][0];
    $currentemail = $con->query('SELECT EMAIL FROM EMPLOYEE WHERE EMP_ID=?', [$empid])[0][0];
    $currentphoneno = (int) validatePhoneNo($con->query('SELECT PHONENO FROM EMPLOYEE WHERE EMP_ID=?', [$empid])[0][0]);

    if ($jobposition[1] == '' || $jobposition[1] == null) {
        $_SESSION['t'] = 1;
        $_SESSION['message'] = 'Please Insert Your Job Position';
        echo "<script language='javascript'>window.location='view_employee.php';</script>";
        exit;
    }
    if ($jobposition[1] != 'MANAGER' || $jobposition[1] != 'SUPERVISOR') {
        if ($emptype == null) {
            $_SESSION['t'] = 1;
            $_SESSION['message'] = 'Please Insert Your Employee Type';
            echo "<script language='javascript'>window.location='view_employee.php';</script>";
            exit;
        }
    }
    if ($allowance == '' || $allowance == null) {
        $allowance = 0;
    }

    if ($address != null) {
        if ($name != null) {
            if ($validemail != '') {
                $compareemail = $con->query('SELECT EMAIL FROM EMPLOYEE', []);
                for ($c = 0; $c < count($compareemail); ++$c) {
                    $compareemailvalid = validateEmail($compareemail[$c][0]);
                    if ($currentemail == $email) {
                        break;
                    }
                    $compareemail[$c][0];
                    if ($email == $compareemail[$c][0] && $compareemailvalid == true) {
                        if ($compareemail[$c][0] != $currentemail) {
                            $_SESSION['t'] = 1;
                            $_SESSION['message'] = 'The Email Already Exist';
                            echo "<script language='Javascript'>window.location = 'view_employee.php';</script>";
                            exit;
                        }
                    }
                }
                if ($validphoneno != '') {
                    $comparephoneno = $con->query('SELECT PHONENO FROM EMPLOYEE', []);
                    for ($t = 0; $t < count($comparephoneno); ++$t) {
                        if ((int) $validphoneno == $currentphoneno) {
                            break;
                        }
                        $comparephonenovalid = validatePhoneNo($comparephoneno[$t][0]);
                        $convert = (int) $comparephonenovalid;
                        $convert2 = (int) $validphoneno;
                        if ($convert == $convert2) {
                            if ($convert != $currentphoneno) {
                                $_SESSION['t'] = 1;
                                $_SESSION['message'] = 'The Phone Number Already Exist';
                                echo "<script language='javascript'>window.location='view_employee.php';</script>";
                                exit;
                            }
                        }
                    }

                    $pastTime1 = $con->query('select * from full_time where emp_id = ?', [$empid]); //fulltime
                    $pastTime2 = $con->query('select * from part_time where emp_id = ?', [$empid]); //parttime
                    if ($pastTime1 != null && $emptype == 'partTime') {
                        $con->query('delete from FULL_TIME WHERE EMP_ID=?', [$empid]);
                        $con->query('INSERT INTO PART_TIME(EMP_ID,HOURLY_RATE)VALUES (?,?)', [$empid, $hourlyrate]);
                    } elseif ($pastTime2 != null && $emptype == 'fullTime') {
                        $con->query('delete from PART_TIME WHERE EMP_ID=?', [$empid]);
                        $con->query('INSERT INTO FULL_TIME(EMP_ID,ALLOWANCE)VALUES (?,?)', [$empid, $allowance]);
                    }
                    if ($salaryform == true) {
                        if ($jobposition[1] == 'MANAGER' || $jobposition[1] == 'SUPERVISOR') {
                            $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $salary, $hiredate, $jobposition[0], $empid]);
                            $con->query('UPDATE FULL_TIME SET ALLOWANCE=? WHERE EMP_ID=?', [$allowance, $empid]);
                            $_SESSION['t'] = 0;
                            $_SESSION['message'] = 'Successfully Updated';
                            echo "<script language='javascript'>window.location='view_employee.php';</script>";
                            exit;
                        } else {
                            if ($emptype == 'fullTime' && $allowanceform == true) {
                                $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $salary, $hiredate, $jobposition[0], $empid]);
                                $con->query('UPDATE FULL_TIME SET ALLOWANCE=? WHERE EMP_ID=?', [$allowance, $empid]);
                                $_SESSION['t'] = 0;
                                $_SESSION['message'] = 'Successfully Updated';
                                echo "<script language='javascript'>window.location='view_employee.php';</script>";
                                exit;
                            } else {
                                if ($emptype == 'fullTime' && ($allowanceform == null || $allowanceform == '')) {
                                    $_SESSION['t'] = 1;
                                    $_SESSION['message'] = 'Incorrect Allowance Input';
                                    echo "<script language='javascript'>window.location='view_employee.php';</script>";
                                    exit;
                                }
                            }
                            if ($emptype == 'partTime' && $hourlyform == true) {
                                $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $salary, $hiredate, $jobposition[0], $empid]);
                                $con->query('UPDATE PART_TIME SET HOURLY_RATE=? WHERE EMP_ID=?', [$hourlyrate, $empid]);
                                $_SESSION['t'] = 0;
                                $_SESSION['message'] = 'Successfully Updated';
                                echo "<script language='javascript'>window.location='view_employee.php';</script>";
                                exit;
                            } else {
                                if ($emptype == 'partTime' && ($hourlyform == null || $hourlyform == '')) {
                                    $_SESSION['t'] = 1;
                                    $_SESSION['message'] = 'Incorrect Hourly Rate Input';
                                    echo "<script language='javascript'>window.location='view_employee.php';</script>";
                                    exit;
                                }
                            }
                        }
                    } else {
                        $_SESSION['t'] = 1;
                        $_SESSION['message'] = 'Incorrect Salary Input';
                        echo "<script language='javascript'>window.location='view_employee.php';</script>";
                        exit;
                    }
                } else {
                    $_SESSION['t'] = 1;
                    $_SESSION['message'] = 'Incorrect Phone Number';
                    echo "<script language='javascript'>window.location='view_employee.php';</script>";
                    exit;
                }
            } else {
                $_SESSION['t'] = 1;
                $_SESSION['message'] = 'Incorrect Email format';
                echo "<script language='javascript'>window.location='view_employee.php';</script>";
                exit;
            }
        } else {
            $_SESSION['t'] = 1;
            $_SESSION['message'] = 'Incorrect Name format';
            echo "<script language='javascript'>window.location='view_employee.php';</script>";
            exit;
        }
    } else {
        $_SESSION['t'] = 1;
        $_SESSION['message'] = 'Incorrect Address format';
        echo "<script language='javascript'>window.location='view_employee.php';</script>";
        exit;
    }
} else {
    $_SESSION['t'] = 1;
    $_SESSION['message'] = 'Ungranted User Detected';
    echo "<script language='javascript'>window.location='index.php';</script>";
    exit;
}
