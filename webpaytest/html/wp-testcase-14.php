<script type="text/javascript">
	var params = "type=sale";
		params += "&merchantid=10000009";
		params += "&amount=99.99";
		params += "&email=cenposqatest@gmail.com";
		params += "&customercode=webpay-test-14";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&addressdif=true";
		params += "&check=true";
		params += "&onlycheck=true";
		params += "&paypal=false";
		params += "&currencycode=840";
		//params += "&ispresta=true";
		params += "&disabledalert=true";
		params += "&sessionData=bdC2EixqP0BYEVBDuBLWSDUfn5kGBXnoIav55wqVMd2cgbn%2bGaOQp38yNMirHZohX4J%2fQhGbdjVhSdsNDMQf2g%3d%3d";
		params += "&autologin=false";
		params += "&ischecktype=false";

	$( document ).ready( function()
	{
		$( "#NewCenposPlugin" ).createWebpay(
		{
			url: '<?php echo $webpay_path ?>',
			params: params,
			domain: '<?php echo $webpay_path ?>',
			sessionDataPOST: "10000009CAC-A0E1-A987-54FFA",
			encrypted: true,
			width: "800",
			height: "750"
		} );
	} );
</script>
