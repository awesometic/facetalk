<?php

require_once("lib/session.php");
require_once("lib/dbconn.php");
$count = getFriendCount($_SESSION["useridx"]);

echo "<h3>";
echo "Friend (";
echo "$count";
echo ")";
echo "</h3>";