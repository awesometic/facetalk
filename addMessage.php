<?php
/** Add messages to database */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$useridx = $_SESSION["useridx"];
$friendName = $_POST["friendName"];
$friendEmail = $_POST["friendEmail"];
$message = $_POST["message"];
// Incapacitate single quotation
// http://ra2kstar.tistory.com/67
$message = addslashes($message);

// SQL subquery references
// http://www.devpia.com/MAEUL/Contents/Detail.aspx?BoardID=38&MAEULNo=16&no=34150&ref=34148
$sql = "INSERT INTO messages (user, message, to_user) ";
$sql .= "SELECT $useridx, '$message', idx FROM users WHERE nickname='$friendName' AND email='$friendEmail'";

if (addMessage($sql)) {
    echo "true";
} else {
    echo "false";
}