<?php
require_once("../lib/session.php");
require_once("../lib/dbconn.php");
header('Content-Type: html/text; charset=utf-8');

$callSign = $_POST['callSign'];
$JSONObject = $_POST['json'];

$trueCode = 1;
$falseCode = -1;
$wrongCode = -9;

/* JSON Parsing: http://terminaldogma.tistory.com/52 */
//$JSONObjectUTF8 = json_encode(utf8_encode($JSONObject));
$decodedJSON = json_decode($JSONObject);
switch ($callSign) {

    case "addUser":
        $email = $decodedJSON->email;
        $password = $decodedJSON->password;
        $nickname = $decodedJSON->nickname;
        $age = $decodedJSON->age;
        $gender = $decodedJSON->gender;

        echo "$JSONObject";
//        $resultCode = app_addUser($email, $password, $nickname, intval($age), $gender);
//        echo "$resultCode";

        break;
    case "loginValidation":
        $email = $decodedJSON->email;
        $password = $decodedJSON->password;
        
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
