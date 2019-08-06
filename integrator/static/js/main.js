var integrator = {};

if (window.location.protocol == 'http:') {
	var currentUrl = window.location.href.substr(5);
	var secureUrl  = 'https:' + currentUrl;
	
	window.location.replace(secureUrl);
}

var currentYear = new Date().getFullYear();

$('#current-year').html(currentYear);

$.when(
	$.getJSON("static/json/applications.json"),
	$.getJSON("static/json/parameters.json"),
	$.getJSON("static/json/transactions.json")
).then(function (applications, parameters, transactions) {
	integrator.applications = applications[0];
	integrator.parameters = parameters[0]["param"];
	integrator.transactions = transactions[0];

	populateApplicationSelectBox();
	populateParameterList();
	retrieveParamsLocalStorage();

	$("#loading-container").fadeOut(3000);
	$("#full-container").removeClass("d-none");
});

$('#query-string-submit').on('click', function () {
	$("#query-string-modal").modal("hide");

	getQueryStringParameters();
});

$("#query-string-input").keypress(function (e) {
	if (e.which == 13) {
		e.preventDefault();
		$("#query-string-submit").click();
	}
});

$('#integration-loader-button').on('click', function () {
	$('#integration-inline-response').parent().parent().addClass('d-none');
	$('.iframe-container').removeClass('d-none');

	loadIntegrationObject();
});

$(".sortable").sortable({
	axis: "y",
	cursor: "move",
	connectWith: '.sortable',
	opacity: 0.5,
}).disableSelection();

$("#input-filter-params").on('keydown', function () {
	var filter = $(this).val();

	$('#form-params-available .form-group-param').hide();

	$("#form-params-available .form-group-param label").each(function () {
		var label = $(this).text();

		if (label.toLowerCase().indexOf(filter.toLowerCase()) >= 0) {
			$(this).parent().show();
		}
	});
});

$('#application-select-input').on('change', function () {
	populateEnvironmentSelectBox();
	populateTransactionSelectBox();
});

$('#clear-used-button').on('click', function () {
	clearUsedParametersList();
});

window.addEventListener('message', function (event) {
	// Proceed if the posted message is the CenPOSResponse message
	if (event.data && event.data.type === 'CenPOSResponse') {
		var responseData = '<strong>STRING</strong><hr class="hr-xs"><pre><code>' + JSON.stringify(event.data.data, undefined, 2) + '</code></pre>';

		$('#integration-inline-response').empty();
		$('#integration-inline-response').append(responseData);
		$('#integration-inline-response').parent().parent().removeClass('d-none');
		$('.iframe-container').addClass('d-none');
		$('#integration-iframe-loader').attr('src', '');
	}
}, false);

function safeEncodeString(str) {
	return window.btoa(unescape(encodeURIComponent(str)));
}

function safeDecodeString(str) {
	return decodeURIComponent(escape(window.atob(str)));
}

function paramEncodeValue(key, val) {
	if (key == "password" || key == "urlresponse" || key == "leveliiidata" || key == "autorentaldata" || key == "customercode" || key == "email" || key == "invoice") {
		val = encodeURI(val);
	}

	return val;
}

function paramEncodeValue(name, value) {
	if (name == "password" || name == "urlresponse" || name == "leveliiidata" || name == "autorentaldata") {
		value = safeEncodeString(value);
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

			if (key == "password" || key == "urlresponse" || key == "leveliiidata" || key == "autorentaldata") {
				value = safeDecodeString(decodeURIComponent(value));
			}

			else if (key == "customercode" || key == "email" || key == "invoice") {
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