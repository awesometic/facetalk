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
    case "addFriends":
        $useridx = $decodedJSON->useridx;
        $friendsCount = $decodedJSON->friendsCount;
        for ($i = 0; $i < $friendsCount; $i++) {
            $selectFriend = select . $i;
            app_addFriend($useridx, $decodedJSON->$selectFriend);
        }

        echo "$trueCode";
       
        break;
    case "removeFriends":
        $useridx = $decodedJSON->useridx;
        $friendsCount = $decodedJSON->friendsCount;
        for ($i = 0; $i < $friendsCount; $i++) {
            $selectFriend = select . $i;
            app_removeFriend($useridx, $decodedJSON->$selectFriend);
        }

        echo "$trueCode";

        break;
    case "loginValidation":
        $email = $decodedJSON->email;
        $password = $decodedJSON->password;

        $useridx = app_loginValidation($email, $password);
        echo "$useridx";

        break;
    case "getMessage":
        $useridx = $decodedJSON->useridx;
        $friendidx = $decodedJSON->friendidx;

        $message = app_getMessage($useridx, $friendidx);
        echo "$message";

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
    case "getAllFriends":
        $useridx = $decodedJSON->useridx;
        
        $friends = app_getAllFriends($useridx);
        echo "$friends";        
      
        break;
    case "getSearchedFriends_add":
        $useridx = $decodedJSON->useridx;
        $searchKeyword = $decodedJSON->searchKeyword;
        
        $friends = app_getSearchedFriends_add($useridx, $searchKeyword);
        echo "$friends";        

        break;
    case "getSearchedFriends_remove":
        $useridx = $decodedJSON->useridx;
        $searchKeyword = $decodedJSON->searchKeyword;

        $friends = app_getSearchedFriends_remove($useridx, $searchKeyword);
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

function app_addFriend($useridx, $friendidx) {
    $sql = "INSERT INTO friends (user, friend) VALUES ($useridx, $friendidx)";

    addFriend($sql);
}

function app_removeFriend($useridx, $friendidx) {
    $sql = "DELETE FROM friends WHERE (user=$friendidx AND friend=$useridx) ";
    $sql .= "OR (user=$useridx AND friend=$friendidx)";
    removeFriend($sql);
    $sql = "DELETE FROM messages WHERE (user=$friendidx AND to_user=$useridx) ";
    $sql .= "OR (user=$useridx AND to_user=$friendidx)";
    removeFriend($sql);
}

function app_loginValidation($email, $password) {
    $useridx = loginValidation($email, $password);

    return $useridx;
}

function app_getMessage($useridx, $friendidx) {
    $sql = "SELECT message, user FROM messages ";
    $sql .= "WHERE (user=$useridx AND to_user=$friendidx) OR (user=$friendidx AND to_user=$useridx)";
    $message = json_encode(getMessage($sql));

    return $message; 
}

function app_getNickname($useridx) {
    global $wrongCode;

    if ($useridx == $wrongCode)
        $nickname = "error";
    else {
        $sql = "SELECT nickname FROM users WHERE idx=$useridx";
        $nickname = getNickname($sql);
    }

    return $nickname;
}

function app_getFriend($useridx) {
    $sql = "SELECT idx, email, nickname, age, gender FROM users ";
    $sql .= "WHERE (idx IN (SELECT friend FROM friends WHERE user=$useridx) ";
    $sql .= "OR idx IN (SELECT user FROM friends WHERE friend=$useridx)) ";
    $sql .= "ORDER BY nickname";
    $friends = json_encode(getUserList($sql));
    
    return $friends;
}

function app_getAllFriends($useridx) {
    $sql = "SELECT idx, email, nickname, age, gender FROM users ";
    $sql .= "WHERE idx!=$useridx ";
    $sql .= "AND (idx NOT IN (SELECT user FROM friends WHERE friend=$useridx) ";
    $sql .= "AND idx NOT IN (SELECT friend FROM friends WHERE user=$useridx))";
    $friends = json_encode(getUserList($sql));

    return $friends;
}

function app_getSearchedFriends_add($useridx, $searchKeyword) {
    $sql = "SELECT idx, email, nickname, age, gender FROM users ";
    $sql .= "WHERE idx!=$useridx ";
    $sql .= "AND (idx NOT IN (SELECT user FROM friends WHERE friend=$useridx) ";
    $sql .= "AND idx NOT IN (SELECT friend FROM friends WHERE user=$useridx)) ";
    $sql .= "AND (email LIKE '%$searchKeyword%' OR nickname LIKE '%$searchKeyword%') ORDER BY nickname";
    $friends = json_encode(getUserList($sql));

    return $friends;
}

function app_getSearchedFriends_remove($useridx, $searchKeyword) {
    $sql = "SELECT idx, email, nickname, age, gender FROM users ";
    $sql .= "WHERE (idx IN (SELECT friend FROM friends WHERE user=$useridx) ";
    $sql .= "OR idx IN (SELECT user FROM friends WHERE friend=$useridx))";
    $sql .= "AND (email LIKE '%$searchKeyword%' OR nickname LIKE '%$searchKeyword%') ORDER BY nickname";
    $friends = json_encode(getUserList($sql));

    return $friends;
}

function app_getFriendCount($useridx) {
    $count = getFriendCount($useridx);

    return $count;
}
