<script type="text/javascript">
	var params = "type=createtoken19";
		params += "&merchantid=12723488";
		params += "&amount=199.99";
		params += "&email=cenposqatest@gmail.com";
		params += "&customercode=webpay-test-05";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&check=false";
		params += "&currencycode=840";
		params += "&ispresta=true";
		params += "&disabledalert=true";
		params += "&sessionData=HxZNYHU4ObCk3cbt%2ficcoy5K5XLW%2f9Aj%2fU15RhllfBXdDq4JCIuBZAEV4jNtDQ1G5CZI2a4GKdGJNvymCxnVNQ%3d%3d";
		params += "&autologin=false";

	$( document ).ready( function() 
	{
		$( "#NewCenposPlugin" ).createWebpay(
		{
			url: '<?php echo $webpay_path ?>',
			params: params,
			domain: '<?php echo $webpay_path ?>',
			sessionDataPOST: "12723488A23A9-869",
			encrypted: true,
			width: "800",
			height: "750"
	   } );
	} );
</script>
