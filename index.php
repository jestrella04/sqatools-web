<!DOCTYPE html>
<html lang="en">
	
<?php
	$app = [
		'id' => 'index',
		'name' => 'Application List',
		'description' => 'QA Tools index page',
		'logo' => 'qa.png',
		'logo_type' => 'image/png',
		'jquery' => false,
	];

	require 'resources/views/header.php';
?>

<body id="app-list">
	<div class="container">
		<div class="row title">
			<div class="col-sm-6">
				<h4>QA Tools and Application Links</h4>
			</div>

			<div class="col-sm-6">
				<div class="input-group">
					<input type="text" id="global-filter-input" class="form-control" placeholder="Filter by...">

					<div class="input-group-append">
						<span class="input-group-text" id="global-filter-clear" title="Clear applied filters">
							<i class="fas fa-times"></i>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
			<div class="card">					
					<div class="card-header">
						<div class="card-column-title">
							<div class="float-right">
								<i class="fas fa-toolbox"></i>
							</div>

							SQA Tools
						</div>
					</div>

					<div class="list-group list-group-flush qa-item-group">
						<a class="list-group-item qa-item" target="_blank" href="tools/integrator/">Integrations Test Tool</a>
						<a class="list-group-item qa-item" target="_blank" href="tools/integrator/getresponse/index.php/view?p=1">Integrations Response Analyzer and Logger</a>
						<a class="list-group-item qa-item" target="_blank" href="tools/webpay/">Webpay Test Tool</a>
						<a class="list-group-item qa-item" target="_blank" href="tools/swp/">Simple Webpay Test Tool</a>
						<a class="list-group-item qa-item" target="_blank" href="tools/buyerquest/">BuyerQuest Test Tool</a>
						<a class="list-group-item qa-item" target="_blank" href="tools/randomizer/">Randomizer Test Tool</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/webpay/releaseencrypter/">AES Encrypter (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://development.cenpos.com/magento2.1">Magento Shopping Cart (v2)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://development.cenpos.com/Wordpress_Plugin/shop/">Wordpress WooCommerce</a>
						<a class="list-group-item qa-item" target="_blank" href="http://18.222.110.141:8080/">Jenkins Automation Server</a>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<div class="card-column-title">
							<div class="float-right">
								<i class="fas fa-couch"></i>
							</div>

							Backoffice &amp; Dashboard
						</div>
					</div>

					<div class="list-group list-group-flush qa-item-group">
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/BackOffice/">Backoffice (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/BackOffice/">Backoffice (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/BackOffice/">Backoffice (Mia2)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/BackOffice/">Backoffice (Mia3)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/dashboard/">Dashboard (Elavon Dev)</a>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<div class="card-column-title">
							<div class="float-right">
								<i class="fas fa-cogs"></i>
							</div>

							External Tools
						</div>
					</div>

					<div class="list-group list-group-flush qa-item-group">
						<a class="list-group-item qa-item" target="_blank" href="http://ostermiller.org/calc/encode.html">Base64 and URL Encoding and Decoding</a>
						<a class="list-group-item qa-item" target="_blank" href="http://xmltoolbox.appspot.com/">XmlToolBox - Online XML Formatter</a>
						<a class="list-group-item qa-item" target="_blank" href="https://jsonformatter.curiousconcept.com/">JSON Formatter & Validator</a>
						<a class="list-group-item qa-item" target="_blank" href="https://mothereff.in/html-entities">HTML Entity Encoder/Decoder</a>
						<a class="list-group-item qa-item" target="_blank" href="http://www.binaryhexconverter.com/decimal-to-binary-converter">Decimal to Binary Converter</a>
						<a class="list-group-item qa-item" target="_blank" href="http://www.emvlab.org/">EMV Labs</a>
						<a class="list-group-item qa-item" target="_blank" href="http://postalcode.globefeed.com/Country_Postal_Code.asp">Country Postal Code Lookup</a>
						<a class="list-group-item qa-item" target="_blank" href="https://developers.whatismybrowser.com/useragents/parse/">Parse User Agent</a>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<div class="card-column-title">
							<div class="float-right">
								<i class="fab fa-html5"></i>
							</div>

							HTML5 Apps
						</div>
					</div>

					<div class="list-group list-group-flush qa-item-group">
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/html5-apps/dev/spa-apps/app/vt/">VT (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/spa/app/vt">VT (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/spa-test/app/vt">VT (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/spa/app/vt">VT (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/ebppHTML5/">EBPP AP (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/ebppHTML5QA/">EBPP AP (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/EbppHtmlRoles/">EBPP AP (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/ebppadmin/">EBPP AP (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/EbppHtmlPortalInt/PaymentPortal/">EBPP CP (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/EbppPaymentPortalQA/PaymentPortal/">EBPP CP (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/EbppPaymentPortalHtml5/PaymentPortal/">EBPP CP (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://remote.cenpos.net/RecurringPaymentsHTML5/">Recurring Payments AP (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://va2.cenpos.net/recurringpaymentshtmlqa/">Recurring Payments AP (VA)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/RecurringPaymentsHtml/">Recurring Payments AP (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/webpay/v7/html5/administration/">Webpay AP (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/webpaytest/v7/html5/administration/">Webpay AP (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/webpay/v7/html5/administration/">Webpay AP (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/webpay/v7/html5/administration/">Webpay AP (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/simplewebpay/cards/administration/">SWP Cards AP (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/simplewebpay-test/cards/administration/">SWP Cards AP (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/simplewebpay/cards/administration/">SWP Cards AP (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/simplewebpay/cards/administration/">SWP Cards AP (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/simplewebpay-test/checks/administration/">SWP Checks AP (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/simplewebpay/checks/administration/">SWP Checks AP (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/simplewebpay/checks/administration/">SWP Checks AP (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SimpleCashiering/">Simple Cashiering (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SimpleCashiering-test/">Simple Cashiering (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/simple-cashiering-new/">Simple Cashiering (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://webtest.cenpos.net/simplecashieringv3/">Simple Cashiering (Elavon Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/AccountsPayable/">Accounts Payable (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/AccountsPayableQA/">Accounts Payable (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/AccountsPayable/">Accounts Payable (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SupplierPortal/">AP Supplier Portal (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SupplierPortalQA/">AP Supplier Portal (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www.cenpos.biz/tpa/?merchant=">TPA (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://development.cenpos.com/hotelAuthForm/?merchant=">TPA (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/TPA/?merchant=">TPA (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www.cenpos.biz/tpa/administration.php">TPA Administration (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://development.cenpos.com/hotelAuthForm/administration.php">TPA Administration (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/TPA/administration.php">TPA Administration (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/tokenization/">Tokenization AP (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/reservation/?merchantid=">Synexis (Legacy Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/reservation/administration/">Synexis Administration (Legacy Dev)</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container" id="footer">
		<hr>
		<p class="text-muted text-center">
			&copy; <span id="current-year"></span> CenPOS, Inc.<br>
			All rights reserved
		</p>
	</div>
</body>
</html>
