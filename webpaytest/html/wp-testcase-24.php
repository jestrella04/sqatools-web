<script type="text/javascript">
	let params = new URLSearchParams();

	params.append('type', 'auth');
	params.append('verifyingpost', '<?= urlencode($response->Data) ?>');
	params.append('urlreturn', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('urlcancel', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('check', 'false');
	params.append('paypal', 'false');
	params.append('currencycode', '840');
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
