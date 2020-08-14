import BSN from 'bootstrap.native'

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
	var params = JSON.parse(localStorage.getItem('integrator-params-used'));

	$.each(params, function (name, value) {
		var formParamsUsed = $('#form-params-used');
		var formParamInput = $('#form-params-available').find('#param-' + name);
		var formParamGroup = formParamInput.parent().parent().detach();

		formParamInput.val(value);
		formParamGroup.appendTo(formParamsUsed);
	});
}

function populateApplicationSelectBox() {
	$('#application-select-input').empty();

	$.each(integrator.applications, function (name, config) {
		$('#application-select-input').append('<option value="' + name + '">' + name + '</option>');
	});

	$('#application-select-input').trigger('change');
}

function populateEnvironmentSelectBox() {
	var selectedAppName = $('#application-select-input').val();

	$('#environment-select-input').empty();

	if (selectedAppName.length > 0) {
		$.each(integrator.applications[selectedAppName]['url'], function (name, url) {
			$('#environment-select-input').append('<option value="' + url + '">' + name + '</option>');
		});
	}
}

function populateTransactionSelectBox() {
	var selectedAppName = $('#application-select-input').val();
	var selectedAppType = integrator.applications[selectedAppName]['type'];
	var supportedTrxTypes = integrator.transactions[selectedAppType]['transaction'];

	$('#transaction-select-input').empty();

	if (selectedAppName.length > 0) {
		$.each(supportedTrxTypes, function (idx, name) {
			$('#transaction-select-input').append('<option value="' + name + '">' + name + '</option>');
		});
	}
}

function populateParameterList() {
	var paramsList = '';

	$.each(integrator.parameters, function (name, values) {
		paramsList += '<div class="form-group form-group-param row">';
		paramsList += '	<label for="param-' + name + '" class="col-sm-4 col-form-label col-form-label-sm">' + name + ':</label>';
		paramsList += '	<div class="col-sm-8">';

		if (1 == values.length && 0 == values[0].length) {
			paramsList += '		<input type="text" id="param-' + name + '" class="integrator-param form-control form-control-sm">';
		} else {
			paramsList += '		<select id="param-' + name + '" class="integrator-param form-control form-control-sm">';

			$.each(values, function (idx, option) {
				paramsList += '			<option value="' + option + '">' + option + '</option>';
			});

			paramsList += '		</select>';
		}

		paramsList += '	</div>';
		paramsList += '</div>';
	});

	$('#form-params-available').append(paramsList);
}

function clearUsedParametersList() {
	var params = $('#form-params-used').find('.integrator-param');

	$.each(params, function () {
		var formParamGroup = $(this).parent().parent().detach();

		formParamGroup.appendTo($('#form-params-available'));
	});
}

function getQueryStringParameters() {
	var queryString = $('#query-string-input').val();
	var params = {};

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

		$('#query-string-input').val('');
	}
}

function loadIntegrationObject() {
	var params = {};
	var formParamsUsed = $('#form-params-used').find('.integrator-param');
	var method = $('#method-select-input').val();
	var baseUrl = $('#environment-select-input').val();
	var basePath = baseUrl.substring(0, baseUrl.lastIndexOf('/')) + '/';
	var getUrl = baseUrl + '?';

	params['type'] = $('#transaction-select-input').val();

	$(formParamsUsed).each(function () {
		var id = $(this).attr('id');
		var name = id.substring(id.indexOf('-') + 1);
		var value = $(this).val();

		value = (name, value);

		params[name] = value;
	});

	saveParamsLocalStorage(params);

	if ("GET" == method) {
		$.each(params, function (key, val) {
			val = paramEncodeValue(key, val);

			// Append each parameter to URL
			if ("type" == key) {
				getUrl = getUrl + key + "=" + val;
			}

			else {
				getUrl = getUrl + "&" + key + "=" + val;
			}

			// Display the generated URL
			$("#integration-endpoint-input").val(getUrl);
		});

		// Load iframe
		$('#integration-iframe-loader').attr('src', getUrl);
	}

	else if ("POST" == method) {
		var formContent = "";

		// Display the generated URL
		$("#integration-endpoint-input").val(baseUrl);

		// Clean the post form
		$("#post-form").empty();

		// Get new data
		formContent += '<form action="' + baseUrl + '" method="POST" target="integration-iframe-loader">';

		$.each(params, function (key, val) {
			val = paramEncodeValue(key, val);

			formContent += '<input type="hidden" name="' + key + '" value="' + val + '" />';
		});

		formContent += '<input type="submit" id="post-form-submit" value="CLICK HERE TO SENT AS POST" />';
		formContent += '</form>';

		// Add the new data to DOM
		$("#post-form").append(formContent);

		// submit form and load iframe
		$("#post-form-submit").click();
	}
}

function getElementId(elem) {
	if (null !== elem.attributes['id'] && undefined !== elem.attributes['id']) {
		return elem.attributes['id'].value;
	}

	return false;
}

async function bootFromJson() {
	try {
		let [applications, parameters, transactions] = await Promise.all([
			fetch('/resources/json/applications.json'),
			fetch('/resources/json/parameters.json'),
			fetch('/resources/json/transactions.json')
		]);
	  
		integrator.applications = applications.json();
		integrator.parameters = parameters.json();
		integrator.transactions = transactions.json();

		populateApplicationSelectBox();
		populateParameterList();
		retrieveParamsLocalStorage();
	  }
	  catch(err) {
		console.log(err);
	  };
}

document.addEventListener('DOMContentLoaded', (event) => {
	window.integrator = {};

	bootFromJson();

	document.addEventListener('click', (event) => {
		let trigger = event.target;
		let triggerId = getElementId(trigger);
		let bubble = trigger.closest('button, a, .btn');

		if (null !== bubble) {
			trigger = bubble;
			triggerId = getElementId(bubble);
		}

		if ('query-string-submit' === triggerId) {
			let modal = new BSN.modal('#query-string-modal');

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
	});

	/* */
	document.addEventListener('change', (event) => {
		let trigger = event.target;
		let triggerId = getElementId(trigger);

		if ('application-select-input' === triggerId) {
			populateEnvironmentSelectBox();
			populateTransactionSelectBox();
		}
	});

	window.addEventListener('message', function (event) {
		// Proceed if the posted message is the CenPOSResponse message
		if (event.data && event.data.type === 'CenPOSResponse') {
			var responseData = `<strong>STRING</strong>
			<hr class="hr-xs">
			<pre>
				<code>${JSON.stringify(event.data.data, undefined, 2)}</code>
			</pre>`;

			let response = document.querySelector('#integration-inline-response');
			let iframe = document.querySelector('.iframe-container');
			let iframeLoader = document.querySelector('#integration-iframe-loader');

			response.innerHTML = responseData;
			response.closest('.card').classList.remove('d-none');
			iframe.classList.add('d-none');
			iframeLoader.src = '';
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
});

/* $(".sortable").sortable({
	axis: "y",
	cursor: "move",
	connectWith: '.sortable',
	opacity: 0.5,
}).disableSelection(); */
