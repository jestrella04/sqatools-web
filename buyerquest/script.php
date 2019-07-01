<script type="text/javascript">
    var data = JSON.stringify(sendRequest);

	$(document).ready(function()
	{
		createWebpay();
	});

	function createWebpay(){
		$("#NewCenposPlugin").createWebpay(
		{
			url: '<?= $webpay_final_path ?>',
			data: data,
			width: "500",
			height: "600",
			success: CallbackSuccess,
			cancel: CallbackCancel
		});
	}

	function formatResponse(data)
	{
		var str = '<pre><code>' + JSON.stringify(data, undefined, 2) + '</code></pre>';

		top.$('#webpay-response').empty();
		top.$('#webpay-response').append(str);
	}

	function CallbackSuccess(data)
	{
		formatResponse(data);
	}

	function CallbackCancel(data)
	{
		formatResponse(data);
	}
</script>