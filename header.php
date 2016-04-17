<div id="header" class="text-right">
    <?php
    if (isset($_SESSION["login"]) && isset($_SESSION["email"])) {
        $email = $_SESSION["email"];
        $useridx = $_SESSION["useridx"];
        $sql = "SELECT nickname FROM users WHERE idx=$useridx";

        echo " <b>" . getNickname($sql) . "</b> (" . $email . ")";
        echo " | <a class='' href='logout.php'>Logout</a>";

/*    } else if (isset($_SESSION["login"]) && !isset($_SESSION["email"])) {
        echo "Something wrong...!!";*/

    } else {
        echo "Welcome! Register and enjoy!";

    }
    ?>
</div>