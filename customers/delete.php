<?php 

// error_reporting(0);

// This is the basic headers for the API
header("Access-Control-Allow-Origin:*"); // this will allow everything
header("Content-Type: application/json"); // our data will be in json format when we send it from the backend
header("Access-Control-Allow-Method: DELETE"); // This API should only be accessible by the DELETE method
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With");


// This is where we wrote all our functions
include("function.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "DELETE"){

	// deleteCustomer is a function we wrote to fetch the customers from our database
	// the true makes it to be an associate array instead of an object
	$inputData = json_decode(file_get_contents("php://input"), true);

	// if this is empty, it means that the data was sent through a PUT form
	if (empty($inputData)){

		// echo $_POST['name'];
		$deleteCustomer = deleteCustomer($_POST);
	} else {

		// echo $inputData['name'];
		$deleteCustomer = deleteCustomer($inputData);
	}

	echo $deleteCustomer;

} else {
	$data = [
		"status" => 405,
		"message" => $requestMethod . " Method Not Allowed"
	];

	header("HTTP/1.0 405 Method Not Allowed");
	echo json_encode($data);
}


 ?>