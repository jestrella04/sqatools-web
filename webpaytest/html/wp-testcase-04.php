<script type="text/javascript">
	let params = new URLSearchParams();

	params.append('type', 'createtoken');
	params.append('verifyingpost', '<?= urlencode($response->Data) ?>');
	params.append('urlreturn', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('urlcancel', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('check', 'false');
	params.append('paypal', 'false');
	params.append('currencycode', '840');
	params.append('ispresta', 'true');
	params.append('disabledalert', 'true');
	params.append('sessionData', '9FuAKkEDoBy%2f6q%2fQjyHkg3P4CVwzaFtGiergoTtB%2fRS%2bozLLCkY387K93sPfkns01YecRDZTju2z3Zo3m6MQ7g%3d%3d');
	params.append('autologin', 'false');

	$(document).ready(() => {
		$("#NewCenposPlugin").createWebpay(
		{
			url: '<?= $webpay_path ?>',
			params: params.toString(),
			domain: '<?= $webpay_path ?>',
			sessionDataPOST: "12721628A23A9-869",
			encrypted: true,
			width: "800",
			height: "750"
		});
	}); 
</script>
