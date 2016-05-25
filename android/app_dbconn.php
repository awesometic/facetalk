<?php
require_once("../lib/session.php");
require_once("../lib/dbconn.php");

$callSign = $_POST['callSign'];
$JSONObject = $_POST['json'];
$wrongCode = -9;

switch ($callSign) {

    case "loginValidation":
        echo "$JSONObject";
//        $useridx = app_loginValidation($email, $password);
//        echo "$useridx";
        break;

    default:
        break;
}

function app_loginValidation($email, $password) {

    $useridx = loginValidation($email, $password);

    return $useridx;
}