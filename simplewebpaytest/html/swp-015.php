<script type="text/javascript">
	var params = "";

	params += "verifyingpost=<?= urlencode($response->Data) ?>";
	params += "&customercode=swp001";
	params += "&address=9048";
	params += "&zipcode=33189";
	params += "&isemail=false";
	params += "&iscvv=false";

	$(document).ready(function()
	{
		$("#NewCenposPlugin").createWebpay(
		{
			url: '<?= $webpay_path ?>',
			params: params,
			width: "500",
			height: "450",
			sessionToken: true,
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
