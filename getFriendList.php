<?php
/** Return friends */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$useridx = $_SESSION["useridx"];

$searchKeyword = "";
if (isset($_POST["search"]))
    $searchKeyword = $_POST["search"];

$sql = "SELECT idx, email, nickname, age, gender FROM users ";
$sql .= "WHERE (idx IN (SELECT friend FROM friends WHERE user=$useridx) ";
$sql .= "OR idx IN (SELECT user FROM friends WHERE friend=$useridx))";
$sql .= "AND (email LIKE '%$searchKeyword%' OR nickname LIKE '%$searchKeyword%') ORDER BY nickname";

$resultJSON = json_encode(getUserList($sql));

echo "$resultJSON";

/*
$sql = "SELECT friend FROM friends WHERE user=$useridx";
$friendsOne = getUserList($sql);

$sql = "SELECT user FROM friends WHERE friend=$useridx";
$friendsTwo = getUserList($sql);

$friendsidx = array();

foreach ($friendsOne as $friend) {
    array_push($friendsidx, $friend["friend"]);
}

foreach ($friendsTwo as $friend) {
    array_push($friendsidx, $friend["user"]);
}

for ($i = 0; $i < count($friendsidx); $i++) {
    $friendidx = $friendsidx[$i];

    $sql = "SELECT email FROM users WHERE idx=$friendidx";
    $friendEmail = getEmail($sql);
    
    $sql = "SELECT nickname FROM users WHERE idx=$friendidx";
    $friendNickname = getNickname($sql);
    
    echo "<a href='#' class='list-group-item' title='$friendidx, $friendEmail'>";
    echo "$friendNickname";
    echo "</a>";
}
*/
