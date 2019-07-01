<?php
// Force HTTPS for added security
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
?>
<html>
<head>
	<title>Integrations Test Tool - QA Tools</title>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="cache-control" content="private">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Tool to test CenPOS integrations">
	<meta name="author" content="Jonathan Estrella">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="robots" content="none">
	<meta name="expires" content="wed, 01 Jan 2030">

	<link rel="icon" sizes="32x32" href="../resources/icons/integ.png" type="image/png">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link rel="stylesheet" href="static/css/main.css">
	<!--<link rel="manifest" href="manifest.json">-->
</head>

<body>
	<div id="loading-container" class="container-fluid">
		<img src="static/img/loading.gif" alt="Loading...">
		<h2>Please bear with me while I get things ready for you!</h2>
	</div>

	<div id="full-container" class="container-fluid d-none">
		<div class="row mt-3 mb-3">
			<div class="col-sm-3">
				<div class="col-sm-8 offset-sm-4">
					<img src="static/img/logo.png" class="img-responsive logo" alt="CenPOS">
				</div>
			</div>

			<div class="col-sm-4">
				<div class="input-group input-group-sm">
					<input type="text" class="form-control form-control-sm" id="query-string-input" placeholder="Enter a query string to get parameters and values from it">
					
					<span class="input-group-append">
						<button class="btn btn-dark" id="query-string-button" type="button">Go!</button>
					</span>
				</div>
			</div>

			<div class="col-sm-5">
				<div class="float-right">
					<a class="btn btn-outline-dark btn-sm" href="../" target="_blank" title="CenPOS QA Tools and Application Links">
						<i class="fas fa-arrow-left mr-1"></i>
						QA Tools
					</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				<div class="form-group row">
					<div class="col-sm-12">
						<button id="integration-loader-button" class="btn btn-dark btn-sm btn-block">Load Object</button>
					</div>
				</div>

				<form class="main-form bg-primary">
					<div class="form-group row">
						<label for="application-select-input" class="col-sm-4 col-form-label col-form-label-sm">Application:</label>

						<div class="col-sm-8">
							<select id="application-select-input" class="form-control form-control-sm"></select>
						</div>
					</div>

					<div class="form-group row">
						<label for="environment-select-input" class="col-sm-4 col-form-label col-form-label-sm">Environment:</label>

						<div class="col-sm-8">
							<select id="environment-select-input" class="form-control form-control-sm"></select>
						</div>
					</div>

					<div class="form-group row">
						<label for="method-select-input" class="col-sm-4 col-form-label col-form-label-sm">Method:</label>

						<div class="col-sm-8">
							<select id="method-select-input" class="form-control form-control-sm">
								<option value="POST">POST</option>
								<option value="GET">GET</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="transaction-select-input" class="col-sm-4 col-form-label col-form-label-sm">Transaction:</label>

						<div class="col-sm-8">
							<select id="transaction-select-input" class="form-control form-control-sm"></select>
						</div>
					</div>
				</form>

				<div>
					<div class="row">
						<div class="col-sm-10">
							<strong>Parameters in use:</strong>
						</div>

						<div class="col-sm-2">
							<div id="clear-used-button" class="param-button">
								<i class="fas fa-minus-circle" title="Clear all currently used parameters."></i>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<form id="form-params-used" class="sortable bg-success form-params"></form>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-10">
							<strong>Parameters available:</strong>
						</div>

						<div class="col-sm-2">
							<div id="help-available-button" class="param-button">
								<i class="fas fa-question-circle" title="Drag the parameters you want to use to the green column above."></i>
							</div>
						</div>
					</div>

					<div class="bg-danger form-params">
						<div class="form-group row filter-params">
							<div class="col-sm-12">
								<input type="text" id="input-filter-params" class="form-control form-control-sm" placeholder="Filter params by...">
							</div>
						</div>

						<form id="form-params-available" class='sortable'></form>
					</div>
				</div>
			</div>

			<div class="col-sm-9">
				<div class="input-group input-group-sm">
					<div class="input-group-prepend">
						<span class="input-group-text">Endpoint:</span>
					</div>

					<input type="text" id="integration-endpoint-input" class="form-control form-control-sm" placeholder="Endpoint will be displayed here" readonly="readonly">
				</div>

				<div class="card mt-3 d-none">
					<div class="card-body">
						<div id="integration-inline-response"></div>
					</div>
				</div>

				<div class="card mt-3 iframe-container">
					<div class="card-body">
						<div id="post-form"></div>

						<div>
							<iframe id="integration-iframe-loader" name="integration-iframe-loader" src="" frameborder="0"></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="static/js/main.js"></script>
</body>
</html>
