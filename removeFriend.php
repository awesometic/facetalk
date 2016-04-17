<?php
/** Remove friends query */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$useridx = $_SESSION["useridx"];
$friendidx = $_POST["friendidx"];

$sql = "SELECT nickname FROM users WHERE idx=$friendidx";
$nickname = getNickname($sql);

$sql = "DELETE FROM friends WHERE (user=$friendidx AND friend=$useridx) ";
$sql .= "OR (user=$useridx AND friend=$friendidx)";
removeFriend($sql);
$sql = "DELETE FROM messages WHERE (user=$friendidx AND to_user=$useridx) ";
$sql .= "OR (user=$useridx AND to_user=$friendidx)";
removeFriend($sql);

echo "Friend Removed! <b>" . $nickname . "</b>";
