<?php
/* Prevent directory listing */
$page = basename($_SERVER["REQUEST_URI"]);
$site = dirname($_SERVER["REQUEST_URI"]);
header("Location:http://localhost$site/index.php", 301);
exit();