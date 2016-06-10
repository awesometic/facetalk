// http://www.w3schools.com/bootstrap/bootstrap_ref_js_modal.asp
$(document).ready(function() {

    var add_getUserList = function() {
        $.post("getUserList.php", { search: "" })
            .done(function(data) {
                data = $.parseJSON(data);

                var list = "<ul class='list-group'>";
                $.each(data, function(index, value) {
                    list += "<li class='list-group-item'>" + value.email + ", " + value.nickname + "</li>";
                });
                list += "</ul>";

                $("#searched-friends").html(list);
                $("#search-friend-head-small").html("Type your friend's <strong>name</strong> or <strong>email</strong>!<strong>");
            });
    };

    var remove_getFriendList = function() {
        $.post("getFriendList.php", { search: "" })
            .done(function(data) {
                data = $.parseJSON(data);

                var list = "<ul class='list-group'>";
                $.each(data, function (index, value) {
                    list += "<li class='list-group-item'>" + value.email + ", " + value.nickname + "</li>";
                });
                list += "</ul>";

                $("#remove-searched-friends").html(list);
                $("#remove-search-friend-head-small").html("Type your friend's <strong>name</strong> or <strong>email</strong>!<strong>");
            });
    };

    var loadFriendListAndCount = function() {
        $("#friend-count").load("getFriendCount.php");
        $("#friend-list").load("getFriendList.php", function (data) {
            data = $.parseJSON(data);

            var list = "";
            $.each(data, function (index, value) {
                list += "<a href='#' class='list-group-item' title='" + value.idx + ", " + value.email + "'>";
                list += value.nickname;
                list += "</a>";
            });

            $("#friend-list").html(list);
        });
    };

    var getMessage = function(friendidx) {
        $("#messageArea").load("getMessage.php", {friendidx: friendidx}, function (data) {
            data = $.parseJSON(data);

            var list = "<ul class='list-group'>";
            $.each(data, function (index, value) {
                list += "<li class='list-group-item'>";
                if (value.user == friendidx) {
                    list += "<b>상대방: </b>";
                } else {
                    list += "<b>나: </b>";
                }
                list += value.message + "</li>";
            });
            list += "</ul>";

            $("#messageArea").html(list);
            // Go to bottom of div tag
            // http://unikys.tistory.com/285
            $("#oronchuk-body").scrollTop($("#oronchuk-body")[0].scrollHeight);
        });
    };

    loadFriendListAndCount();

    $("#friend-add").click(function() {
        $("#friend-add-modal").modal("show");
    });

    $("#friend-add-modal").on('shown.bs.modal', function () {
        $("#search-input").focus();

        add_getUserList();
    });

    $("#friend-add-modal").on('hidden.bs.modal', function () {
        loadFriendListAndCount();
        $("#search-input").val('');
    });

    // http://www.w3schools.com/jquery/event_keyup.asp
    $("#search-input").keyup(function() {
        if ($("#search-input").val() == "") {
            add_getUserList();

        } else {
            var searchKeyword = $("#search-input").val();
            $.post("getUserList.php", { search: searchKeyword })
                .done(function(data) {
                    data = $.parseJSON(data);

                    var list = "<div class='list-group'>";
                    $.each(data, function(index, value) {
                        list += "<a class='add_user list-group-item' href='#' title='" + value.idx + "'>" + value.email + ", " + value.nickname + "</a>";
                    });
                    list += "</div>";

                    // Event bubbling??? write the code: unbind("click")... It makes me too tired.
                    // http://goldbio.blogspot.com/2012/02/jquery_10.html
                    $("#search-friend-head-small").html("Click to add Friend!");
                    $("#searched-friends")
                        .html("Results for <strong>" + searchKeyword + "</strong>" + list)
                        .unbind("click")
                        .delegate('.add_user', 'click', function() {
                            idx = this.title;

                            $.post("addFriend.php", { friendidx: idx })
                                .done(function (data) {
                                    $("#search-friend-head-small").html(data);
                                });
                        });
                });
        }
    });

    $("#friend-remove").click(function() {
        $("#friend-remove-modal").modal("show");
    });

    $("#friend-remove-modal").on('shown.bs.modal', function () {
        $("#remove-search-input").focus();

        remove_getFriendList();
    });

    $("#friend-remove-modal").on('hidden.bs.modal', function () {
        loadFriendListAndCount();
    });

    // http://www.w3schools.com/jquery/event_keyup.asp
    $("#remove-search-input").keyup(function() {
        if ($("#remove-search-input").val() == "") {
            remove_getFriendList();

        } else {
            var searchKeyword = $("#remove-search-input").val();
            $.post("getFriendList.php", { search: searchKeyword })
                .done(function(data) {
                    data = $.parseJSON(data);

                    var list = "<div class='list-group'>";
                    $.each(data, function(index, value) {
                        list += "<a class='remove_user list-group-item' href='#' title='" + value.idx + "'>" + value.email + ", " + value.nickname + "</a>";
                    });
                    list += "</div>";

                    $("#remove-search-friend-head-small").html("Click to remove Friend!");
                    $("#remove-searched-friends")
                        .html("Results for <strong>" + searchKeyword + "</strong>" + list)
                        .unbind("click")
                        .delegate('.remove_user', 'click', function() {
                            idx = this.title;

                            $.post("removeFriend.php", { friendidx: idx })
                                .done(function (data) {
                                    $("#remove-search-friend-head-small").html(data);
                                });
                        });
                });
        }
    });

    // http://stackoverflow.com/questions/6658752/click-event-doesnt-work-on-dynamically-generated-elements
    $("#friend-list").delegate('.list-group-item', 'click', function() {
        var title = this.title;
        var titleArray = title.split(", ");
        var friendidx = titleArray[0];
        var friendEmail = titleArray[1];

        $("#friend-name").html("<h3><strong>" + this.innerHTML + "</strong> (" + friendEmail + ")" + "</h3>");

        getMessage(friendidx);
    });

    $("#send-message-input").keydown(function(e) {
        if (e.which == 13) {
            var message = $("#send-message-input").val();
            var friendnameDiv = $("#friend-name").text();
            var friendName = friendnameDiv.split(" ")[0].trim();
            var friendEmail = friendnameDiv.split("(")[1].trim().slice(0, -1);

            if (message == "") {
                $.post("getUserIdx.php", {
                    friendName: friendName,
                    friendEmail: friendEmail
                }).done (function (friendidx) {
                    getMessage(friendidx);
                });                

                return;
            }
            message = message.replace(/</g, "&lt;").replace(/>/g, "&gt;");

            $.post("addMessage.php", {
                friendName: friendName,
                friendEmail: friendEmail,
                message: message
            }).done(function (data) {
                if (data == "true") {
                    $("#send-message-input").val('');
                    // Execute something after done load event
                    // http://stackoverflow.com/questions/19218885/jquery-after-load-complete-event
                    $.post("getUserIdx.php", {
                        friendName: friendName,
                        friendEmail: friendEmail
                    }).done (function (friendidx) {
                       getMessage(friendidx);
                    });
                } else {
                    alert("Getting messages fail!");
                }
            });
        }
    });
});
