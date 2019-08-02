<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Webpay test manager">
		<meta name="author" content="Jonathan Estrella">

		<title>Integrations Response Analyzer - QA Tools</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<style type="text/css">
			pre{border: 0; background-color: transparent;}
			.hr-xs{margin:7px 0;}
			ul{word-wrap: break-word;}
		</style>
	</head>

	<body>

<?php
$dataPost = file_get_contents("php://input");
$dataGet = $_GET;

if ( isset( $dataPost ) && ! empty( $dataPost ) )
{
	$data = $dataPost;
	$dataType = "POST";
}

elseif ( isset( $dataGet ) && ! empty( $dataGet ) )
{
	$data = $dataGet;
	$dataType = "GET";
}

if ( $data )
{
	echo '<strong>'. $dataType .'</strong><hr class="hr-xs">';

	@$xml = simplexml_load_string( $data );
	@$json = json_decode( $data );

	if ( is_object( $xml ) )
	{
		//Format XML to save indented tree rather than one line
		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());

		$outputXML = htmlentities( $dom->saveXML() );
		echo '<pre><code>' . $outputXML . '</code></pre>';
	}
	
	elseif ( is_object( $json ) )
	{
		echo '<pre><code>'. htmlentities( print_r( $json, $return = true ) ) .'</code></pre>';
	}

	elseif ( is_array( $data ) )
	{
		echo '<ul class="list-unstyled">';

		foreach( $data as $param=>$value )
		{
			echo '<li><strong>'.$param.':</strong> '.$value.'</li>';
		}

		echo "</ul>";
	}

	elseif ( ! empty( $data ) )
	{
		echo "Invalid response format, message dump below:<br><br>";
		echo '<pre><code>'. htmlentities( print_r( $data, $return = true ) ) .'</code></pre>';
	}
}
?>

	</body>
</html>