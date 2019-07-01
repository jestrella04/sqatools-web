<script type="text/javascript">
	var params = "type=sale";
		params += "&verifyingpost=<?php echo urlencode($response->Data)?>";
		params += "&check=false";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&paypal=false";
		params += "&addressdif=true";
		params += "&currencycode=840";
		params += "&onlycheck=false";
		params += "&disabledalert=true";
		params += "&autologin=false";

	$( document ).ready( function()
	{
		$( "#NewCenposPlugin" ).createWebpay(
		{
			url: '<?php echo $webpay_path ?>',
			params: params,
			domain: '<?php echo $webpay_path ?>',
			width: "800",
			height: "750"
		} );
	} );
</script>
