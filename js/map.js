function displayMap() {
	var geocoder =  new google.maps.Geocoder();
    geocoder.geocode( { 'address': 'bhubaneswar'}, function(results, status) {
    	if (status == google.maps.GeocoderStatus.OK) {
			myCenter=new google.maps.LatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
			initialize(myCenter);
		} 
		else {
            alert("Something got wrong " + status);
		}
	});
   
}

function initialize(myCenter)
{
	var mapProp = {
		center:myCenter,
		zoom:5,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};

	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

	var marker=new google.maps.Marker({
  		position:myCenter,
  	});
	marker.setMap(map);
}

