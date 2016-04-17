<?php
/** Display messages at main.php. It is loaded by jquery */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$useridx = $_SESSION["useridx"];
$friendidx = $_POST["friendidx"];

$sql = "SELECT message, user FROM messages ";
$sql .= "WHERE (user=$useridx AND to_user=$friendidx) OR (user=$friendidx AND to_user=$useridx)";
$resultJSON = json_encode(getMessage($sql));

echo "$resultJSON";