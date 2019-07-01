<script type="text/javascript">
	var params = "type=createtoken";
		params += "&merchantid=12723488";
		params += "&amount=35.50";
		params += "&email=cenposqatest@gmail.com";
		params += "&customercode=webpay-test-04";
		params += "&urlreturn=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&urlcancel=https%3A//staging.cenpos.com/qatools/integrator/getresponse/";
		params += "&check=false";
		params += "&paypal=false";
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
