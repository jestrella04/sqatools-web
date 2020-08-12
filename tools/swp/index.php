<!DOCTYPE html>
<html lang="en">

<?php
	$app = [
		'id' => 'swp',
		'name' => 'Simple Webpay Tester',
		'description' => 'Simple Webpay tester application',
		'logo' => 'web.png',
		'logo_type' => 'image/png',
		'jquery' => true,
	];

	require '../../resources/views/header.php';
?>

<body id="app-swp">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<div class="form-group mt-2 mb-0">
					<select class="form-control form-control-sm custom-select" id="server">
						<option value="" selected disabled> ------ Server ------ </option>
						<option value="miami3">Production</option>
						<option value="staging">Staging</option>
					</select>
				</div>

				<div class="form-group my-2">
					<select class="form-control form-control-sm custom-select" id="plugin">
						<option value="" selected disabled> ------ Plugin ------ </option>
						<option value="iframe">Iframe</option>
						<option value="object">Object</option>
					</select>
				</div>

				<div class="form-group my-2">
					<select class="form-control form-control-sm custom-select" id="recaptcha">
						<option value="" selected disabled> ------ Recaptcha ------ </option>
						<option value="disabled">Disabled</option>
						<option value="v2">v2</option>
						<option value="v3">v3</option>
					</select>
				</div>

				<div id="swp-list-group" class="list-group">
					<a href="#" class="list-group-item swp-testcase" id="swp-001" data-targeturl="standard">swp-001 <small class="text-muted">(Regular)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-002" data-targeturl="standard">swp-002 <small class="text-muted">(Basic)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-003" data-targeturl="standard">swp-003 <small class="text-muted">(Email + CVV)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-004" data-targeturl="verify">swp-004 <small class="text-muted">(Regular + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-005" data-targeturl="verify">swp-005 <small class="text-muted">(Basic + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-006" data-targeturl="verify">swp-006 <small class="text-muted">(Email + CVV + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-007" data-targeturl="verify">swp-007 <small class="text-muted">(CVV + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-008" data-targeturl="verify">swp-008 <small class="text-muted">(Email + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-009" data-targeturl="ach+verify">swp-009 <small class="text-muted">(Checks + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-010" data-targeturl="verify+token19">swp-010 <small class="text-muted">(Token19 + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-011" data-targeturl="verify+token19">swp-011 <small class="text-muted">(Token19 + Email + CVV + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-012" data-targeturl="verify+token19">swp-012 <small class="text-muted">(Token19 + CVV + Verify)</small></a>
					<a href="#" class="list-group-item swp-testcase" id="swp-013" data-targeturl="verify+token19">swp-013 <small class="text-muted">(Token19 + Email + Verify)</small></a>
				</div>
			</div>

			<div class="col-sm-10 pl-0">
				<div class="form-group my-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<button type="button" class="btn btn-sm" id="script" data-toggle="modal" data-target="#script-source-modal" disabled>
								<i class="fas fa-code" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="View plugin parameters used"></i>
							</button>
						</div>

						<input type="text" id="webpay-url" class="form-control" placeholder="Loaded Webpay URL will be shown here" readonly="readonly">
					</div>
				</div>

				<div class="alert alert-danger d-none" role="alert" id="alert">
					<a href="#" class="close alert-link">&times;</a>

					<strong>Please enter required params</strong>
				</div>

				<div class="row" id="webpay-container">
					<div class="col-sm-7">
						<iframe id="webpay"></iframe>
					</div>

					<div class="col-sm-5" id="webpay-response"></div>
				</div>
			</div>
		</div>
	</div>

	<?php require '../../resources/views/footer.php' ?>

	<div class="modal fade" id="script-source-modal" tabindex="-1" role="dialog" aria-labelledby="scriptSourceModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<pre id="script-source-body"></pre>
				</div>
			</div>
		</div>
	</div>
</body>
</html>