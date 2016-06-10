<?php
/*
 * @ : Error control operator
 * http://php.net/manual/en/language.operators.errorcontrol.php
 * http://php.net/manual/kr/language.operators.errorcontrol.php
 *
 * isset(), empty(), is_null()
 * https://www.virendrachandak.com/techtalk/php-isset-vs-empty-vs-is_null/
 * isset — Determine if a variable is set and is not NULL
 * empty — Determine whether a variable is empty
 * is_null — Finds whether a variable is NULL
 *
 * header()
 * http://www.w3schools.com/php/func_http_header.asp
 *
 * */
/*
 * test@test.com / 1234
 * test2@test.com / test
 * test3@test.com / test
 * keapea@naver.com / test
 * secugyu@gmail.com / test
 */
session_start();
require_once("dbconn.php");

$myDomain = "219.240.6.172:50038";

$page = basename($_SERVER["REQUEST_URI"]);
$site = "";

if (isset($_SESSION["login"])) {
    if ($page == "logout.php") {
        session_destroy();
        header("Location:http://$myDomain$site/index.php", 301);

    } else if ($page == "getFriendList.php" || $page == "getUserList.php"
        || $page == "getFriendCount.php" || $page == "addFriend.php"
        || $page == "getMessage.php" || $page == "addMessage.php"
        || $page == "getUserIdx.php" || $page == "removeFriend.php"
        || $page == "app_dbconn.php") {
        /* Preventing redirection to main.php page
           when bringing data from database via php file */
        /* Very Dangerous!! Need to fix */

    } else if ($page != "main.php") {
        header("Location:http://$myDomain$site/main.php", 301);

    }
} else if ($_POST) {
    if ($page == "index.php") {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $_SESSION["invalidEmail"] = false;
            $_SESSION["invalidPassword"] = false;

            require_once("dbconn.php");
            $useridx = loginValidation($email, $password);
            $_SESSION["useridx"] = $useridx;
            if ($useridx > 0) {
                $_SESSION["email"] = $email;
                $_SESSION["login"] = true;

                header("Location:http://$myDomain$site/main.php", 301);
            } else if ($useridx == -1) {
                $_SESSION["invalidEmail"] = true;
                echo "<script> history.back() </script>";
            } else {
                $_SESSION["invalidPassword"] = true;
                echo "<script> history.back() </script>";
            }
        }
    } else if ($page == "register.php") {
        if (isset($_POST["email"]) && isset($_POST["nickname"])
            && isset($_POST["password"]) && isset($_POST["password2"])
            && isset($_POST["age"]) && isset($_POST["gender"])) {

            if (!($_POST["password"] == $_POST["password2"])) {
                echo "<script>";
                echo "alert('Check confirm password!');";
                echo "history.back();";
                echo "</script>";

            } else if (!is_numeric($_POST["age"])) {
                echo "<script>";
                echo "alert('Check your age!');";
                echo "history.back();";
                echo "</script>";

            } else {
                $email = $_POST["email"];
                $nickname = $_POST["nickname"];
                $password = $_POST["password"];
                $age = $_POST["age"];
                $gender = $_POST["gender"];

                $sql = "INSERT INTO users (email, password, nickname, age, gender)";
                $sql .= " VALUES ('$email', MD5('$password'), '$nickname', $age, '$gender');";

                require_once("lib/dbconn.php");
                if (saveRecords($sql)) {
                    header("Location:http://$myDomain$site/main.php", 301);
                }
            }
        }
    }
} else {
    if ($_SERVER["REQUEST_URI"] == "/") {
        $currentURI = $_SERVER["REQUEST_URI"];
        $targetURI = "Location:http://$myDomain";
        $targetURI .= $currentURI;
        $targetURI .= "index.php";
        header($targetURI, 301);
    } else if ($page != "index.php") {
        if ($page != "register.php")
            header("Location:http://$myDomain$site/index.php", 301);
    }
}
