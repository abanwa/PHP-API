<?php 


require("../inc/dbcon.php");

function error422($message){
	$data = [
		"status" => 422,
		"message" => $message
	];

	header("HTTP/1.0 422 Unprocessible Entity");
	echo json_encode($data);
	exit();
}

// Save/Insert customer
function storeCustomer($customerInput){
	global $conn;

	$name = mysqli_real_escape_string($conn, $customerInput['name']);
	$email = mysqli_real_escape_string($conn, $customerInput['email']);
	$phone = mysqli_real_escape_string($conn, $customerInput['phone']);

	if (empty(trim($name))){
		return error422("Enter your name");
	} else if (empty(trim($email))){
		return error422("Enter your email");
	} else if (empty(trim($phone))){
		return error422("Enter your phone");
	} else {
		$query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";
		$result = mysqli_query($conn, $query);

		if ($result){

			$data = [
				"status" => 201,
				"message" => "Customer Created Successfully"
			];

			header("HTTP/1.0 201 Created");
			return json_encode($data);

		} else {
			$data = [
				"status" => 500,
				"message" => "Internal Server Server"
			];

			header("HTTP/1.0 500 Internal Server Server");
			return json_encode($data);
		}
	}
}


// get all customers
function getCustomerList(){
	// we use global so that we can access the database connection inside the function
	global $conn;

	$query = "SELECT * FROM customers";
	$query_run = mysqli_query($conn, $query);

	if ($query_run){

		if (mysqli_num_rows($query_run) > 0){

			$res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

			$data = [
				"status" => 200,
				"message" => "Customer List Fetched Successfully",
				"data" => $res

			];

			header("HTTP/1.0 200 OK");
			return json_encode($data);

		} else {
			$data = [
				"status" => 404,
				"message" => "No Customer Found"
			];

			header("HTTP/1.0 404 No Customer Found");
			return json_encode($data);
		}


	} else {
		$data = [
			"status" => 500,
			"message" => "Internal Server Server"
		];

		header("HTTP/1.0 500 Internal Server Server");
		return json_encode($data);
	}
}



// get a single customer base on ID
function getCustomer($customerParams){
	global $conn;

	// Remember $customerParams is the $_GET we parsed in the function, check if the $customerParams/$_GET has the [id]
	if ($customerParams['id'] == null){
		return error422('Enter your customer id');
	}

	// Now, we will get the customer id and validate it
	$customerId = mysqli_real_escape_string($conn, $customerParams['id']);

	$query = "SELECT * FROM customers WHERE id = '$customerId' LIMIT 1";
	$result = mysqli_query($conn, $query);

	// check if the query is true.
	if ($result){

		// check if the query result has record or not
		if (mysqli_num_rows($result) == 1){
			$res = mysqli_fetch_assoc($result);
			$data = [
				"status" => 200,
				"message" => "Customer Fetched Successfully",
				"data" => $res
			];

			header("HTTP/1.0 200 OK");
			return json_encode($data);
		} else {
			$data = [
				"status" => 404,
				"message" => "No Customer Found"
			];

			header("HTTP/1.0 404 No Customer Found");
			return json_encode($data);
		}
	} else {
		$data = [
			"status" => 500,
			"message" => "Internal Server Server"
		];

		header("HTTP/1.0 500 Internal Server Server");
		return json_encode($data);
	}
}



// Edit/Update customer base on the id
function updateCustomer($customerInput){
	global $conn;

	// check whether the id of the record we want to update is also sent
	if (!isset($customerInput["id"])){
		return error422("customer Id not found");
	} else if ($customerInput["id"] == null){
		return error422("Enter the customer id");
	}

	$customerId = mysqli_real_escape_string($conn, $customerInput['id']);

	$name = mysqli_real_escape_string($conn, $customerInput['name']);
	$email = mysqli_real_escape_string($conn, $customerInput['email']);
	$phone = mysqli_real_escape_string($conn, $customerInput['phone']);

	if (empty(trim($name))){
		return error422("Enter your name");
	} else if (empty(trim($email))){
		return error422("Enter your email");
	} else if (empty(trim($phone))){
		return error422("Enter your phone");
	} else {

		// we will update the customer base on the ID
		$query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$customerId' LIMIT 1";
		$result = mysqli_query($conn, $query);

		if ($result){

			$data = [
				"status" => 200,
				"message" => "Customer Updated Successfully"
			];

			header("HTTP/1.0 200 Success");
			return json_encode($data);

		} else {
			$data = [
				"status" => 500,
				"message" => "Internal Server Server"
			];

			header("HTTP/1.0 500 Internal Server Server");
			return json_encode($data);
		}
	}
}




// To delete a customer base on the customer id. customerParams is the $_POST global

function deleteCustomer($customerParams){
	global $conn;
	
	// validate the input
	// check whether the id of the record we want to update is also sent
	if (!isset($customerParams["id"])){
		return error422("customer Id not foundddd");
	} else if ($customerParams["id"] == null){
		return error422("Enter the customer id");
	}

	$customerId = mysqli_real_escape_string($conn, $customerParams['id']);

	// write the query to delete the customer record base on the customer id
	$query = "DELETE FROM customers WHERE id = '$customerId' LIMIT 1";
	$result = mysqli_query($conn, $query);

	if ($result){
		$data = [
			"status" => 200,
			"message" => "Customer Deleted Successfully"
		];

		header("HTTP/1.0 200 OK");
		return json_encode($data);
	} else {
		$data = [
			"status" => 404,
			"message" => "Customer Not Found. Could not delete"
		];

		header("HTTP/1.0 404 Customer Not Found");
		return json_encode($data);
	}

}





 ?>