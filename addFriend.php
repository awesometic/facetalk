<?php
/** Add friend query */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$useridx = $_SESSION["useridx"];
$friendidx = $_POST["friendidx"];

$sql = "SELECT nickname FROM users WHERE idx=$friendidx";
$nickname = getNickname($sql);

$sql = "SELECT COUNT(*) cnt FROM friends WHERE ( user=$useridx AND friend=$friendidx )";
$sql .= " OR ( user=$friendidx AND friend=$useridx )";

if (checkFriendExist($sql)) {
    $sql = "INSERT INTO friends (user, friend) VALUES ($useridx, $friendidx)";

    addFriend($sql);

    echo "Friend Added! <b>" . $nickname . "</b>";
    exit;
}