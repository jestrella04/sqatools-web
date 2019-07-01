<script type="text/javascript">
	var params = "type=sale19";
		params += "&verifyingpost=<?php echo urlencode($response->Data)?>";
		params += "&customercode=webpay-test-25";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&addressdif=true";
		params += "&check=false";
		params += "&paypal=false";
		params += "&currencycode=840";
		params += "&ispresta=true";
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
