<?php
require('logger.php');

$dataPost = file_get_contents("php://input");
$dataGet = $_GET;
$data = null;
$dataType = "";
$op = "";

if (isset($dataPost) && ! empty($dataPost))
{
	$data = $dataPost;
	$dataType = "POST";
}

elseif (isset($dataGet) && ! empty($dataGet))
{
	$data = $dataGet;
	$dataType = "GET";
}

if ($data)
{
	@$xml = simplexml_load_string($data);
	@$json = json_decode($data);

	if (is_object($xml))
	{
		//Format XML to save indented tree rather than one line
		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml->asXML());

		$op = htmlentities($dom->saveXML());
		$op = '<pre><code>'. $op .'</code></pre>'. PHP_EOL;
	}
	
	elseif (is_object($json))
	{
		$op = htmlentities(print_r($json, $return = true));
		$op = '<pre><code>'. $op .'</code></pre>'. PHP_EOL;
	}

	elseif (is_array($data))
	{
		$op = '<ul class="list-unstyled">'. PHP_EOL;

		foreach($data as $param=>$value)
		{
			$op .= '	<li><strong>'.$param.':</strong> '.$value.'</li>'. PHP_EOL;
		}

		$op .= '</ul>'. PHP_EOL;
	}

	elseif (! empty($data))
	{
		$op = htmlentities(print_r($data, $return = true));
		$op = '<pre><code>'. $op .'</code></pre>'. PHP_EOL;
	}

    // Lets now log the response
    logResponse($dataType, $op);
}

// Output HTML
?>

<div id="response-analyzer-view">
    <p class="lead">
        <?= $dataType ?>
    </p>

    <hr class="hr-xs">

    <div class="response-dump">
        <?= $op ?>
	</div>
	
	<div class="response-log">
		<a href="tools/integrator/getresponse/index.php/view" target="_blank" class="btn btn-light btn-sm">View Log</a>
	</div>
</div>
