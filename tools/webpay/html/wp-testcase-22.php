<script type="text/javascript">
	let params = new URLSearchParams();

	params.append('type', 'sale');
	params.append('verifyingpost', '<?= urlencode($response->Data) ?>');
	params.append('check', 'false');
	params.append('urlreturn', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('urlcancel', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('paypal', 'false');
	params.append('addressdif', 'true');
	params.append('currencycode', '840');
	params.append('onlycheck', 'false');
	params.append('disabledalert', 'true');
	params.append('autologin', 'false');

	$(document).ready(() => {
		$("#NewCenposPlugin").createWebpay(
		{
			url: '<?= $webpay_path ?>',
			params: params.toString(),
			domain: '<?= $webpay_path ?>',
			width: "800",
			height: "750"
		});
	});
</script>
