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
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/webpay/releaseencrypter/">AES Encrypter (Dev)</a>
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

							Backoffice
						</div>
					</div>

					<div class="list-group list-group-flush qa-item-group">
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/BackOffice/">Backoffice (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/BackOffice/">Backoffice (Mia2)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/BackOffice/">Backoffice (Mia3)</a>
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
								<i class="fas fa-file-video"></i>
							</div>

							Flex Apps
						</div>
					</div>

					<div class="list-group list-group-flush qa-item-group">
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/vtweb/v8/VirtualTerminalWeb.html">VT (Mia3)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/lodging/virtualterminalweb.html">VT - Lodging (Mia3)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/CarRental/v8/VirtualTerminalWeb.html">VT - Car Rental (Mia3)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/Restaurant/V8/VirtualTerminalWeb.html">VT - Restaurant (Mia3)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/vtwebemvtest/">VT (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/apps/testABI/V6/emv/vtweb/virtualterminalweb.html">VT (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/apps/testABI/V6/CarRental/vtweb/virtualterminalweb.html">VT - Car Rental (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/apps/testABI/V6/TerminalInfo/vtweb/virtualterminalweb.html">VT - Terminal Info (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/apps/testABI/V6/Restaurant/vtweb/virtualterminalweb.html">VT - Restaurant (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/apps/testABI/V6/Lodging/vtweb/virtualterminalweb.html">VT - Lodging (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://va2.cenpos.net/vtweb/v6/VirtualTerminalWeb.html">VT (VA)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SimpleCashiering/">Simple Cashiering (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SimpleCashiering-test/">Simple Cashiering (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/simple-cashiering-new/">Simple Cashiering (Dev)</a>
					</div>
				</div>

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
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/vt-html5/">VT (Mia3)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/html5-apps/dev/spa-apps/app/vt/">VT (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/html5-apps/dev/vt/">VT - Legacy(Dev)</a>				
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/ebppHTML5/">EBPP (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/ebppHTML5QA/">EBPP (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/EbppHtmlRoles/">EBPP (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/EbppHtmlPortalInt/PaymentPortal/">EBPP Customer Portal (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/EbppPaymentPortalQA/PaymentPortal/">EBPP Customer Portal (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/EbppPaymentPortalHtml5/PaymentPortal/">EBPP Customer Portal (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://remote.cenpos.net/RecurringPaymentsHTML5/">Recurring Payments HTML5 (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://va2.cenpos.net/recurringpaymentshtmlqa/">Recurring Payments HTML5 (VA)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/webpay/v7/html5/administration/">Webpay Admin Panel (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/webpaytest/v7/html5/administration/">Webpay Admin Panel (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/webpay/v7/html5/administration/">Webpay Admin Panel (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/simplewebpay/cards/administration/">SimpleWebpay Admin Panel (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www3.cenpos.net/simplewebpay-test/cards/administration/">SimpleWebpay Admin Panel (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/simplewebpay/cards/administration/">SimpleWebpay Admin Panel (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/AccountsPayable/">Accounts Payable (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/AccountsPayableQA/">Accounts Payable (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/AccountsPayable/">Accounts Payable (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SupplierPortal/">AP Supplier Portal (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www4.cenpos.net/SupplierPortalQA/">AP Supplier Portal (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www.cenpos.biz/tpa/?merchant=">TPA (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://development.cenpos.com/hotelAuthForm/?merchant=">TPA (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/TPA/?merchant=">TPA (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://www.cenpos.biz/tpa/administration.php">TPA Administration (Prod)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://development.cenpos.com/hotelAuthForm/administration.php">TPA Administration (Staging)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/TPA/administration.php">TPA Administration (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/tokenization/">Tokenization Admin Panel (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/reservation/?merchantid=">Synexis (Dev)</a>
						<a class="list-group-item qa-item" target="_blank" href="https://test.cenpos.net:7443/reservation/administration/">Synexis Administration (Dev)</a>
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
