<?php
function preload($job_id)
{
    if (isset($_SESSION['JOB_ID'])) {
        if ($job_id !== 'all') {
            if ($_SESSION['JOB_ID'] != $job_id) {
                header("Location: dashboard.php");
            }
        }
    } else {
        header("Location: index.php");
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
    foreach ($pages as $page){
        if ($currentpage == $page) {
            echo 'active';
        }
    }
}

function checkPassword($password){
    if(strlen($password) > 7){
        $words = preg_split('/\s+/',strtolower($_SESSION['NAME']));
        $valid = true;
        foreach ($words as $word){
            echo strpos($password,$word)." " ;
            
            if(strpos($password,$word) !== false){
                $valid = false;
                break;
            } 
        }   
        return $valid ? true : "Name found in new password!" ;
    } else {
        return "Password must be longer than 7 characters!";
    }
}