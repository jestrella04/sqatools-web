<?php
// Force HTTPS for security
if ( $_SERVER["HTTPS"] != "on" )
{
	$pageURL = "Location: https://";

 	if ( $_SERVER["SERVER_PORT"] != "80" )
 	{
  		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
 	}

 	else
 	{
  		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
 	}

 	header( $pageURL );
}

// Get data structure from URL
$path = trim( $_SERVER["PATH_INFO"], '/' );

// Extract desired parts from $path
$path_parts = explode( '/', $path );

// Normalize variables for easy reference
$environment = $path_parts[0];
$plugin = $path_parts[1];
$testcase = $path_parts[2];

// Replace extension
$testcase = str_replace('.html', '.php', $testcase);

// Set webpay path
if ( 'prod-test' == $environment )
{
	$webpay_path = 'https://www4.cenpos.net/webpaytest/v7/html5/';
}

else if ( 'prod-mia1' == $environment )
{
	$webpay_path = 'https://www.cenpos.net/webpay/v7/html5/';
}

else if ( 'prod-mia2' == $environment )
{
	$webpay_path = 'https://www3.cenpos.net/webpay/v7/html5/';
}

else if ( 'prod-mia3' == $environment )
{
	$webpay_path = 'https://www4.cenpos.net/webpay/v7/html5/';
}

else
{
	$webpay_path = null;
}

// Validate plugin version
if ( ! is_numeric( $plugin ) )
{
	$plugin = null;
}

// Validate file exists
if ( ! file_exists( 'html/'.$testcase ) )
{
	$testcase = null;
}

if ( ! is_null( $webpay_path ) && ! is_null( $plugin ) && !is_null( $testcase ) )
{
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Webpay Test</title>
		<script type="text/javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="//www.cenpos.com/Plugins/porthole.min.js"></script>
		<script type="text/javascript" src="//www.cenpos.com/Plugins/jquery.cenpos.<?php echo $plugin ?>.js"></script>
		<?php include( 'html/'.$testcase ) ?>
		<link rel="stylesheet" href="../../../css/main.css">
	</head>

	<body>
		<div class="layaoutPanel">
			<div id="NewCenposPlugin"></div>
		</div>
	</body>
</html>
<?php
}

else
{
	echo '<h1>Please enter a valid testcase and plugin combination!</h1>';
}
