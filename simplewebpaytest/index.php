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

		<title>Simple Webpay Test Tool - QA Tools</title>
		<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<style type="text/css">
			#webpay-container{margin: 0; padding: 1em; border: 1px solid #ddd; border-radius: 3px;}
			#webpay{width:100%; min-height: 750px; border:0;}
			#alert{z-index:9999; position:absolute; top: 3em; right:35%; margin: 3em auto; width: 30%; display: none; text-align: center;}
			#script{display: none; position:absolute;}
			.list-group-item{padding: 0.3rem 0.7rem;}
		</style>
	</head>

	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<div class="form-group mt-3">
						<select class="form-control" id="server">
							<option value=""> ------ Please select server ------ </option>
							<option value="miami3">Production</option>
							<option value="staging">Staging</option>
						</select>
					</div>

					<div class="form-group mt-3">
						<select class="form-control" id="plugin">
							<option value=""> ------ Please select plugin ------ </option>
							<option value="iframe">Iframe</option>
							<option value="object">Object</option>
						</select>
					</div>

					<div class="list-group">
						<a href="#" class="list-group-item list-group-item-action" id="swp-001" data-targeturl="standard">swp-001 <small class="text-muted">(Regular)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-002" data-targeturl="standard">swp-002 <small class="text-muted">(Basic)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-003" data-targeturl="standard">swp-003 <small class="text-muted">(Email+CVV)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-004" data-targeturl="standard">swp-004 <small class="text-muted">(CVV)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-005" data-targeturl="standard">swp-005 <small class="text-muted">(Email)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-006" data-targeturl="ach">swp-006 <small class="text-muted">(Checks)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-007" data-targeturl="verify">swp-007 <small class="text-muted">(Regular + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-008" data-targeturl="verify">swp-008 <small class="text-muted">(Basic + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-009" data-targeturl="verify">swp-009 <small class="text-muted">(Email + CVV + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-010" data-targeturl="verify">swp-010 <small class="text-muted">(CVV + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-011" data-targeturl="verify">swp-011 <small class="text-muted">(Email + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-012" data-targeturl="ach+verify">swp-012 <small class="text-muted">(Checks + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-013" data-targeturl="verify+norecaptcha">swp-013 <small class="text-muted">(Regular + Verify + No Recaptcha)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-014" data-targeturl="ach+verify+norecaptcha">swp-014 <small class="text-muted">(Checks + Verify + No Recaptcha)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-015" data-targeturl="verify+token19">swp-015 <small class="text-muted">(Token19 + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-016" data-targeturl="verify+token19">swp-016 <small class="text-muted">(Token19 + Email + CVV + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-017" data-targeturl="verify+token19">swp-017 <small class="text-muted">(Token19 + CVV + Verify)</small></a>
						<a href="#" class="list-group-item list-group-item-action" id="swp-018" data-targeturl="verify+token19">swp-018 <small class="text-muted">(Token19 + Email + Verify)</small></a>
					</div>
				</div>

				<div class="col-sm-10">
					<div class="form-group">
						<div class="input-group mt-3 mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">URL</span>
							</div>

							<input type="text" id="webpay-url" class="form-control" placeholder="Loaded Webpay URL will be shown here" readonly="readonly">
						</div>
					</div>

					<div class="alert alert-danger" role="alert" id="alert">
						<a href="#" class="close alert-link">&times;</a>

						<strong>Please select a valid environment and plugin</strong>
					</div>

					<div class="row" id="webpay-container">
						<div class="col-sm-7">
							<div id="script">
								<a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#script-source-modal">
									<span class="glyphicon glyphicon-console" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="View plugin parameters used"></span>
								</a>
							</div>

							<iframe id="webpay"></iframe>
						</div>

						<div class="col-sm-5" id="webpay-response">
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

		<script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script type="text/javascript">
			$( document ).ready( function()
			{
				$('[data-toggle="tooltip"]').tooltip();

				$('.close').on('click', function() {
					$('#alert').hide();
				});

				$('.list-group-item').on('click', function() {
					var server = $('#server').val();
					var plugin = $('#plugin').val();
					var file = $(this).attr('id');
					var options = $(this).attr('data-targeturl');

					if ("object" == plugin) {
						options = options + "+object";
					}

					$('#alert').hide();
					$('#script').hide();
					$('#webpay').empty();
					$('#webpay-response').empty();
					$('.list-group-item').removeClass("list-group-item-primary");
					$(this).addClass("list-group-item-primary");
					$('#webpay-url').val("");

					if ("" == server || "" == plugin) {
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
