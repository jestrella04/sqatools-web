<script type="text/javascript">
	let params = new URLSearchParams();

	params.append('type', 'sale');
	params.append('verifyingpost', '<?= urlencode($response->Data) ?>');
	params.append('urlreturn', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('urlcancel', 'https%3A//staging.cenpos.com/qatools/integrator/getresponse/');
	params.append('addressdif', 'true');
	params.append('check', 'true');
	params.append('onlycheck', 'true');
	params.append('paypal', 'false');
	params.append('currencycode', '840');
	//params.append('ispresta', 'true');
	params.append('disabledalert', 'true');
	params.append('sessionData', 'bdC2EixqP0BYEVBDuBLWSDUfn5kGBXnoIav55wqVMd2cgbn%2bGaOQp38yNMirHZohX4J%2fQhGbdjVhSdsNDMQf2g%3d%3d');
	params.append('autologin', 'false');
	params.append('ischecktype', 'false');

	$(document).ready(() => {
		$("#NewCenposPlugin").createWebpay(
		{
			url: '<?= $webpay_path ?>',
			params: params.toString(),
			domain: '<?= $webpay_path ?>',
			sessionDataPOST: "10000009CAC-A0E1-A987-54FFA",
			encrypted: true,
			width: "800",
			height: "750"
		});
	});
</script>
