<?php
/*
 * http://www.w3schools.com/php/php_mysql_intro.asp
 */
// global keyword
// http://php.net/manual/en/language.variables.scope.php
// http://php.net/manual/kr/language.variables.scope.php

$host = "localhost";
$user = "root";
$pass = "awesometic";
$database = "face_talk";

$conn = mysqli_connect($host, $user, $pass, $database);
mysqli_query($conn, "SET NAMES 'utf8mb4'");
//if ($conn)
//    echo "Database Connected <br>";
//else
//    echo "Database NOT Connected <br>";

function saveRecords($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);

    if ($result)
        return true;
    else
        return false;
}

function loginValidation($email, $password) {
    global $conn;

    // Check whether input email is joined
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($result && (mysqli_num_rows($result) == 0)) {
        return -1;

    } else {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password=MD5('$password')");

        if ($result && (mysqli_num_rows($result) == 1)) {
            $recs = mysqli_fetch_assoc($result);
            $useridx = $recs["idx"];

            return $useridx;
        } else {
            return 0;
        }
    }
}

function getUserList($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);

    $users = array();
    if ($result) {
        while ($rec = mysqli_fetch_assoc($result)) {
            $users[] = $rec;
        }
    }

    return $users;
}

function getEmail($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $recs = mysqli_fetch_assoc($result);
        $email = $recs["email"];

        return $email;
    } else {
        return "error";
    }
}

function getNickname($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $recs = mysqli_fetch_assoc($result);
        $nickname = $recs["nickname"];

        return $nickname;
    } else {
        return "error";
    }
}

function getFriendCount($useridx)
{
    global $conn;

    $sql = "SELECT COUNT(*) cnt FROM friends WHERE user=$useridx OR friend=$useridx ";
    $sql .= "AND (user!=friend)";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $recs = mysqli_fetch_assoc($result);
        return $recs["cnt"];
    }
}

function checkFriendExist($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $recs = mysqli_fetch_assoc($result);

        if ($recs["cnt"] > 0)
            return false;
        else
            return true;
    }
}

function addFriend($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);
    if ($result)
        return true;
    else
        return false;
}

function getMessage($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);

    $messages = array();
    if ($result) {
        while ($rec = mysqli_fetch_assoc($result)) {
            $messages[] = $rec;
        }
    }

    return $messages;
}

function addMessage($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);
    if ($result)
        return true;
    else
        return false;
}

function getUserIdx($nickname, $email) {
    global $conn;
    
    $result = mysqli_query($conn, "SELECT idx FROM users WHERE nickname='$nickname' AND email='$email'");
    if ($result) {
        $recs = mysqli_fetch_assoc($result);
        $idx = $recs["idx"];

        return $idx;
    } else {
        return "error";
    }
}

function removeFriend($sql) {
    global $conn;

    $result = mysqli_query($conn, $sql);
    if ($result)
        return true;
    else
        return false;
}
