<!DOCTYPE html>
<html lang="en">

<?php
	$app = [
		'id' => 'webpay',
		'name' => 'Webpay Tester',
		'description' => 'Webpay tester application',
		'logo' => 'web.png',
		'logo_type' => 'image/png',
		'jquery' => true,
	];

	require '../../resources/views/header.php';
?>

<body id="app-webpay">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<div class="form-group mt-2 mb-0">
					<select class="form-control form-control-sm" id="server">
						<option value="" selected disabled>--- Environment ---</option>
						<option value="production">Production</option>
						<option value="staging">Staging</option>
					</select>
				</div>

				<div class="form-group mt-2 mb-2">
					<select class="form-control form-control-sm" id="plugin">
						<option value="" selected disabled>--- Plugin ---</option>
						<option value="2.3">Version 2.3</option>
					</select>
				</div>

				<div class="form-group mt-2 mb-2">
					<select class="form-control form-control-sm" id="integrated">
						<option value="" selected disabled>--- Integration ---</option>
						<option value="false">Disabled</option>
						<option value="true">Enabled</option>
					</select>
				</div>

				<div class="form-group mt-2 mb-2 integration d-none">
					<input type="number" class="form-control form-control-sm" id="amount" placeholder="Enter an amount" autocomplete="off" step="0.01">
				</div>

				<div class="form-group mt-2 mb-2 integration d-none">
					<input type="text" class="form-control form-control-sm" id="client-id" placeholder="Enter a client id" autocomplete="off">
				</div>

				<div class="form-group mt-2 mb-2 integration d-none">
					<input type="email" class="form-control form-control-sm" id="email" placeholder="Enter an email" autocomplete="off">
				</div>

				<div class="form-group mt-2 mb-2 integration d-none">
					<input type="text" class="form-control form-control-sm" id="invoice" placeholder="Enter an invoice" autocomplete="off">
				</div>

				<div class="form-group mt-2 mb-2 integration d-none">
					<input type="text" class="form-control form-control-sm" id="address" placeholder="Enter an address" autocomplete="off">
				</div>

				<div class="form-group mt-2 mb-2 integration d-none">
					<input type="text" class="form-control form-control-sm" id="zip" placeholder="Enter a zip code" autocomplete="off">
				</div>

				<div class="list-group webpay-list-group">
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-00" data-merchantid="12721628">TC-00 <small class="text-muted">(Sale)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-01" data-merchantid="12721628">TC-01 <small class="text-muted">(Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-02" data-merchantid="12721628">TC-02 <small class="text-muted">(Auth19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-03" data-merchantid="12721628">TC-03 <small class="text-muted">(Sale19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-04" data-merchantid="12721628">TC-04 <small class="text-muted">(CreateToken)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-05" data-merchantid="12721628">TC-05 <small class="text-muted">(CreateToken19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-06" data-merchantid="12721628">TC-06 <small class="text-muted">(Sale)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-07" data-merchantid="12721628">TC-07 <small class="text-muted">(Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-08" data-merchantid="12721628">TC-08 <small class="text-muted">(Sale19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-09" data-merchantid="12721628">TC-09 <small class="text-muted">(Auth19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-10" data-merchantid="12721628">TC-10 <small class="text-muted">(CreateToken19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-11" data-merchantid="12721628">TC-11 <small class="text-muted">(Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-12" data-merchantid="10000009">TC-12 <small class="text-muted">(Sale - OnlyCheck)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-13" data-merchantid="10000009">TC-13 <small class="text-muted">(CreateToken - Check)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-14" data-merchantid="10000009">TC-14 <small class="text-muted">(Sale - OnlyCheck)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-15" data-merchantid="12721628">TC-15 <small class="text-muted">(Sale19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-16" data-merchantid="12721628">TC-16 <small class="text-muted">(Sale - Callback)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-17" data-merchantid="12721628">TC-17 <small class="text-muted">(Auth - Callback)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-18" data-merchantid="12721628">TC-18 <small class="text-muted">(Auth19 - Callback)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-19" data-merchantid="12721628">TC-19 <small class="text-muted">(Sale19 - Callback)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-20" data-merchantid="12721628">TC-20 <small class="text-muted">(CreateToken - Callback)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-21" data-merchantid="12721628">TC-21 <small class="text-muted">(CreateToken19 - Callback)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-22" data-merchantid="12721628">TC-22 <small class="text-muted">(Sale)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-23" data-merchantid="12721628">TC-23 <small class="text-muted">(Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-24" data-merchantid="12721628">TC-24 <small class="text-muted">(Auth19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-25" data-merchantid="12721628">TC-25 <small class="text-muted">(Sale19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-26" data-merchantid="12721628">TC-26 <small class="text-muted">(CreateToken)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-27" data-merchantid="12721628">TC-27 <small class="text-muted">(CreateToken19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-28" data-merchantid="12721628">TC-28 <small class="text-muted">(CreateToken19)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-29" data-merchantid="400000614">TC-29 <small class="text-muted">(Sale - Legacy Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-30" data-merchantid="400000614">TC-30 <small class="text-muted">(Auth - Legacy Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-31" data-merchantid="400000614">TC-31 <small class="text-muted">(Auth19 - Legacy Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-32" data-merchantid="400000614">TC-32 <small class="text-muted">(Sale19 - Legacy Auth)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-33" data-merchantid="400004236">TC-33 <small class="text-muted">(Sale - Virgin Merchant)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-34" data-merchantid="400004236">TC-34 <small class="text-muted">(Auth - Virgin Merchant)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-35" data-merchantid="400004236">TC-35 <small class="text-muted">(CreateToken - Virgin Merchant)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-36" data-merchantid="400004236">TC-36 <small class="text-muted">(Sale19 - Virgin Merchant)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-37" data-merchantid="400004236">TC-37 <small class="text-muted">(Auth19 - Virgin Merchant)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-38" data-merchantid="400004236">TC-38 <small class="text-muted">(CreateToken19 - Virgin Merchant)</small></a>
					<a href="#" class="list-group-item list-group-item-action" id="wp-testcase-39" data-merchantid="400004236">TC-39 <small class="text-muted">(OnlyCheck - Virgin Merchant)</small></a>
				</div>
			</div>

			<div class="col-sm-10 pl-0">
				<div class="form-group mt-2 mb-2">
					<input type="text" id="webpay-url" class="form-control form-control-sm" placeholder="The selected testcase URL will be displayed here." readonly="readonly">
				</div>

				<div class="alert alert-danger d-none" role="alert" id="alert">
					<button type="button" class="close">
						<span aria-hidden="true">&times;</span>
					</button>

					<strong>Please enter required params</strong>
				</div>

				<div id="webpay-container">
					<div id="webpay-response" class="d-none"></div>
					<iframe id="webpay"></iframe>
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