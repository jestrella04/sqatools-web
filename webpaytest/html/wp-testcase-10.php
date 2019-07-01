<script type="text/javascript">
	var params = "type=createtoken19";
		params += "&merchantid=12720998";
		params += "&amount=500.99";
		params += "&email=cenposqatest@gmail.com";
		params += "&customercode=webpay-test-10";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&check=false";
		params += "&paypal=false";
		params += "&currencycode=840";
		params += "&ispresta=false";
		params += "&disabledalert=true";
		params += "&sessionData=f0QYZm6rXVXG%2fbcCEfCZlsTW2RwCFgk3Q2mNBPxMohlQYhGYEKXccoVeXKOvcX25tPiPFcpkSAqeS4C1mfFRcA%3d%3d";
		params += "&autologin=false";

	$( document ).ready( function() 
	{
		$( "#NewCenposPlugin" ).createWebpay(
		{
			url: '<?php echo $webpay_path ?>',
			params: params,
			domain: '<?php echo $webpay_path ?>',
			sessionDataPOST: "127209987D5-8FBD-2ABE-8",
			encrypted: true,
			width: "800",
			height: "750"
		} );
	} );
</script>
