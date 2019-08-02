<script type="text/javascript">
	var params = "type=sale";
		params += "&merchantid=12721628";
		params += "&amount=235.75";
		params += "&email=cenposqatest@gmail.com";
		params += "&customercode=webpay-test-06";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&check=false";
		params += "&paypal=false";
		params += "&disabledalert=true";
		params += "&sessionData=9FuAKkEDoBy%2f6q%2fQjyHkg3P4CVwzaFtGiergoTtB%2fRS%2bozLLCkY387K93sPfkns01YecRDZTju2z3Zo3m6MQ7g%3d%3d";
		params += "&autologin=false";

	$( document ).ready( function() 
	{
		$( "#NewCenposPlugin" ).createWebpay(
		{
			url: '<?php echo $webpay_path ?>',
			params: params,
			domain: '<?php echo $webpay_path ?>',
			sessionDataPOST: "12721628A23A9-869",
			encrypted: true,
			width: "800",
			height: "750"
		} );
	} );
</script>
