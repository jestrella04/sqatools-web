<script type="text/javascript">
	var params = "";
	
	params += "merchantid=12721627";
	params += "&email=cenposqatest@gmail.com";
	params += "&customercode=swp021";
	params += "&address=9048";
	params += "&zipcode=33189";
	params += "&isemail=true";
	params += "&iscvv=true";
	
	$(document).ready(function()
	{
		$("#NewCenposPlugin").createWebpay(
		{
			url: '<?php echo $webpay_path ?>',
			params: params,
			width: "500",
			height: "450",
			sessionToken: false,
			success: formatResponse,
			cancel: formatResponse
		});
		
		$("#submit").on('click', function() 
		{
			$("#NewCenposPlugin").submitAction();
		});
	});
	
	function formatResponse(data)
	{
		var str = '<pre><code>' + JSON.stringify(data, undefined, 2) + '</code></pre>';

		top.$('#webpay-response').empty();
		top.$('#webpay-response').append(str);
	}
</script>