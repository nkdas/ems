function displayMap() {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "get_address.php",
        success: function(data) {
            $("#googleMap").removeClass('hidden-div');
            drawMap(data.address, data.employeeName, data.email);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function drawMap(addresses, employeeName, email) {
    var map;
    var elevator;
    var myOptions = {
        zoom: 2,
        center: new google.maps.LatLng(0, 0),
        mapTypeId: 'terrain'
    };
    map = new google.maps.Map($('#googleMap')[0], myOptions);
    i = 0;
    for (var x = 0; x < addresses.length; x++) {
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
            var p = data.results[0].geometry.location
            var latlng = new google.maps.LatLng(p.lat, p.lng);
            
            
            var marker = new google.maps.Marker({
                position: latlng,
                map: map
            });
            var infowindow = new google.maps.InfoWindow({
                content: '',
                map: map
            });
            infowindow.close();
            
            bindInfoWindow(marker, map, infowindow, '<h3>' + employeeName[i] + '</h3><h5>' + email[i] + '</h5><p>' + addresses[i] + '</p>');
            i++;
            function bindInfoWindow(marker, map, infowindow, html) { 
                google.maps.event.addListener(marker, 'mouseover', function() {
                    infowindow.setContent(html); 
                    infowindow.open(map, this);
                });
            }
            google.maps.event.addListener(marker, 'mouseout', function() {
                infowindow.close();
            });
        });
    }
}