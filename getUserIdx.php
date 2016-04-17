<?php
/** Getting friends idx using nickname, email */

require_once("lib/session.php");
require_once("lib/dbconn.php");

$friendName = $_POST["friendName"];
$friendEmail = $_POST["friendEmail"];

$friendidx = getUserIdx($friendName, $friendEmail);
echo "$friendidx";