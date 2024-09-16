<?php 

// error_reporting(0);

// This is the basic headers for the API
header("Access-Control-Allow-Origin:*"); // this will allow everything
header("Content-Type: application/json"); // our data will be in json format when we send it from the backend
header("Access-Control-Allow-Method: POST"); // This API should only be accessible by the POST method
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");


// This is where we wrote all our functions
include("function.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "POST"){

	// This is used when the data is sent through other means but not through form
	// the true makes it to be an associate array instead of an object
	$inputData = json_decode(file_get_contents("php://input"), true);

	// if this is empty, it means that the data was sent through a POST form
	if (empty($inputData)){

		// echo $_POST['name'];
		$storeCustomer = storeCustomer($_POST);
	} else {

		// echo $inputData['name'];
		$storeCustomer = storeCustomer($inputData);
	}

	echo $storeCustomer;



} else {
	$data = [
		"status" => 405,
		"message" => $requestMethod . " Method Not Allowed"
	];

	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);
}


 ?>