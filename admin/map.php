<?php

    $address = urlencode($_POST['address']);

    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";

    // Make the HTTP request
    $data = file_get_contents($url);
    // Parse the json response
    $jsondata = json_decode($data,true);

    // If the json data is invalid, return empty array
    if (!check_status($jsondata)) {
    	//return array();
    }

    $LatLng = array(
        'lat' => $jsondata["results"][0]["geometry"]["location"]["lat"],
        'lng' => $jsondata["results"][0]["geometry"]["location"]["lng"],
    );

   echo json_encode($LatLng);
?>