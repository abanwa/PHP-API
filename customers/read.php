<?php 

// error_reporting(0);

// This is the basic headers for the API
header("Access-Control-Allow-Origin:*"); // this will allow everything
header("Content-Type: application/json"); // our data will be in json format when we send it from the backend
header("Access-Control-Allow-Method: GET"); // This API should only be accessible by the GET method
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");


// This is where we wrote all our functions
include("function.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "GET"){

	// getCustomerList is a function we wrote to fetch the customers from our database
	$customerList = getCustomerList();
	echo $customerList;

} else {
	$data = [
		"status" => 405,
		"message" => $requestMethod . " Method Not Allowed"
	];

	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);
}


 ?>