import BSN from 'bootstrap.native'
import { Sortable, Plugins } from '@shopify/draggable';

function safeEncodeString(str) {
	return window.btoa(unescape(encodeURIComponent(str)));
}

function safeDecodeString(str) {
	return decodeURIComponent(escape(window.atob(str)));
}

function paramEncodeValue(name, value) {
	if (name == "password" || name == "urlresponse" || name == "urlresponsepost" || name == "leveliiidata" || name == "autorentaldata") {
		value = safeEncodeString(value);
	}

	if (name == "customercode" || name == "email" || name == "invoice" || name == "address") {
		value = encodeURI(value);
	}

	return value;
}

function saveParamsLocalStorage(params) {
	localStorage.clear();
	localStorage.setItem('integrator-params-used', JSON.stringify(params))
}

function retrieveParamsLocalStorage() {
	let params = JSON.parse(localStorage.getItem('integrator-params-used'));

	if (null === params || undefined === params) return;

	for (let param of Object.keys(params)) {
		let value = params[param];

		if ('type' === param) continue;

		let formParamsUsed = document.querySelector('#form-params-used');
		let formParamInput = document.querySelector('#form-params-available')
			.querySelector('#param-' + param);
		let formParamGroup = formParamInput.closest('.form-group');
		let detached = formParamGroup.parentElement.removeChild(formParamGroup);

		formParamInput.value = value;
		formParamsUsed.insertAdjacentElement('beforeend', detached);
	}
}

function populateApplicationSelectBox() {
	let selectBox = document.querySelector('#application-select-input');

	selectBox.disabled = false;
	selectBox.innerHTML = '';
	selectBox.insertAdjacentHTML('beforeend', '<option value="" selected disabled>--</option>');

	for (let name of Object.keys(integrator.applications)) {
		selectBox.insertAdjacentHTML('beforeend', `<option value="${name}">${name}</option>`);
	}
}

function populateEnvironmentSelectBox() {
	let selectedAppName = document.querySelector('#application-select-input').value;
	let selectBox = document.querySelector('#environment-select-input');

	selectBox.innerHTML = '';
	selectBox.insertAdjacentHTML('beforeend', '<option value="" selected disabled>--</option>');

	if (selectedAppName.length > 0) {
		let address = integrator.applications[selectedAppName]['url'];

		for (let name of Object.keys(address)) {
			let url = address[name];

			selectBox.insertAdjacentHTML('beforeend', `<option value="${url}">${name}</option>`);
		}

		selectBox.insertAdjacentHTML('beforeend', '<option value="custom">Custom</option>');
	}
}

function populateTransactionSelectBox() {
	let selectedAppName = document.querySelector('#application-select-input').value;
	let selectedAppType = integrator.applications[selectedAppName]['type'];
	let supportedTrxTypes = integrator.transactions[selectedAppType]['transaction'];
	let selectBox = document.querySelector('#transaction-select-input');

	selectBox.innerHTML = '';
	selectBox.insertAdjacentHTML('beforeend', '<option value="" selected disabled>--</option>');

	for (let name of Object.keys(supportedTrxTypes)) {
		let value = supportedTrxTypes[name];
		selectBox.insertAdjacentHTML('beforeend', `<option value="${value}">${value}</option>`);
	}
}

function populateParameterList() {
	let html = '';
	let paramsList = '';
	let params = integrator.parameters;

	for (let name of Object.keys(params)) {
		let values = params[name];

		if (1 == values.length && 0 == values[0].length) {
			paramsList = `<input type="text" id="param-${name}" class="integrator-param form-control form-control-sm">`;
		} else {
			paramsList = `<select id="param-${name}" class="integrator-param form-control form-control-sm">`;

			for (let option of Object.keys(values)) {
				let value = values[option];
				paramsList += `<option value="${value}">${value}</option>`;
			}

			paramsList += '</select>';
		}

		html += `<div class="form-group form-group-param row">
			<label for="param-${name}" class="col-sm-4 col-form-label col-form-label-sm">${name}:</label>
			<div class="col-sm-8">
				${paramsList}
			</div>
		</div>`;
	}

	document.querySelector('#form-params-available').innerHTML = html;
}

function populateRequiredParams() {
	let selectedAppName = document.querySelector('#application-select-input').value;
	let requiredParams = integrator.applications[selectedAppName]['require'];
	let paramsUsedForm = document.querySelector('#form-params-used');

	for (let name of requiredParams) {
		let selector = '#param-' + name;

		if (!paramsUsedForm.querySelector(selector)) {
			let label = document.querySelector(selector)
				.closest('.form-group')
				.querySelector('label');

			swapSingleParam(label);
		}
	}
}

function swapSingleParam(label) {
	let currentForm = label.closest('form');
	let currentParam = label.parentElement;
	let detachedParam = currentForm.removeChild(currentParam);
	let targetForm = ('form-params-available' === getElementId(currentForm)) ? '#form-params-used' : '#form-params-available';

	document.querySelector(targetForm).appendChild(detachedParam);
}

function clearUsedParametersList() {
	let formParams = document.querySelectorAll('#form-params-used .form-group-param');

	formParams.forEach((formParamGroup) => {
		swapSingleParam(formParamGroup.querySelector('label'));
	});
}

function getQueryStringParameters() {
	let queryString = document.querySelector('#query-string-input').value;
	let params = {};

	if (queryString.length > 0) {
		queryString.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
			key = key.toLowerCase();

			if (key == "password" || key == "urlresponse" || name == "urlresponsepost" || key == "leveliiidata" || key == "autorentaldata") {
				value = safeDecodeString(decodeURIComponent(value));
			}

			else if (key == "customercode" || key == "email" || key == "invoice" || key == "address") {
				value = decodeURI(value);
			}

			params[key] = value;
		});

		clearUsedParametersList();
		saveParamsLocalStorage(params);
		retrieveParamsLocalStorage();

		document.querySelector('#query-string-input').value = '';
	}
}

function loadIntegrationObject() {
	let params = {};
	let formParamsUsed = document.querySelector('#form-params-used')
		.querySelectorAll('.integrator-param');
	let selectedAppName = document.querySelector('#application-select-input').value;
	let selectedEnvironment = document.querySelector('#environment-select-input').value;
	let method = document.querySelector('#method-select-input').value;
	let baseUrl = '';

	if ('custom' === selectedEnvironment) {
		baseUrl = document.querySelector('#endpoint-select-input').value;
	} else {
		baseUrl = document.querySelector('#environment-select-input').value;
	}
	
	let getUrl = baseUrl + '?';

	if ('SWP Cards' !== selectedAppName && 'SWP Checks' !== selectedAppName) {
		params['type'] = document.querySelector('#transaction-select-input').value;
	}
	
	formParamsUsed.forEach((param) => {
		let id = getElementId(param);
		let name = id.substring(id.indexOf('-') + 1);
		let value = param.value;

		params[name] = value;
	});

	saveParamsLocalStorage(params);

	document.querySelector('#NewCenposPlugin').innerHTML = '';
	document.querySelector('#integration-iframe-loader').classList.remove('d-none');
	document.querySelector('#NewCenposPlugin').classList.add('d-none');
	document.querySelector('#swp-btns').classList.add('d-none');

	if ('Webpay' === selectedAppName || selectedAppName.includes('SWP')) {
		document.querySelector('#integration-iframe-loader').src = '';
		document.querySelector('#integration-iframe-loader').classList.add('d-none');
		document.querySelector('#NewCenposPlugin').classList.remove('d-none');
		loadWebpayObject(baseUrl, params);

		let btnsContainer = document.querySelector('#swp-btns');

		// Now display the buttons (if needed)
		if (selectedAppName.includes('SWP')) {
			btnsContainer.classList.remove('d-none');
		} else {
			btnsContainer.classList.add('d-none');
		}
	} else {
		if ("GET" === method) {
			let queryString = new URLSearchParams();

			for (let key of Object.keys(params)) {
				let val = paramEncodeValue(key, params[key]);

				// Append each parameter to URL
				queryString.append(key, val);
			}

			// Update getUrl
			getUrl = getUrl + queryString.toString();

			// Display the generated URL
			document.querySelector('#integration-endpoint-input').value = getUrl;

			// Load iframe
			document.querySelector('#integration-iframe-loader').src = getUrl;
		} else if ("POST" === method) {
			let formContent = '';
			let formFields = '';

			// Display the generated URL
			document.querySelector("#integration-endpoint-input").value = baseUrl;

			// Clean the post form
			document.querySelector("#post-form").innerHTML = '';

			// Get new data
			for (let key of Object.keys(params)) {
				let val = paramEncodeValue(key, params[key]);
				formFields += `<input type="hidden" name="${key}" value="${val}" />`;
			}

			formContent += `<form action="${baseUrl}" method="POST" target="integration-iframe-loader">
				${formFields}
				<input type="submit" id="post-form-submit" value="CLICK HERE TO SENT AS POST" />
			</form>`;

			// Add the new data to DOM
			document.querySelector("#post-form").innerHTML = formContent;

			// submit form and load iframe
			document.querySelector("#post-form-submit").click();
		}
	}
}

function loadWebpayObject(webpayUrl, webpayParams) {
	let siteVerifyUrl = webpayUrl + '?app=genericcontroller&action=siteVerify';
	let siteVerifyData = new URLSearchParams();

	// Required data for siteVerify
	if (webpayParams.hasOwnProperty('aeskey')) {
		siteVerifyData.append('secretkey', webpayParams['aeskey']);
		delete webpayParams.aeskey;
	}

	if (webpayParams.hasOwnProperty('apikey')) {
		siteVerifyData.append('merchant', webpayParams['apikey']);
		delete webpayParams.apikey;
	}

	// Some params need to be sent in the initial siteVerify request
	if (webpayParams.hasOwnProperty('email')) {
		siteVerifyData.append('email', webpayParams['email']);
		delete webpayParams.email;
	}

	if (webpayParams.hasOwnProperty('customercode')) {
		siteVerifyData.append('customercode', webpayParams['customercode']); 
		delete webpayParams.customercode;
	}

	if (webpayParams.hasOwnProperty('amount')) {
		siteVerifyData.append('amount', webpayParams['amount']); 
		delete webpayParams.amount;
	}

	if (webpayParams.hasOwnProperty('ip')) {
		siteVerifyData.append('ip', webpayParams['amount']); 
		delete webpayParams.ip;
	}

	if (webpayParams.hasOwnProperty('isrecaptcha')) {
		siteVerifyData.append('isrecaptcha', webpayParams['isrecaptcha']); 
		delete webpayParams.isrecaptcha;
	}

	postData(siteVerifyUrl, siteVerifyData)
		.then(response => {
			if (0 == response.Result) {
				let pluginParams = new URLSearchParams();

				pluginParams.append('verifyingpost', response.Data);

				for (let key of Object.keys(webpayParams)) {
					pluginParams.append(key, webpayParams[key]);
				}

				// The webpay plugin requires jQuery :\
				$('#NewCenposPlugin').createWebpay({
					url: webpayUrl,
					params: pluginParams.toString(),
					domain: webpayUrl.substring(0, webpayUrl.lastIndexOf('/')),
					/* width: '800',
					height: '750',*/
					success: getInlineResponse,
					cancel: getInlineResponse
				});
			} else {
				getInlineResponse(response);
			}
		});
}

function getElementId(elem) {
	if (null !== elem.attributes['id'] && undefined !== elem.attributes['id']) {
		return elem.attributes['id'].value;
	}

	return false;
}

function getInlineResponse(data) {
	let responseData = `<strong>STRING</strong>
	<hr class="hr-xs">
	<pre><code>${JSON.stringify(data, undefined, 2)}</code></pre>`;

	let response = document.querySelector('#integration-inline-response');
	let iframe = document.querySelector('.iframe-container');
	let iframeLoader = document.querySelector('#integration-iframe-loader');
	let swpBtns = document.querySelector('#swp-btns');

	response.innerHTML = responseData;
	response.closest('.card').classList.remove('d-none');
	iframe.classList.add('d-none');
	swpBtns.classList.add('d-none');
	iframeLoader.src = '';
}

async function bootFromJson() {
	try {
		let [applications, parameters, transactions] = await Promise.all([
			fetch('resources/json/applications.json').then((response) => response.json()),
			fetch('resources/json/parameters.json').then((response) => response.json()),
			fetch('resources/json/transactions.json').then((response) => response.json())
		]);

		integrator.applications = applications;
		integrator.parameters = parameters;
		integrator.transactions = transactions;

		populateApplicationSelectBox();
		populateParameterList();
		retrieveParamsLocalStorage();
	}
	catch (err) {
		console.log(err);
	};
}

async function postData(url = '', data = '', contentType = 'application/x-www-form-urlencoded') {
	const response = await fetch(url, {
		method: 'POST',
		mode: 'cors',
		cache: 'no-cache',
		credentials: 'same-origin',
		headers: {
			'Content-Type': contentType,
		},
		redirect: 'follow',
		referrerPolicy: 'no-referrer',
		body: data.toString()
	});

	return response.json();
}

document.addEventListener('DOMContentLoaded', (event) => {
	window.integrator = {};

	let mainForm = document.querySelector('#app-integrator .main-form');

	if (null !== mainForm && undefined !== mainForm) {
		mainForm.querySelectorAll('select').forEach((selectBox) => {
			selectBox.disabled = true;
		});

		bootFromJson();
	}

	document.addEventListener('click', (event) => {
		let trigger = event.target;
		let triggerId = getElementId(trigger);
		let bubble = trigger.closest('button, a, .btn, .param-button');

		if (null !== bubble) {
			trigger = bubble;
			triggerId = getElementId(bubble);
		}

		if ('query-string-submit' === triggerId) {
			let modal = new BSN.Modal('#query-string-modal');

			modal.hide();
			getQueryStringParameters();
		}

		if ('clear-used-button' === triggerId) {
			clearUsedParametersList();
		}

		if ('integration-loader-button' === triggerId) {
			document.querySelector('#integration-inline-response').closest('.card').classList.add('d-none');
			document.querySelector('.iframe-container').classList.remove('d-none');

			loadIntegrationObject();
		}

		if ('swp-submit' === triggerId) {
			// Webpay plugin requires jQuery :\
			$('#NewCenposPlugin').submitAction();
		}
	});

	document.addEventListener('dblclick', (event) => {
		let trigger = event.target;
		let triggerId = getElementId(trigger);
		let bubble = trigger.closest('label');

		if (null !== bubble) {
			trigger = bubble;
			triggerId = getElementId(bubble);
		}

		if (trigger.parentElement.classList.contains('form-group-param')) {
			swapSingleParam(trigger);
		}
	});

	document.addEventListener('change', (event) => {
		let trigger = event.target;
		let triggerId = getElementId(trigger);

		if ('application-select-input' === triggerId) {
			populateEnvironmentSelectBox();
			populateTransactionSelectBox();
			populateRequiredParams();

			let selectedAppName = document.querySelector('#application-select-input').value;
			let methodSelectBox = document.querySelector('#method-select-input');
			let trxSelectBox = document.querySelector('#transaction-select-input')

			mainForm.querySelectorAll('select').forEach((selectBox) => {
				selectBox.disabled = false;
			});

			if ('Webpay' === selectedAppName) {
				methodSelectBox.closest('.form-group').classList.add('d-none');
				trxSelectBox.closest('.form-group').classList.remove('d-none');
			} else if ('SWP Cards' === selectedAppName || 'SWP Checks' === selectedAppName) {
				methodSelectBox.closest('.form-group').classList.add('d-none');
				trxSelectBox.closest('.form-group').classList.add('d-none');
			} else {
				methodSelectBox.closest('.form-group').classList.remove('d-none');
				trxSelectBox.closest('.form-group').classList.remove('d-none');
			}
		}

		if ('environment-select-input' === triggerId) {
			let endpointFormGroup = document.querySelector('#endpoint-select-input').closest('.form-group');

			if ('custom' === trigger.value) {
				endpointFormGroup.classList.remove('d-none');
			} else {
				endpointFormGroup.classList.add('d-none');
			}
		}
	});

	window.addEventListener('message', function (event) {
		// Proceed if the posted message is the CenPOSResponse message
		if (event.data && event.data.type === 'CenPOSResponse') {
			getInlineResponse(event.data.data);
		}
	}, false);

	let queryString = document.querySelector('#query-string-input');
	let filterParams = document.querySelector('#input-filter-params');

	if (null !== queryString && undefined !== queryString) {
		queryString.addEventListener('keydown', (event) => {
			if (event.key === 13) {
				event.preventDefault();
				document.querySelector('#query-string-submit').click();
			}
		});
	}

	if (null !== filterParams && undefined !== filterParams) {
		filterParams.addEventListener('keydown', (event) => {
			let filter = filterParams.value;

			document.querySelectorAll('#form-params-available .form-group-param').forEach((param) => {
				param.classList.add('d-none');
			});

			document.querySelectorAll("#form-params-available .form-group-param label").forEach((label) => {
				let labelText = label.textContent;

				if (labelText.toLowerCase().indexOf(filter.toLowerCase()) >= 0) {
					label.parentElement.classList.remove('d-none');
				}
			});
		});
	}

	const sortable = new Sortable(document.querySelectorAll('.sortable'), {
		draggable: '.form-group-param',
		handle: 'label',
		classes: {
			'source:dragging': 'translucent'
		}
	});
});
