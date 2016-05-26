<?php
require_once("../lib/session.php");
require_once("../lib/dbconn.php");
header('content-type: html/text; charset=utf-8');

$JSONObject = $_POST['json'];

$trueCode = 1;
$falseCode = -1;
$wrongCode = -9;

/* JSON Parsing: http://terminaldogma.tistory.com/52 */
$decodedJSON = json_decode($JSONObject);
$callSign = $decodedJSON->callSign;
switch ($callSign) {

    case "addUser":
        $email = $decodedJSON->email;
        $password = $decodedJSON->password;
        $nickname = $decodedJSON->nickname;
        $age = $decodedJSON->age;
        $gender = $decodedJSON->gender;

        $resultCode = app_addUser($email, $password, $nickname, intval($age), $gender);
        echo "$resultCode";

        break;
    case "loginValidation":
        $email = $decodedJSON->email;
        $password = $decodedJSON->password;

        $useridx = app_loginValidation($email, $password);
        echo "$useridx";

        break;
    case "getNickname":
        $useridx = $decodedJSON->useridx;
        
        $nickname = app_getNickname($useridx);
        echo "$nickname";
        
        break;
    case "getFriend":
        $useridx = $decodedJSON->useridx;

        $friends = app_getFriend($useridx);
        echo "$friends";

        break;
    case "getFriendCount":
        $useridx = $decodedJSON->useridx;

        $count = app_getFriendCount($useridx);
        echo "$count";

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

function app_getNickname($useridx) {
    $sql = "SELECT nickname FROM users WHERE idx=$useridx";
    $nickname = getNickname($sql);

    return $nickname;
}

function app_getFriend($useridx) {
    $sql = "SELECT idx, email, nickname, age, gender FROM users ";
    $sql .= "WHERE (idx IN SELECT friend FROM friends WHERE user=$useridx) ";
    $sql .= "OR idx IN (SELECT user FROM friends WHERE friend=$useridx)) ";
    $sql .= "ORDER BY nickname";
    $friends = getUserList($sql);

    return $friends;
}

function app_getFriendCount($useridx) {
    $count = getFriendCount($useridx);

    return $count;
}