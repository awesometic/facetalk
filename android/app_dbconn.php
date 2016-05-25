<?php
require_once("../lib/session.php");
require_once("../lib/dbconn.php");

$callSign = $_POST['callSign'];
$JSONObject = $_POST['json'];

$trueCode = 1;
$falseCode = -1;
$wrongCode = -9;

switch ($callSign) {

    case "addUser":
        $email = $JSONObject["email"];
        $password = $JSONObject["password"];
        $nickname = $JSONObject["nickname"];
        $age = $JSONObject["age"];
        $gender = $JSONObject["gender"];
        $resultCode = app_addUser($email, $password, $nickname, intval($age), $gender);

        echo "$resultCode";

        break;
    case "loginValidation":
        $email = $JSONObject["email"];
        $password = $JSONObject["password"];
        
        $useridx = app_loginValidation($email, $password);
        echo "$useridx";

        break;
    default:
        break;
}

function app_addUser($email, $password, $nickname, $age, $gender) {
    global $trueCode;
    global $falseCode;

    $sql = "INSERT INTO users (email, password, nickname, age, gender)";
    $sql .= " VALUES ('$email', MD5('$password'), '$nickname', $age, '$gender');";

    if (saveRecords($sql))
        return $trueCode;
    else
        return $falseCode;
}

function app_loginValidation($email, $password) {

    $useridx = loginValidation($email, $password);

    return $useridx;
}