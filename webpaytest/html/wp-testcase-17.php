<script type="text/javascript">
	var params = "type=auth";
		params += "&merchantid=12721628";
		params += "&amount=22.50";
		params += "&email=cenposqatest@gmail.com";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&check=false";
		params += "&paypal=false";
		params += "&currencycode=840";
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
			height: "750",
			success: CallbackSuccess,
			cancel: CallbackCancel
		} );
	} );
	
	function CallbackSuccess( data )
	{
		callbackReal(data, 'JSON', '');
	}

	function CallbackCancel(data)
	{
		callbackReal(data, 'STRING', '');
	}

	function callbackReal(data, type, src)
	{
		var str = '<strong>' + type + '</strong><hr class="hr-xs"><pre><code>' + JSON.stringify(data, undefined, 2) + '</code></pre>';

		top.$('#webpay-response').empty();
		top.$('#webpay-response').append(str);
		top.$('#webpay-response').show();
		top.$('#webpay').attr('src', src);
	}
</script>
