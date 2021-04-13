<script type="text/javascript">
	var params = "";
	
	params += "merchantid=wR476sD9f0B9ecI0%2FzPOWQ%3D%3D";
	params += "&email=cenposqatest@gmail.com";
	params += "&customercode=swp001";
	params += "&address=1307 Broad Hollow Road";
	params += "&zipcode=761115307";
	params += "&isemail=false";
	params += "&iscvv=false";
	
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
		
		$(".swp-btn").on('click', function(e) 
		{
			if (e.target.id == 'submit') {
				$("#NewCenposPlugin").submitAction();
			}
		});
	});

	function formatResponse(data)
	{
		var str = '<pre><code>' + JSON.stringify(data, undefined, 2) + '</code></pre>';

		if (data !== 'Error in Form') top.$('#webpay').attr('src', '');
		top.$('#webpay-response').empty();
		top.$('#webpay-response').append(str);
	}
</script>