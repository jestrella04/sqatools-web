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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Simple Webpay test manager">
		<meta name="author" content="Jonathan Estrella">
		<link rel="icon" href="../integrator/assets/img/favicon.png">

		<title>Buyer Quest Test Tool - CenPOS QA Tools</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<style type="text/css">
			#webpay-container{margin: 0; padding: 1em; border: 1px solid #ddd; border-radius: 3px;}
			#webpay{width:100%; min-height: 750px; border:0;}
			#alert{z-index:9999; position:absolute; top: 3em; right:35%; margin: 3em auto; width: 30%; display: none; text-align: center;}
			#script{display: none; position:absolute;}
			#main-form{padding:0.6rem; border-radius: 5px; margin: 1rem auto;}
			.col-form-label{font-weight:700}
			small{color: darkgray;}
			.list-group .active small{color: darkblue;}
		</style>
	</head>

	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<div id="main-form" class="bg-success">
						<div id="form-params"></div>
					</div>

					<div id="main-items">
						<div class="list-group">
							<a href="#" class="list-group-item list-group-item-action" id="bq-001">BQ001 <small>(Basic)</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-002">BQ002 <small>(Big Amount)</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-003">BQ003 <small>(Multiple Invoices)</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-004">BQ004 <small>(Several Invoices)</small></a>
							<!--<a href="#" class="list-group-item list-group-item-action" id="bq-005">BQ005 <small>()</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-006">BQ006 <small>()</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-007">BQ007 <small>()</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-008">BQ008 <small>()</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-009">BQ009 <small>()</small></a>
							<a href="#" class="list-group-item list-group-item-action" id="bq-010">BQ010 <small>()</small></a>-->
						</div>
					</div>
				</div>

				<div class="col-sm-10">
					<div class="form-group">
						<div class="input-group mt-3 mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">URL</span>
							</div>

							<input type="text" id="webpay-url" class="form-control" placeholder="The BuyerQuest swp URL will be shown here" readonly="readonly">
						</div>
					</div>

					<div class="alert alert-danger" role="alert" id="alert">
						<a href="#" class="close alert-link">&times;</a>

						<strong>Please select a valid environment</strong>
					</div>

					<div class="row" id="webpay-container">
						<div class="col-sm-5">
							<div id="script">
								<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#script-source-modal">
									<span class="glyphicon glyphicon-console" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="View plugin parameters used"></span>
								</a>
							</div>

							<iframe id="webpay"></iframe>
						</div>

						<div class="col-sm-7" id="webpay-response">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="script-source-modal" tabindex="-1" role="dialog" aria-labelledby="scriptSourceModal">
			<div class="modal-dialog" role="document">
		    <div class="modal-content">
					<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>

		      <div class="modal-body">
		        <pre id="script-source-body"></pre>
		      </div>
		    </div>
		  </div>
		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script type="text/javascript">
			$( document ).ready( function()
			{
				$.when(
					$.getJSON("parameters.json")
				).then(function (response) {
					var paramsList = '';

					$.each(response, function (idx, params) {
						$.each(params, function (name, values) {
							console.log(values);
							paramsList += '<div class="form-group form-group-param row">';
							paramsList += '	<label for="param-' + name + '" class="col-sm-4 col-form-label col-form-label-sm">' + name + ':</label>';
							paramsList += '	<div class="col-sm-8">';

							if (1 == values.length && 0 == values[0].length) {
								paramsList += '		<input type="text" id="param-' + name + '" class="integrator-param form-control form-control-sm">';
							} else {
								paramsList += '		<select id="param-' + name + '" class="integrator-param form-control form-control-sm">';

								$.each(values, function (idx, option) {
									paramsList += '			<option value="' + option + '">' + option + '</option>';
								});

								paramsList += '		</select>';
							}

							paramsList += '	</div>';
							paramsList += '</div>';
						});

						$('#form-params').append(paramsList);
					});
				});

				$('[data-toggle="tooltip"]').tooltip();

				$('.close').on('click', function() {
					$('#alert').hide();
				});

				$('.list-group-item').on('click', function() {
					var server = $('#param-env').val();
					var file = $(this).attr('id');
					var options = '';

					if ('' !== $('#param-style').val()) options = options + $('#param-style').val();
					if ('false' == $('#param-recaptcha').val()) options = options + '+' + 'norecaptcha';
					if ('false' == $('#param-submit').val()) options = options + '+' + 'nosubmit';
					if ('false' == $('#param-cvv').val()) options = options + '+' + 'nocvv';

					$('#alert').hide();
					$('#script').hide();
					$('#webpay').empty();
					$('#webpay-response').empty();
					$('.list-group-item').removeClass("active");
					$(this).addClass("active");
					$('#webpay-url').val("");

					if ('' == options) {
						$( '#alert' ).show();
					} else {
						var paramsUrl = "html/" + file + ".php";
						var urlBase = document.URL.substr(0, document.URL.lastIndexOf('/'));
						var urlTail = "swp.php/" + server + "/" + options + "/" + file + ".php";
						var url = urlBase + "/" + urlTail;

						$.get(paramsUrl, function(data) {
						  $("#script-source-body").text(data);
						});

						$('#script').show();
						$('#webpay').attr('src', urlTail);
						$('#webpay-url').val(url);
					}
				});
			});
		</script>
	</body>
</html>
