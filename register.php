<?php require_once("lib/session.php"); ?>
<!doctype html>
<html>
<head>
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
    <div id="content" >
        <div class="panel panel-primary">
            <div align="center" class="panel-heading">
                <h1>Registration</h1>
            </div>
            <div class="panel-body">
                <form class="form-horizontal myform" role="form" method="POST" >
                    <div class="form-group">
                        <label class="control-label col-md-4"> Email</label>
                        <div class="col-md-4">
                            <input name="email" type="email" class="form-control" placeholder="Enter email" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4"> Nickname</label>
                        <div class="col-md-4">
                            <input name="nickname" type="text" class="form-control" placeholder="Enter nickname" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="pwd"> Password</label>
                        <div class="col-md-4">
                            <input name="password" type="password" class="form-control" id="pwd" placeholder="Enter password" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="pwd"> Re-type Password</label>
                        <div class="col-md-4">
                            <input name="password2" type="password" class="form-control" id="pwd" placeholder="Confirm password" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4"> Age</label>
                        <div class="col-md-4">
                            <input name="age" type="text" class="form-control" placeholder="Enter your age" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="gender"> Gender</label>
                        <div class="col-md-4">
                            <select name ="gender" class="form-control" id="gender">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-right">
                            &nbsp;
                        </div>
                        <div class="col-md-4 text-right">
                            <input class="btn btn-primary btn-block" type="submit" value="Register"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-right">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            Already Registered? <br/>
                            <a href="index.php">Login Now</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once("footer.php"); ?>
</div>
</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/myjs.js"></script>
</html>