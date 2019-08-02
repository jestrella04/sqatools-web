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

// Default settings
$verify = false;
$checks = false;
$token19 = false;
$response = false;
$webpay_base_path = null;
$webpay_final_path = null;
$testcase = null;
$recaptcha = true;

// Get data structure from URL
$path = trim($_SERVER["PATH_INFO"], '/');

// Extract desired parts from $path
$path_parts = explode('/', $path);

// Normalize variables for easy reference
$environment = $path_parts[0];
$extraOptions = $path_parts[1];
$testcase = $path_parts[2];

// Get additional options
$extraOptions = explode('+', $extraOptions);

// Set webpay path
if ('staging' == $environment) {
	$webpay_final_path = $webpay_base_path = 'https://test.cenpos.net:7443/restrictedtoken/';
} else if ('miami3' == $environment) {
	$webpay_final_path = $webpay_base_path = 'https://test.cenpos.net:7443/restrictedtoken/';
} else if ('dev' == $environment) {
	$webpay_final_path = $webpay_base_path = 'https://test.cenpos.net:7443/restrictedtoken/';
}

// Set additional URL params
if (in_array('norecaptcha', $extraOptions)) {
	$webpay_final_path = $webpay_final_path . '?isRecaptcha=false';
} else {
	$webpay_final_path = $webpay_final_path . '?isRecaptcha=true';
}

if (in_array('nosubmit', $extraOptions)) {
	$webpay_final_path = $webpay_final_path . '&isSubmit=false';
} else {
	$webpay_final_path = $webpay_final_path . '&isSubmit=true';
}

if (in_array('nocvv', $extraOptions)) {
	$webpay_final_path = $webpay_final_path . '&isCvv=false';
} else {
	$webpay_final_path = $webpay_final_path . '&isCvv=true';
}

if (in_array('classic', $extraOptions)) {
	$webpay_final_path = $webpay_final_path . '&styleview=classic';
} else if (in_array('modern', $extraOptions)) {
	$webpay_final_path = $webpay_final_path . '&styleview=modern';
} else if (in_array('simple', $extraOptions)) {
	$webpay_final_path = $webpay_final_path . '&styleview=simple';
}

// Validate file exists
if (!file_exists('html/' . $testcase)) {
	$testcase = null;
}

// If everything is valid, let's print the HTML page
if (!is_null($webpay_base_path) && !is_null($testcase)) {
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>BuyerQuest Test</title>
		<style type="text/css">
			iframe{border:0;}
			#submit{padding:1em;background:#0e659c;font-weight:700;color:white;border:1px solid whiteSmoke;border-radius:5px;cursor:pointer;}
			#submit:hover{background:#157cbd;}
		</style>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="https://www.cenpos.com/Plugins/porthole.min.js"></script>
		<script type="text/javascript" src="https://www.cenpos.com/Plugins/jquery.restrictedtoken.js"></script>
		<?php include('html/' . $testcase) ?>
		<?php include('script.php') ?>
	</head>

	<body>
		<div id="NewCenposPlugin"></div>
		<!--<button id="submit" type="button">SUBMIT</button>-->
	</body>
</html>
<?php

} else {
	echo '<h1>Oops, something went wrong! You broke it!</h1>';
}
