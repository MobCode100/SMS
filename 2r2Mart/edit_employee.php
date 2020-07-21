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
        echo "<script language='javascript'>window.location='view_employee.php';alert('Please Insert Your Job Position ');</script>";
        exit;
    }
    if ($jobposition[1] != 'MANAGER' || $jobposition[1] != 'SUPERVISOR') {
        if ($emptype == null) {
            echo "<script language='javascript'>window.location='view_employee.php';alert('Please Insert Your Employee Type ');</script>";
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
                            echo "<script language='Javascript'>window.location = 'view_employee.php';alert('The Email Already Exist');</script>";
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
                                echo "<script language='javascript'>window.location='view_employee.php';alert('The Phone Number Already Exist');</script>";
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
                            echo "<script language='javascript'>window.location='view_employee.php';alert('Successfully Updated');</script>";
                            exit;
                        } else {
                            if ($emptype == 'fullTime' && $allowanceform == true) {
                                $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $salary, $hiredate, $jobposition[0], $empid]);
                                $con->query('UPDATE FULL_TIME SET ALLOWANCE=? WHERE EMP_ID=?', [$allowance, $empid]);
                                echo "<script language='javascript'>window.location='view_employee.php';alert('Successfully Updated');</script>";
                                exit;
                            } else {
                                if ($emptype == 'fullTime' && ($allowanceform == null || $allowanceform == '')) {
                                    echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Allowance Input');</script>";
                                    exit;
                                }
                            }
                            if ($emptype == 'partTime' && $hourlyform == true) {
                                $con->query("UPDATE EMPLOYEE SET NAME=?,EMAIL=?,ADDRESS=?,PHONENO=?,SALARY=?,HIRE_DATE=to_date(?,'fxYYYY-MM-DD'),JOB_ID=? WHERE EMP_ID=?", [$name, $email, $address, $phoneno, $salary, $hiredate, $jobposition[0], $empid]);
                                $con->query('UPDATE PART_TIME SET HOURLY_RATE=? WHERE EMP_ID=?', [$hourlyrate, $empid]);
                                echo "<script language='javascript'>window.location='view_employee.php';alert('Successfully Updated');</script>";
                                exit;
                            } else {
                                if ($emptype == 'partTime' && ($hourlyform == null || $hourlyform == '')) {
                                    echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Hourly Rate Input');</script>";
                                    exit;
                                }
                            }
                        }
                    } else {
                        echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Salary Input');</script>";
                        exit;
                    }
                } else {
                    echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Phone Number');</script>";
                    exit;
                }
            } else {
                echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Email format');</script>";
                exit;
            }
        } else {
            echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Name format');</script>";
            exit;
        }
    } else {
        echo "<script language='javascript'>window.location='view_employee.php';alert('Incorrect Address format');</script>";
        exit;
    }
} else {
    echo "<script language='javascript'>window.location='index.php';alert('Ungranted User Detected');</script>";
    exit;
}
