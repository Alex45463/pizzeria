<?php

function checkMissingData($data, $islogin = false) {
	$missing = array();

	if (!isset($data['email']))
		array_push($missing, 'Email');

	if (!isset($data['password']))
		array_push($missing, 'Password');

	if(!$islogin)
		if (!isset($data['username']))
			array_push($missing, 'Username');
	if(!$islogin)	
		if (!isset($data['name']))
			array_push($missing, 'Name');
	if(!$islogin)	
		if (!isset($data['surname']))
			array_push($missing, 'Surname');
	if(!$islogin)	
		if (!isset($data['preference']))
			array_push($missing, 'Preference');
	if(!$islogin)	
		if (!isset($data['billing_method']))
			array_push($missing, 'Billing Method');
	if(!$islogin)	
		if (!isset($data['telephone']))
			array_push($missing, 'Telephone');
	
	return $missing;
}

function preventXSS($data, $isLogin = false) {
	$secureData = array();
	foreach ($data as $key => $value) { 
		$value = ($key === 'email' || $key === 'username') ? strtolower($value) : $value ;
		$secureData[$key] = trim( $value );
	}
	if(!$isLogin)
		$secureData['newsletter'] = (isset($data['newsletter']) && $data['newsletter'] === 'on') | 0;
	return $secureData;
}

function checkValidData($data) {
	$invalidData = array();
	if(!preg_match("/^[0-9\(\)\+]*$/", $data['telephone']))
		array_push($invalidData, 'Telephone');
	
	if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
		array_push($invalidData, 'Email');

	$billing_methods = array('Paypal', 'Carta di credito', 'Bonifico', 'Bancomat');
	if(!in_array($data['billing_method'], $billing_methods))
		array_push($invalidData, 'Billing Method'); 
	
	$preferences = array('Tablet', 'Computer', 'Smartphone');
	if(!in_array($data['preference'], $preferences))
		array_push($invalidData, 'Preference'); 

	return $invalidData;
}

function isDuplicate($data, $field, $mysqli) {
	// Prepare SELECT statement for checking if the user already exist (duplicates)
	$stmt = $mysqli->prepare('SELECT * FROM `form` WHERE `'.$field.'`=? ;');
	if (false === $stmt) {
		die('prepare() '.$field.' check statement failed: ' . $mysqli->error);
	}
	// Bind SELECT check statement
	$result = $stmt->bind_param('s', $data);
	if (false === $result) {
		die('bind() '.$field.' check failed: ' . $stmt->error);
	}
	// Execute SELECT check statement
	$result = $stmt->execute();
	if (false === $result) {
		die('execute() '.$field.' check failed: ' . $stmt->error);
	}
	// Bind result variables
	$check = $stmt->get_result();
	// Close the Prepared Statement
	$stmt->close();
	// Fetch result
	$check->fetch_object();
	//check if user exists
	if ($check->num_rows > 0)
		return true;
	return false;
}

function checkDuplicateUser($data, $mysqli) {
	$duplicate = array();
	if(isDuplicate($data['email'], "email", $mysqli))
		array_push($duplicate, "Email");
	if(isDuplicate($data['username'], "username", $mysqli))
		array_push($duplicate, "Username");
	return $duplicate;
}

function insertUser($data, $mysqli) {
	$stmt = $mysqli->prepare(
		'INSERT INTO `form` ( `name`, `surname`, `username`, `email`, `password_hash`, `preference`, `billing_method`, `telephone`, `newsletter` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? ) ;'
	);
	if (false === $stmt) {
		die('prepare() failed: ' . $mysqli->error);
	}
	
	$password_hash = password_hash($data['password'], PASSWORD_DEFAULT, [ 'cost' => 8 ]);

	// Bnd INSERT statement for registering the user
	$result = $stmt->bind_param(
		'ssssssssi',
		$data['name'],
		$data['surname'],
		$data['username'],
		$data['email'],
		$password_hash,
		$data['preference'],
		$data['billing_method'],
		$data['telephone'],
		$data['newsletter']
	);

	if (false === $result) {
		die('bind() failed: ' . $stmt->error);
	}

	$result = $stmt->execute();
	if (false === $result) {
		die('execute() failed: ' . $stmt->error);
	}

	// Close the Prepared Statement
	$stmt->close();
}

function loginUser($data, $mysqli) {
	$stmt = $mysqli->prepare("SELECT * FROM `form` WHERE username=? OR email=? ;");
	if ( false===$stmt ) {
		die('prepare() failed: '.$mysqli->error);
	}

	$result = $stmt->bind_param("ss", $data['email'], $data['email']);
	if ( false===$result ) {
		die('bind() failed: '.$stmt->error);
	}

	$result = $stmt->execute();
	if ( false===$result ) {
		die('execute() failed: '.$stmt->error);
	}

	$result = $stmt->get_result();
	$stmt->close();

	$row = $result->fetch_object();
	if($row){
		return password_verify($data['password'], $row->password_hash) ?  $row : null;
	}

	return "User not Found";
}

?>