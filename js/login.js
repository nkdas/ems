// function to send credentials to the server and authenticate user
$("document").ready(function(){
	$("#signin").click(function(){
		$("#progress").removeClass("hiddenDiv");
		$("#progress").addClass("visibleDiv");
		disableButton("#signin");
		var errors = "";
		if ($('#userName').val() == "") {
			errors += "<label class='myLabel'>userName cannot be blank</label><br>";
		}
		if ($('#password').val() == "") {
			errors += "<label class='myLabel'>Password cannot be blank</label><br>";
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
					if (data.status == '1') {
						window.location.replace("home.php");
					}
					else if (data.status == '2') {
						errors += "<label class='myLabel'>Please activate your account before signing in</label><br>";
						showErrors(errors);
					}
					else if (data.status == '3') {
						errors += "<label class='myLabel'>Either userName or password is invalid</label><br>";
						showErrors(errors);
					}
					else if (data.status == '4') {
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
		$(".progress").removeClass("visibleDiv");
		$(".progress").addClass("hiddenDiv");
		enableButton("#signin");
	});

	function showErrors(errors) {
		$('.message').html("<div id='message' class='jumbotron visibleDiv'>" +
				"<label class='myLabel'>" + errors + "</label></div>");
			window.scroll(0,0);
	}
});