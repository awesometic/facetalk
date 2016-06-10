<?php require_once("lib/session.php"); ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
          type="text/css"
          href="bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet"
          type="text/css"
          href="mycss.css"/>
</head>
<body>
<div id="main">
    <?php require_once("header.php"); ?>
    <div id="content" class="panel panel-primary">
        <div align="center" class="panel-heading">
            <h1>Welcome to Face Talk</h1>
            <h4>
                <?php
                if (isset($_SESSION["invalidEmail"]) && ($_SESSION["invalidEmail"] == true)) {
                    echo "Check your email";

                } else if (isset($_SESSION["invalidPassword"]) && ($_SESSION["invalidPassword"] == true)) {
                    echo "Check your password";

                } else {
                    echo "It's not Facebook";

                }
                ?>
            </h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal myform" role="form" method="POST" >
                <div class="form-group">
                    <label class="control-label col-md-4"> Email</label>
                    <div class="col-md-4">
                        <input name="email" type="email" class="form-control" placeholder="Enter email" required autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4" for="pwd"> Password</label>
                    <div class="col-md-4">
                        <input name="password" type="password" class="form-control" id="pwd" placeholder="Enter password" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        &nbsp;
                    </div>
                    <div class="col-md-4 text-right">
                        <input class="btn btn-primary btn-block" type="submit" value="Login"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 text-right">
                        &nbsp;
                    </div>
                    <div class="col-md-4">
                        Not a user?
                        <a href="register.php">Sign-up</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</div>
</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/myjs.js"></script>
</html>
