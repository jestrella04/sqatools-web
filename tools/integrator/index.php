<html>

<?php
	$app = [
		'id' => 'integrator',
		'name' => 'Integrator',
		'description' => 'Tool to test CenPOS integrations',
		'logo' => 'integ.png',
		'logo_type' => 'image/png',
		'jquery' => true,
	];

	require '../../resources/views/header.php';
?>

<body id="app-integrator">
	<div id="full-container" class="container-fluid">
		<div class="row">
			<div class="col-sm-3 mt-2">
				<div class="form-group row">
					<div class="col-sm-12">
						<button id="integration-loader-button" class="btn btn-dark btn-sm btn-block">Load Object</button>
					</div>
				</div>

				<form class="main-form bg-primary">
					<div class="form-group row">
						<label for="application-select-input" class="col-sm-4 col-form-label col-form-label-sm">Application:</label>

						<div class="col-sm-8">
							<select id="application-select-input" class="form-control form-control-sm">
								<option value="" selected disabled>--</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="environment-select-input" class="col-sm-4 col-form-label col-form-label-sm">Environment:</label>

						<div class="col-sm-8">
							<select id="environment-select-input" class="form-control form-control-sm">
								<option value="" selected disabled>--</option>
							</select>
						</div>
					</div>

					<div class="form-group row d-none">
						<label for="endpoint-select-input" class="col-sm-4 col-form-label col-form-label-sm">Endpoint:</label>

						<div class="col-sm-8">
							<input id="endpoint-select-input" type="text" class="form-control form-control-sm">
						</div>
					</div>

					<div class="form-group row">
						<label for="method-select-input" class="col-sm-4 col-form-label col-form-label-sm">Method:</label>

						<div class="col-sm-8">
							<select id="method-select-input" class="form-control form-control-sm">
								<option value="" selected disabled>--</option>
								<option value="POST">POST</option>
								<option value="GET">GET</option>
							</select>
						</div>
					</div>

					<div class="form-group row">
						<label for="transaction-select-input" class="col-sm-4 col-form-label col-form-label-sm">Transaction:</label>

						<div class="col-sm-8">
							<select id="transaction-select-input" class="form-control form-control-sm">
								<option value="" selected disabled>--</option>
							</select>
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
								<i class="fas fa-minus-circle" data-content="Clear all currently used parameters." data-toggle="popover"></i>
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
								<i class="fas fa-question-circle" data-content="Drag the parameters you want to use to the green column above. You can also double-click on the desired param name to quickly swap between columns." data-toggle="popover"></i>
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

			<div class="col-sm-9 pl-0 mt-2">
				<div class="input-group input-group-sm">
					<div class="input-group-prepend">
						<span class="input-group-text">Endpoint:</span>
					</div>

					<input type="text" id="integration-endpoint-input" class="form-control form-control-sm" placeholder="Endpoint will be displayed here" readonly="readonly">

					<div class="input-group-append">
						<button class="btn btn-dark" id="query-string-button" type="button" data-toggle="modal" data-target="#query-string-modal">
							<i class="fas fa-edit" aria-hidden="true" data-toggle="popover" data-content="Enter a query string to get parameters and values from it"></i>
						</button>
					</div>
				</div>

				<div class="card mt-2 d-none">
					<div class="card-body">
						<div id="integration-inline-response"></div>
					</div>
				</div>

				<div class="card mt-2 iframe-container">
					<div class="card-body">
						<div id="post-form"></div>
						<div id="NewCenposPlugin" class="d-none"></div>
						<iframe id="integration-iframe-loader" name="integration-iframe-loader" src="" frameborder="0"></iframe>
					</div>
				</div>

				<div id="swp-btns" class="mt-2 d-none">
					<button id="swp-submit" class="btn btn-success">SUBMIT</button>
					<button id="swp-cancel" class="btn btn-danger" disabled>CANCEL</button>
				</div>
			</div>
		</div>
	</div>

	<?php require '../../resources/views/footer.php' ?>

	<div class="modal fade" id="query-string-modal" tabindex="-1" role="dialog" aria-labelledby="queryStringModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Query String Parser</h5>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<textarea class="form-control mb-2" id="query-string-input" rows="5" placeholder="Enter a query string here to get parameters and values from it, then press Enter or click on the load button below..."></textarea>
					<button class="btn btn-primary btn-block" id="query-string-submit" type="button">Load Parameters</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
