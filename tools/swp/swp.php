<?php

// Default settings
$verify = false;
$checks = false;
$token19 = false;
$response = false;
$webpay_path = null;
$testcase = null;
$recaptcha = false;
$object = false;
$plugin = "//www.cenpos.com/Plugins/jquery.simplewebpay.js";

// Get data structure from URL
$path = trim($_SERVER["PATH_INFO"], '/');

// Extract desired parts from $path
$path_parts = explode('/', $path);

// Normalize variables for easy reference
$environment = $path_parts[0];
$extraOptions = $path_parts[1];
$testcase = $path_parts[2];

// Get additional options
$extraOptions = explode('-', $extraOptions);

// Enable the checks flag
if (in_array('ach', $extraOptions)) {
	$checks = true;
}

// Enable the verify flag
if (in_array('verify', $extraOptions)) {
	$verify = true;
}

// Enable the token19 flag
if (in_array('token19', $extraOptions)) {
	$token19 = true;
}

// Set Recaptcha
if (in_array('recaptchadisabled', $extraOptions)) {
	$recaptcha = false;
} elseif (in_array('recaptchav2', $extraOptions)) {
	$recaptcha = 'v2';
} elseif (in_array('recaptchav3', $extraOptions)) {
	$recaptcha = 'v3';
}

// Check for Object flag
if (in_array('object', $extraOptions)) {
	$object = true;
	$plugin = "//www.cenpos.com/Plugins/jquery.simplewebpay.object.js";
}

// Set webpay path
if ('staging' == $environment) {
	if (!$checks) {
		$webpay_path = 'https://www4.cenpos.net/simplewebpay-test/cards/';
	} else {
		$webpay_path = 'https://www4.cenpos.net/simplewebpay-test/checks/';
	}
} else if ('miami3' == $environment) {
	if (!$checks) {
		$webpay_path = 'https://www4.cenpos.net/simplewebpay/cards/';
	} else {
		$webpay_path = 'https://www4.cenpos.net/simplewebpay/checks/';
	}
}

if ($verify) {
	// Enhanced SWP security
	$merchantId = urlencode("xO82MBB9FrcukKhFjkS+oWMfNKRybtYZmXd/vNt/QoA=");
	$privatekey = "ece2b8261cef7f01123265c0ceee9254";
	$ip = $_SERVER["REMOTE_ADDR"];
	$email = "cenposqatest@gmail.com";
	$postUrl = $webpay_path . "?app=genericcontroller&action=siteVerify";
	$postParams = "secretkey=$privatekey&merchant=$merchantId&email=$email&ip=$ip";
	
	if ($token19) $postParams = $postParams . '&type=createtoken19';

	if (!$recaptcha) {
		$postParams = $postParams . '&isrecaptcha=false';
	} else {
		$postParams = $postParams . '&isrecaptcha=true&recaptchaversion=' . $recaptcha;
	}

	echo $postParams;
	
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

	//var_dump($response->Data); die();
	// Check if the result is valid
	if (0 != $response->Result) {
		exit($response->Message);
	}
}

// Validate file exists
if (!file_exists('html/' . $testcase)) {
	$testcase = null;
}

// If everything is valid, let's print the HTML page
if (!is_null($webpay_path) && !is_null($testcase)) {
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Simple Webpay Test</title>
		<link rel="stylesheet" href="../../../../../resources/css/bundle.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="https://www.cenpos.com/Plugins/porthole.min.js"></script>
		<script type="text/javascript" src="<?= $plugin ?>"></script>
		<?php include('html/' . $testcase) ?>
	</head>

	<body>
		<div id="NewCenposPlugin"></div>
		<button id="submit" class="btn btn-success swp-btn" type="button">SUBMIT</button>
		<button id="cancel" class="btn btn-danger swp-btn" type="button" disabled>CANCEL</button>
	</body>
</html>
<?php

} else {
	echo '<h1>Oops, something went wrong! You broke it!</h1>';
}
