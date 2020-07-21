<?php

function preload($job_id)
{
    if (isset($_SESSION['JOB_ID'])) {
        if ($job_id !== 'all') {
            if ($_SESSION['JOB_ID'] != $job_id) {
                header('Location: dashboard.php');
            }
        }
    } else {
        header('Location: index.php');
    }
}

function hidebar($job_id)
{
    if ($job_id !== 'all') {
        if ($_SESSION['JOB_ID'] != $job_id) {
            echo 'style="display: none"';
        }
    }
}

function currentbar($currentpage, $pages)
{
    foreach ($pages as $page) {
        if ($currentpage == $page) {
            echo 'active';
        }
    }
}

function checkPassword($password)
{
    if (strlen($password) > 7) {
        $words = preg_split('/\s+/', strtolower($_SESSION['NAME']));
        $valid = true;
        foreach ($words as $word) {
            echo strpos($password, $word).' ';

            if (strpos($password, $word) !== false) {
                $valid = false;
                break;
            }
        }

        return $valid ? true : 'Name found in new password!';
    } else {
        return 'Password must be longer than 7 characters!';
    }
}
function validatePhoneNo($phono)
{
    $valid = '';
    $countD = 0;
    $phono = preg_replace('/\s+|\+|-/', '', $phono);
    for (; $countD < strlen($phono); ++$countD) {
        $char = substr($phono, $countD, 1);
        if ($char != '6' || $countD != 0) {
            if (ctype_digit($char)) {
                $valid .= $char;
            }
        }
    }

    if ($countD > 12 || $countD < 9) {
        $valid = '';
    }

    return $valid;
}

function validateEmail($email)
{
    return preg_match_all('/^(([^\s"().,:;<>@\[\\\\\]])+(\.[^\s"().,:;<>@\[\\\\\]]+)*|(".+"))@(\[(([0-9]{1,2}|(25[0-5]|[0-2][0-4][0-9]))\.){3}([0-9]{1,2}|(25[0-4]|[0-2][0-4][0-9]))\]|([a-zA-Z\-0-9]+\.)+([a-zA-Z]{2,}))$/m', $email);
}

function clearMessage(){
    unset($_SESSION['t']);unset($_SESSION['message']);
}