// function to add scroll spy and smooth scrolling
$(document).ready(function(){
	// Add scrollspy
	$('body').scrollspy({target: ".navbar", offset: 50});

	// Add smooth scrolling on all links inside the navbar
	$("#myNavbar a").on('click', function(event) {
		// Prevent default anchor click behavior
		event.preventDefault();
		// Store hash
		var hash = this.hash;

		// Using jQuery's animate() method to add smooth page scroll
		// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
		$('html, body').animate({
			scrollTop: $(hash).offset().top
		}, 800, function(){
			// Add hash (#) to URL when done scrolling (default click behavior)
			window.location.hash = hash;
		});
	});
});

// function to show preview of the photo to be uploaded
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#profilePhoto').attr('src', e.target.result)
		};
		reader.readAsDataURL(input.files[0]);
	}
}