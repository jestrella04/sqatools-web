<?php
// Force HTTPS for security
if ($_SERVER["HTTPS"] != "on") {
	$pageURL = "Location: https://";

	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}

	header($pageURL);
}

// Get data structure from URL
$path = trim($_SERVER["PATH_INFO"], '/');

// Extract desired parts from $path
$path_parts = explode('/', $path);

// Normalize variables for easy reference
$environment = $path_parts[0];
$plugin = $path_parts[1];
$testcase = $path_parts[2];

// Replace extension
$testcase = str_replace('.html', '.php', $testcase);

// Set webpay path
if ('prod-test' == $environment) {
	$webpay_path = 'https://www3.cenpos.net/webpaytest/v7/html5/';
} else if ('prod-test-pl' == $environment) {
	$webpay_path = 'https://www.cenpos.net/webpaytest/Passwordless/';
} else if ('prod-mia1' == $environment) {
	$webpay_path = 'https://www.cenpos.net/webpay/v7/html5/';
} else if ('prod-mia2' == $environment) {
	$webpay_path = 'https://www3.cenpos.net/webpay/v7/html5/';
} else if ('prod-mia3' == $environment) {
	$webpay_path = 'https://www4.cenpos.net/webpay/v7/html5/';
} else {
	$webpay_path = null;
}

// Validate plugin version
if (!is_numeric($plugin)) {
	$plugin = null;
}

// Validate file exists
if (!file_exists('html/' . $testcase)) {
	$testcase = null;
}

// Enhanced SWP security
//$merchant = urlencode("N4yTU6kUAEsXG8R15c/G4Q=="); // API Key
$merchant = "N4yTU6kUAEsXG8R15c%2FG4Q%3D%3D";
$privatekey = "Dp8PFt3wi8"; // AES Key
$ip = $_SERVER["REMOTE_ADDR"]; // IP address
$email = "cenposqatest@gmail.com"; // email will be used to retrieve tokens
$amount = "33.01";
$postUrl = $webpay_path . "?app=genericcontroller&action=siteVerify"; // Site where we are going to POST TO
$postParams = "amount=$amount&secretkey=$privatekey&merchant=$merchant&email=$email&ip=$ip"; //Params that will create the encryption

// Initialize cURL
$ch = curl_init($postUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get Response from the external server
$response = curl_exec($ch);
$error = curl_error($ch);

// Close the cURL connection
curl_close($ch);

// For debugging purposes only, get the error returned by the external server (if any)
if ($error) {
	exit($error);
}

// Get the JSON encoded response data
$response = json_decode($response);

// Check if the result is valid
if (0 != $response->Result) {
	exit($response->Message);
}

// If everything is valid, let's print the HTML page
if (!is_null($webpay_path) && !is_null($plugin) && !is_null($testcase)) {
	?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="UTF-8">
		<title>Webpay Test</title>
		<link rel="stylesheet" href="../../../../resources/css/plugin.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="https://www.cenpos.com/Plugins/porthole.min.js"></script>
		<script type="text/javascript" src="https://www.cenpos.com/Plugins/jquery.cenpos.<?= $plugin ?>.js"></script>
		<?php include('html/' . $testcase) ?>
	</head>

	<body>
		<div class="layaoutPanel">
			<div id="NewCenposPlugin"></div>
		</div>
	</body>

	</html>
<?php
} else {
	echo '<h1>Please enter a valid testcase and plugin combination!</h1>';
}
