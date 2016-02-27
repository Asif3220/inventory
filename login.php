<?php
session_start();

//Include database connection details
require_once('db.php');

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
   $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return $str;
}

//Sanitize the POST values
$username = clean($_POST['username']);
$password = clean($_POST['password']);

//If there are input validations, redirect back to the login form
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    header("location: index.php");
    exit();
}else{
	$_SESSION['ERRMSG_ARR'] = '';
}

//Create query
$selectUserSql = "SELECT * FROM user WHERE username='$username' AND password=:passwordmd5";
$selectUserSqlStatement = $myMySQLPDOCon->prepare($selectUserSql);
$selectUserSqlParameter = array("passwordmd5"=>md5($_POST['password']));
$selectUserSqlStatement->execute($selectUserSqlParameter);
$userRecords = array();
$userRecords = $selectUserSqlStatement->fetchAll();

if(count($userRecords)>0){
//Login Successful
    session_regenerate_id();
    $member = $userRecords[0];
    $_SESSION['SESS_MEMBER_ID'] = $member['id'];
    $_SESSION['SESS_FIRST_NAME'] = $member['username'];
    $_SESSION['SESS_LAST_NAME'] = $member['password'];
    session_write_close();
    header("location: dashboard.php");
    exit();
}else {
//Login failed
    $errmsg_arr[] = 'user name and password not found';
    $errflag = true;
    if ($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: index.php");
        exit();
    }
}
?>

