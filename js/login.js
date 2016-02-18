// function to send credentials to the server and authenticate user
$("document").ready(function(){
    $("#signin").click(function(){
        $("#progress").removeClass("hidden-div").addClass("visible-div");
        disableButton("#signin");
        var errors = "";
        if ($('#userName').val() == "") {
            errors += "<label class='my-label'>userName cannot be blank</label><br>";
        }
        if ($('#password').val() == "") {
            errors += "<label class='my-label'>Password cannot be blank</label><br>";
        }
        if (!(errors.length != 0)) {
            var page = $(this).hasClass('admin-button') ? "admin" : "user";

            if ('admin' == page) {
                myUrl = '../authenticate.php';
            }
            else {
                myUrl = 'authenticate.php';
            }

            $.ajax({
                type: "POST",
                dataType: "json",
                url: myUrl,
                data: "userName=" + $('#userName').val() + "&password=" + $('#password').val() +
                "&page=" + page,
                success: function(data) {
                    if ('login success' == data.status) {                       
                        window.location.replace("home.php");
                    }
                    else if ('inactive account' == data.status) {
                        errors += "<label class='my-label'>Please activate your account before signing in</label><br>";
                        showErrors(errors);
                    }
                    else if ('invalid credentials' == data.status) {
                        errors += "<label class='my-label'>Either username or password is invalid</label><br>";
                        showErrors(errors);
                    }
                    else if ('admin login success' == data.status) {
                        window.location.replace("admin_home.php");
                    }
                },
                error: function() {
                    errors += "Sorry, there was a problem!";
                    showErrors(errors);
                },
            });
        }
        if (errors.length != 0) { 
            showErrors(errors);
        }
        $(".progress").removeClass("visible-div");
        $(".progress").addClass("hidden-div");
        enableButton("#signin");
    });

    function showErrors(errors) {
        $('.message').html("<div id='message' class='jumbotron visible-div'>" +
        "<label class='my-label'>" + errors + "</label></div>");
        window.scroll(0,0);
    }
});