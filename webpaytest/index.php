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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Webpay test manager">
		<meta name="author" content="Jonathan Estrella">
		<link rel="icon" href="../resources/icons/web.png">

		<title>Webpay Test Tool - QA Tools</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<style type="text/css">
			.padding{padding:1em 1em 0;}
			#webpay-container{margin-top:1em; padding:1em; border: 1px solid #ddd; border-radius: 3px;}
			#webpay{width:100%; min-height: 800px; border:0;}
			#alert{position:absolute; top: 3em; right:35%; margin: 3em auto; width: 30%; display: none; text-align: center;}
			#script{display: none; position:absolute;}
			#webpay-url-container{margin-top:1em;}
			#webpay-response{display:none;}
			pre{border: 0; background-color: transparent;}
			.hr-xs{margin:7px 0;}
		</style>
	</head>

	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2">
					<div class="padding">
						<form class="form-horizontal">
							<div class="form-group form-group-sm">
								<select class="form-control" id="server">
									<option value=""> ------ Please select server ------ </option>
									<option value="prod-mia3">Production</option>
									<option value="prod-test">Staging</option>
								</select>
							</div>

							<div class="form-group form-group-sm">
								<select class="form-control" id="plugin">
									<option value=""> ------ Please select plugin ------ </option>
									<option value="2.3">Version 2.3</option>
									<option value="2.2">Version 2.2</option>
									<option value="3.2">Version 3.2 (Temp)</option>
								</select>
							</div>
						</form>
					</div>

					<div class="list-group">
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-00">TC-00 <small class="text-muted">(Sale)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-01">TC-01 <small class="text-muted">(Auth)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-02">TC-02 <small class="text-muted">(Auth19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-03">TC-03 <small class="text-muted">(Sale19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-04">TC-04 <small class="text-muted">(CreateToken)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-05">TC-05 <small class="text-muted">(CreateToken19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-06">TC-06 <small class="text-muted">(Sale)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-07">TC-07 <small class="text-muted">(Auth)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-08">TC-08 <small class="text-muted">(Sale19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-09">TC-09 <small class="text-muted">(Auth19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-10">TC-10 <small class="text-muted">(CreateToken19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-11">TC-11 <small class="text-muted">(Auth)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-12">TC-12 <small class="text-muted">(Sale - OnlyCheck)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-13">TC-13 <small class="text-muted">(CreateToken - Check)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-14">TC-14 <small class="text-muted">(Sale - OnlyCheck)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-15">TC-15 <small class="text-muted">(Sale19)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-16">TC-16 <small class="text-muted">(Sale - Callback)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-17">TC-17 <small class="text-muted">(Auth - Callback)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-18">TC-18 <small class="text-muted">(Auth19 - Callback)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-19">TC-19 <small class="text-muted">(Sale19 - Callback)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-20">TC-20 <small class="text-muted">(CreateToken - Callback)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-21">TC-21 <small class="text-muted">(CreateToken19 - Callback)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-22">TC-22 <small class="text-muted">(Sale - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-23">TC-23 <small class="text-muted">(Auth - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-24">TC-24 <small class="text-muted">(Auth19 - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-25">TC-25 <small class="text-muted">(Sale19 - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-26">TC-26 <small class="text-muted">(CreateToken - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-27">TC-27 <small class="text-muted">(CreateToken19 - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay-verify.php" id="wp-testcase-28">TC-28 <small class="text-muted">(CreateToken19 - Verify)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-29">TC-29 <small class="text-muted">(Sale - Passwordless)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-30">TC-30 <small class="text-muted">(Auth - Passwordless)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-31">TC-31 <small class="text-muted">(Auth19 -Passwordless)</small></a>
						<a href="#" class="list-group-item" data-urlwebpay="webpay.php" id="wp-testcase-32">TC-32 <small class="text-muted">(Sale19 - Passwordless)</small></a>
					</div>
				</div>

				<div class="col-sm-10">
					<div class="alert alert-danger" role="alert" id="alert">
						<button type="button" class="close">
							<span aria-hidden="true">&times;</span>
						</button>

						<strong>Please select a server and plugin version</strong>
					</div>

					<form class="form">
						

						<div class="form-group form-group-sm" id="webpay-url-container">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-console" aria-hidden="true" data-toggle="modal" data-target="#script-source-modal" title="View script source"></span>
								</span>
								<input type="text" id="webpay-url" class="form-control" placeholder="Loaded Webpay URL will be shown here" readonly="readonly">
							</div>
						</div>
					</form>

					<div id="webpay-container">
						<div id="webpay-response"></div>
						<iframe id="webpay"></iframe>
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

		<script type="text/javascript" src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script type="text/javascript">
			$( document ).ready( function()
			{
				$( '[data-toggle="tooltip"]' ).tooltip();

				$( '.close' ).on( 'click', function()
				{
					$( '#alert' ).hide();
				} );

				$( '.list-group-item' ).on( 'click', function()
				{
					var server = $('#server').val();
					var plugin = $('#plugin').val();
					var file = $(this).attr('id');
					var webpayPhp = $(this).attr('data-urlwebpay');

					$( '#alert' ).hide();
					$( '#script' ).hide();
					$( '#webpay-response' ).hide();
					$( '.list-group-item' ).removeClass( "list-group-item-info" );
					$( this ).addClass( "list-group-item-info" );
					$( '#webpay-url' ).val( "" );

					if ( "" == server || "" == plugin )
					{
						$( '#alert' ).show();
					}

					else
					{
						var paramsUrl = "html/" + file + ".php";
						var urlBase = document.URL.substr( 0, document.URL.lastIndexOf( '/' ) );
						var urlTail = webpayPhp + "/" + server + "/" + plugin + "/" + file + ".html";
						var url = urlBase + "/" + urlTail;

						$.get(paramsUrl, function( data ) {
						  $("#script-source-body").text(data);
						});

						$( '#script' ).show();
						$( '#webpay' ).attr( 'src', urlTail );
						$( '#webpay-url' ).val( url );
					}
				} );
			} );
		</script>
	</body>
</html>
