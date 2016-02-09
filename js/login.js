// function to send credentials to the server and authenticate user
$("document").ready(function(){
	$("#signin").click(function(){
		$("#progress").removeClass("hidden-div");
		$("#progress").addClass("visible-div");
		disableButton("#signin");
		var errors = "";
		if ($('#userName').val() == "") {
			errors += "<label class='my-label'>userName cannot be blank</label><br>";
		}
		if ($('#password').val() == "") {
			errors += "<label class='my-label'>Password cannot be blank</label><br>";
		}
		if (0 == errors.length) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "authenticate.php",
				data: "userName=" + $('#userName').val() + "&password=" + $('#password').val(),
				success: function(data) {
					if (data.status == '1') {
						window.location.replace("home.php");
					}
					else if (data.status == '2') {
						errors += "<label class='my-label'>Please activate your account before signing in</label><br>";
						showErrors(errors);
					}
					else if (data.status == '3') {
						errors += "<label class='my-label'>Either userName or password is invalid</label><br>";
						showErrors(errors);
					}
					else if (data.status == '4') {
						window.location.replace("admin.php");
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