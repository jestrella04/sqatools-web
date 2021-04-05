<?php

// Enable debugging
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// Get data structure from URL
$path = trim($_SERVER["PATH_INFO"], '/');

// Extract desired parts from $path
$path_parts = explode('/', $path);

// Normalize variables for easy reference
$merchantId = $path_parts[0];
$environment = $path_parts[1];
$plugin = $path_parts[2];
$testcase = $path_parts[3];

// Replace extension
$testcase = str_replace('.html', '.php', $testcase);

// Set webpay path
if ('staging' == $environment) {
	$webpay_path = 'https://www4.cenpos.net/webpaytest/v7/html5/';
} else if ('production' == $environment) {
	$webpay_path = 'https://www4.cenpos.net/webpay/v7/html5/';
} else {
	$webpay_path = null;
}

// Validate file exists
if (!file_exists('html/' . $testcase)) {
	$testcase = null;
}

// Set merchant data
$merchantData = json_decode(file_get_contents('merchant-data.json'));
$merchantId = $merchantId ?? '12721628';
$apiKey = $merchantData->$merchantId->{'api-key'};
$aesKey = $merchantData->$merchantId->{'aes-key'};

// Verifying post
$ip = $_SERVER["REMOTE_ADDR"];
$email = $_GET['email'] ?? '';
$clientId = $_GET['client_id'] ?? '';
$amount = $_GET['amount'] ?? '';
$invoice = $_GET['invoice'] ?? '';
$address = $_GET['address'] ?? '';
$zip = $_GET['zip'] ?? '';
$postUrl = $webpay_path . "?app=genericcontroller&action=siteVerify";
$postParams = "amount=$amount&secretkey=$aesKey&merchant=$apiKey&email=$email&ip=$ip&customercode=$clientId&invoice=$invoice&address=$address&zipcode=$zip";

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
		<link rel="stylesheet" href="../../../../../resources/css/plugin.css">
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
