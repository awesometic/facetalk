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
        <div class="container-fluid">
            <div class="row">
                <div id="wenchuk" class="col-md-4 panel panel-primary">
                    <div id="wenchuk-heading" align="center" class="panel-heading">
                        <div id="friend-count"><!-- getFriendCount.php running by jquery --></div>
                    </div>
                    <div id="wenchuk-body" class="panel-body pre-scrollable">
                        <div id="friend-list" class="list-group">
                            <!-- getFriendList.php running by jquery -->
                        </div>
                    </div>
                    <div id="wenchuk-footer" align="center" class="panel-footer">
                        <div class="btn-group">
                            <button id="friend-add" class="btn btn-primary glyphicon glyphicon-plus"></button>
                            <div class="modal fade" id="friend-add-modal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="panel-primary">
                                            <div class="panel-heading">
                                                <h3>
                                                    Search Friends<br>
                                                    <small id="search-friend-head-small" style="color: white">
                                                        <!-- Text by jquery -->
                                                    </small>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <!-- To avoid modal dismiss on enter keypress
                                                http://stackoverflow.com/questions/10400149/avoid-modal-dismiss-on-enter-keypress
                                                -->
                                                <form method="post" role="form" onsubmit="return false;">
                                                    <div id="search" class="form-group">
                                                        <input type="text" class="form-control" id="search-input" name="friend" placeholder="Enter user name or email">
                                                    </div>
                                                </form>
                                                <div id="searched-friends" class="pre-scrollable">
                                                    <!-- getUserList.php running by jquery -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><small><span class="glyphicon glyphicon-remove"></span></small> Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button id="friend-remove" class="btn btn-primary glyphicon glyphicon-minus"></button>
                            <div class="modal fade" id="friend-remove-modal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="panel-danger">
                                            <div class="panel-heading">
                                                <h3>
                                                    Removing Friend<br>
                                                    <small id="remove-search-friend-head-small" style="color: red">
                                                        <!-- Text by jquery -->
                                                    </small>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <!-- To avoid modal dismiss on enter keypress
                                                http://stackoverflow.com/questions/10400149/avoid-modal-dismiss-on-enter-keypress
                                                -->
                                                <form method="post" role="form" onsubmit="return false;">
                                                    <div id="remove-search" class="form-group">
                                                        <input type="text" class="form-control" id="remove-search-input" name="friend" placeholder="Enter user name or email">
                                                    </div>
                                                </form>
                                                <div id="remove-searched-friends" class="pre-scrollable">
                                                    <!-- getUserList.php running by jquery -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><small><span class="glyphicon glyphicon-remove"></span></small> Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--                            <button id="friend-email" class="btn btn-primary glyphicon glyphicon-envelope"></button>-->
                        </div>
                    </div>
                </div>
                <div id="oronchuk" class="col-md-8 panel panel-primary">
                    <div id="oronchuk-heading" align="center" class="panel-heading">
                        <div id="friend-name">
                            <h3><small style="color: white">Click your friend to send a message</small></h3>
                            <!-- Shows friend's name using jquery -->
                        </div>
                    </div>
                    <div id="oronchuk-body" class="panel-body pre-scrollable">
                        <div id="messageArea">
                            <!-- Display messages via jquery -->
                        </div>
                    </div>
                    <div id="oronchuk-footer" class="panel-footer">
                        <input id="send-message-input" type="text" class="form-control" name="sendtext"/>
                    </div>
                </div>
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