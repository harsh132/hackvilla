<?php

$p='http://localhost/HACKCOVID';

$salt1='abc';
$salt2='xyz';

$headers = "From: admin@hakvilla.000webhostapp.com";

session_start();

require_once "conn.php";

function msg()
{
    if(isset($_SESSION['msg']))
    {
        echo $_SESSION['msg'].'<br>';
        unset($_SESSION['msg']);
    }
}

function execSQL($a,$b)
{
    foreach($b as $c)
    $c=htmlentities($c);
    $stmt = $GLOBALS['conn']->prepare($a);
    $stmt->execute($b);
    return $stmt;
}

function login($a,$e,$p)
{
    $stmt=execSQL("SELECT id,name,status FROM ".$a." WHERE email=? AND password=?",array(htmlentities($e),hash('md5',$GLOBALS['salt1'].htmlentities($p).$GLOBALS['salt2'])));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
        if($row['status']==0)
            {
                $_SESSION['msg']='<div class="alert alert-primary alert-dismissible fade show">Please verify your email before login.</div><br>';
                header('location: login.php');
                exit(0);
            }
        $_SESSION['type'] = $a;
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        return true;
    }
    else
    {
        $error= <<<_END
            <div class="alert alert-danger alert-dismissible fade show">Invalid login credentials !</div><br>
        _END;
        return $error;
    }
}

function loginadmin($a,$e,$p)
{
    $stmt=execSQL("SELECT id,name FROM ".$a." WHERE email=? AND password=?",array(htmlentities($e),hash('md5',$GLOBALS['salt1'].htmlentities($p).$GLOBALS['salt2'])));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
        $_SESSION['type'] = $a;
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        return true;
    }
    else
    {
        $error= <<<_END
            <div class="alert alert-danger alert-dismissible fade show">Invalid login credentials !</div><br>
        _END;
        return $error;
    }
}

function checklogin($a)
{
    if(isset($_SESSION['type']) && isset($_SESSION['user_id']) && $_SESSION['type']==$a)
    return true;
    else{
        header('location:login.php');
        exit(0);
    }
}

function sendmail($email,$sub,$msg)
{
    $headers = "From: admin@hakvilla.000webhostapp.com";
    mail($email,$sub,$msg,$headers);
}


?>