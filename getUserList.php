<?php
/** Return all users in the database except friends */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$useridx = $_SESSION["useridx"];

$searchKeyword = "";
if (isset($_POST["search"]))
    $searchKeyword = $_POST["search"];

$sql = "SELECT idx, email, nickname, age, gender FROM users ";
$sql .= "WHERE idx!=$useridx ";
$sql .= "AND (idx NOT IN (SELECT user FROM friends WHERE friend=$useridx) ";
$sql .= "AND idx NOT IN (SELECT friend FROM friends WHERE user=$useridx)) ";
$sql .= "AND (email LIKE '%$searchKeyword%' OR nickname LIKE '%$searchKeyword%') ORDER BY nickname";

$resultJSON = json_encode(getUserList($sql));

echo "$resultJSON";