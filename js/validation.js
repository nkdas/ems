// functions to change the appearance of the input fields according to the validity of their inputs.
function changeAppearanceError(element, message) {
	$(element).parent().removeClass("has-success");
	$(element).next('span').remove();
	$(element).next('label').remove();
	$(element).parent().addClass("has-error has-feedback");
	$(element).after("<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>");
	$(".has-error .form-control-feedback").css("color", "#f03");
	$(".has-error .form-control").css("border-color", "#f03");
	$(element).next('span').after("<label class='my-label'>"+message+"</label>");
}

function changeAppearanceCorrect(element) {
	$(element).parent().removeClass("has-error");
	$(element).next('span').remove();
	$(element).next('label').remove();
	$(element).parent().addClass("has-success has-feedback");
	$(element).after("<span class='glyphicon glyphicon-ok form-control-feedback' aria-hidden='true'></span>");
	$(".has-success .form-control-feedback").css("color", "#092");
	$(".has-success .form-control").css("border-color", "#092");
}

function enableButton(button) {
	$(button).removeClass("disabled");
	$(button).prop('disabled', false);
}

function disableButton(button) {
	$(button).addClass("disabled");
	$(button).prop('disabled', true);
}

function showButton(button) {
	$(button).removeClass("hidden-div");
}

function hideButton(button) {
	$(button).addClass("hidden-div");
}

$(document).ready(function(){
	// validation when the user leaves an input field
	$(".required").on('blur', function(){
		var letters = /^[a-zA-Z ]+$/;
		var numbers = /^[0-9]+$/;
		var emailRegex = /^[a-z0-9_-]+@[a-z0-9._-]+\.[a-z]+$/i;
		var elementId = $(this).attr('id');

		if (elementId == 'password') { 
			if ($(this).val().length < 6) {
				changeAppearanceError(this,"Should be of atleast 6 characters");
			}
			else {
				changeAppearanceCorrect(this);
			}
		}

		if (elementId == 'reEnterPassword') {
			if ($(this).val().length < 6) {
				changeAppearanceError(this,"Should be of atleast 6 characters");
			}
			else if ($(this).val() != $('#password').val()) {
				changeAppearanceError(this,"Passwords donot match");
				changeAppearanceError('#password',"Passwords donot match");
			}
			else {
				changeAppearanceCorrect(this);
				changeAppearanceCorrect('#password');
			}
		}

		if ((elementId == 'firstName') || (elementId == 'lastName') || (elementId == 'city') || (elementId == 'state')
			|| (elementId == 'employer')){ 
			if (!$(this).val().match(letters)) {
				changeAppearanceError(this,"Only letters are allowed in this fields");
			}
			else {
				changeAppearanceCorrect(this);
			}
		}
		
		if ((elementId == 'telephone') || (elementId == 'mobile')) { 
			if ((!$(this).val().match(numbers)) || ($(this).val().length != 10)) {
				changeAppearanceError(this,"Mobile number should be of 10 digits and should contain only numbers");
			}
			else {
				changeAppearanceCorrect(this);
			}
		}

		if (elementId == 'zip') { 
			if (!$(this).val().match(numbers)) {
				changeAppearanceError(this,"Zip must contain only numbers");
			}
			else {
				changeAppearanceCorrect(this);
			}
		}

		if ($(this).val() == "") {
			changeAppearanceError(this,"This field cannot be left blank");
		}
		else if((elementId == 'street') || (elementId == 'dateOfBirth')){
				changeAppearanceCorrect(this);
		}
	});

	// Add function to the form submission
	$(".submit-button").on('click', function validate(){ 
		$("#progress").removeClass("hidden-div");
		$("#progress").addClass("visible-div");
		hideButton('.submit-button');

		origin = $(this).attr('name');
		var letters = /^[a-zA-Z ]+$/;
		var numbers = /^[0-9]+$/;
		var emailRegex = /^[a-z0-9_-]+@[a-z0-9._-]+\.[a-z]+$/i;
		var errors = "<br><label class='my-label'>Please Fix the following errors:</label><br>";
		
		var photo = $("#uploadBtn").val();
		var extension = photo.substring(photo.lastIndexOf('.') + 1);
		if( !(extension == "JPEG" || extension == "jpeg" || extension == "jpg" || extension == "JPG" || 
			extension == "png" || extension == "PNG" || extension == "gif" || extension == "GIF") && (photo != "") ) {
			errors += "<label class='my-label'>Only JPG, PNG and GIF images are allowed as profile photo</label><br>";
		}

		if (origin == "submit") {
			if ($('#userName').val() == "") {
				errors += "<label class='my-label'>userName cannot be blank</label><br>";
				changeAppearanceError('#userName',"This field cannot be left blank");
			}
			else if ($('#userName').val().length < 6) {
				errors += "<label class='my-label'>userName should be of atleast 6 characters</label><br>";
				changeAppearanceError('#userName',"should be of atleast 6 characters");
			}

			if ($('#password').val() == "") {
				errors += "<label class='my-label'>Password cannot be blank</label><br>";
				changeAppearanceError('#password',"This field cannot be left blank");
			}
			else if ($('#password').val().length < 6) {
				errors += "<label class='my-label'>Password should be of atleast 6 characters</label><br>";
				changeAppearanceError('#password',"should be of atleast 6 characters");
			}

			if ($('#reEnterPassword').val() == "") {
				errors += "<label class='my-label'>Please re-enter your password</label><br>";
				changeAppearanceError('#reEnterPassword',"This field cannot be left blank");
			}
			else if ($('#password').val() != $('#reEnterPassword').val()) {
				errors += "<label class='my-label'>Passwords entered in the 'Password' and 'Re-enter Password' fields donot match</label><br>";
				changeAppearanceError('#password',"Passwords donot match");
				changeAppearanceError('#reEnterPassword',"Passwords donot match");
			}
		}

		if ($('#firstName').val() == "") {
			errors += "<label class='my-label'>firstName cannot be blank</label><br>";
			changeAppearanceError('#firstName',"This field cannot be left blank");
		}
		else if (!$('#firstName').val().match(letters)) {
			errors += "<label class='my-label'>firstName should contain only characters</label><br>";
			changeAppearanceError('#firstName',"Only letters are allowed in this field");
		}

		if ($('#lastName').val() == "") {
			errors += "<label class='my-label'>lastName cannot be blank</label><br>";
			changeAppearanceError('#lastName',"This field cannot be left blank");
		}
		else if (!$('#lastName').val().match(letters)) {
			errors += "<label class='my-label'>lastName should contain only characters</label><br>";
			changeAppearanceError('#lastName',"Only letters are allowed in this field");
		}

		if ($('#dateOfBirth').val() == "") {
			errors += "<label class='my-label'>Please enter your date of birth</label><br>";
			changeAppearanceError('#dateOfBirth',"This field cannot be left blank");
		}

		if ($('#employer').val() == "") {
			errors += "<label class='my-label'>Employer cannot be blank</label><br>";
			changeAppearanceError('#employer',"This field cannot be left blank");
		}
		else if (!$('#employer').val().match(letters)) {
			errors += "<label class='my-label'>Employer should contain only characters</label><br>";
			changeAppearanceError('#employer',"Only letters are allowed in this field");
		}

		if ($('#email').val() == "") {
			errors += "<label class='my-label'>EMail ID cannot be blank</label><br>";
			changeAppearanceError('#email',"This field cannot be left blank");
		}
		else if (!$('#email').val().match(emailRegex)) {
			errors += "<label class='my-label'>Please enter a valid email</label><br>";
			changeAppearanceError('#email',"Invalid EMail");
		}
		if(!$('input[name=gender]:checked').val()) {
			errors += "<label class='my-label'>Please select a gender</label><br>";
		}
		if ($('#street').val() == "") {
			errors += "<label class='my-label'>Please enter your residential street</label><br>";
			changeAppearanceError('#street',"This field cannot be left blank");
		}
		if ($('#city').val() == "") {
			errors += "<label class='my-label'>Please enter your residential city</label><br>";
			changeAppearanceError('#city',"This field cannot be left blank");
		}
		else if (!$('#city').val().match(letters)) {
			errors += "<label class='my-label'>City should contain only characters</label><br>";
			changeAppearanceError('#city',"Only letters are allowed in this field");
		}

		if ($('#state').val() == "") {
			errors += "<label class='my-label'>Please enter your residential state</label><br>";
			changeAppearanceError('#state',"This field cannot be left blank");
		}
		else if (!$('#state').val().match(letters)) {
			errors += "<label class='my-label'>State should contain only characters</label><br>";
			changeAppearanceError('#state',"Only letters are allowed in this field");
		}

		if ($('#zip').val() == "") {
			errors += "<label class='my-label'>Please enter your residential zip code</label><br>";
			changeAppearanceError('#zip',"This field cannot be left blank");
		}
		else if (!$('#zip').val().match(numbers)) {
			errors += "<label class='my-label'>Zip must contain only numbers</label><br>";
			changeAppearanceError('#zip',"Zip must contain only numbers");
		}

		if ($('#telephone').val() == "") {
			errors += "<label class='my-label'>Please enter your residential telephone number</label><br>";
			changeAppearanceError('#telephone',"This field cannot be left blank");
		}
		else if (!$('#telephone').val().match(numbers)) {
			errors += "<label class='my-label'>Telephone number should contain only numbers</label><br>";
			changeAppearanceError('#telephone',"Should contain only numbers");
		}

		if ($('#mobile').val() == "") {
			errors += "<label class='my-label'>Please enter your residential mobile number</label><br>";
			changeAppearanceError('#mobile',"This field cannot be left blank");
		}
		else if (!$('#mobile').val().match(numbers)) {
			errors += "<label class='my-label'>Mobile number should contain only numbers</label><br>";
			changeAppearanceError('#mobile',"Should contain only numbers");
		}
		else if ( ($('#mobile').val().length < 10) || ($('#mobile').val().length > 10) ) {
			errors += "<label class='my-label'>Mobile number should be of 10 digits</label><br>";
			changeAppearanceError('#mobile',"Should be of 10 digits");
		}

		if (errors.length != 72) {
			$('.message').html("<div id='message' class='jumbotron visible-div'>" +
				"<label class='my-label'>" + errors + "</label></div>");
			window.scroll(0,0);
			$("#progress").removeClass("visible-div");
			$("#progress").addClass("hidden-div");
			showButton(".submit-button");
			return false;
		}
		else {
			$('.message').html("");
			window.scroll(0,0);
			return true;
		}
	});

	// function to check uniqueness of userName and email id as soon as user leaves the input field
	$(".unique").on('blur', function(){
		if ($(this).attr('id') == "userName") {
			$("#userNameProgress").removeClass("hidden-div");
			$("#userNameProgress").addClass("visible-div");
		}
		else if ($(this).attr('id') == "email") {
			$("#emailProgress").removeClass("hidden-div");
			$("#emailProgress").addClass("visible-div");
		}
		

		// check for which element the uniqueness is being checked (userName or email id)
		if ($(this).attr('id') == 'email') {
			var element = 'email';
		}
		else if ($(this).attr('id') == 'userName') {
			var element = 'userName';
		}

		// we need to check from where the request is coming from (registration page or edit page)
		if ($(this).attr('class') == 'form-control unique edit') {
			var callingPage = 'update';
		}
		else {
			var callingPage = 'register';
		}

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "process_data.php",
			data: "function=checkUniqueness&element=" + element + "&elementValue=" + $(this).val() + 
			"&callingPage=" + callingPage,

			success: function(data) {
				if (data.status == 'unavailable') {
					if (element == 'email') {
						changeAppearanceError('#email', 'This Email ID is already taken');
					}
					else {
						changeAppearanceError('#userName', 'This userName is already taken');	
					}
				}
				else if (element == 'email') {
					var emailRegex = /^[a-z0-9_-]+@[a-z0-9._-]+\.[a-z]+$/i;
					if (!$('#email').val().match(emailRegex)) {
						changeAppearanceError('#email','Invalid EMail');
					}
					else {
						changeAppearanceCorrect('#email');
					}
				}
				else if (element == 'userName') {
					if ($("#userName").val().length < 6) {
						changeAppearanceError('#userName',"Should be of atleast 6 characters");
					}
					else {
						changeAppearanceCorrect('#userName'); 
					}
				}
			},
			error: function(request, status, error) {
				console.log('error');
			},
		});
		
		if ($(this).attr('id') == "userName") {
			$("#userNameProgress").removeClass("visible-div");
			$("#userNameProgress").addClass("hidden-div");
		}
		else if ($(this).attr('id') == "email") {
			$("#emailProgress").removeClass("visible-div");
			$("#emailProgress").addClass("hidden-div");
		}
	});
});