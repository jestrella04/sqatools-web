document.addEventListener('click', (event) => {
    let trigger = event.target;
    let bubble = trigger.closest('.list-group-item');

    if (null !== bubble) {
        trigger = bubble;
    }

    if (trigger.classList.contains('list-group-item')) {
        let merchant = trigger.attributes['data-merchantid'].value;
        let server = document.querySelector('#server').value;
        let plugin = document.querySelector('#plugin').value;
        let integrated = document.querySelector('#integrated').value;
        let alert = document.querySelector('#alert');
        let testCase = trigger.attributes['id'].value;
        let response = document.querySelector('#webpay-response');

        alert.classList.add('d-none');
        response.classList.add('d-none');

        document.querySelectorAll('.list-group-item').forEach((item) => {
            item.classList.remove('list-group-item-primary');
        });

        trigger.classList.add('list-group-item-primary');
        document.querySelector('#webpay-url').value = '';

        if ('' == server || '' == plugin || '' == integrated) {
            alert.classList.remove('d-none');
        } else {
            let urlBase = document.URL.substr(0, document.URL.lastIndexOf('/'));
            let urlTail = 'webpay.php/' + merchant + '/' + server + '/' + plugin + '/' + testCase + '.html';
            let url = urlBase + '/' + urlTail;
            let params = new URLSearchParams();
            let amount = document.querySelector('#amount').value;
            let clientId = document.querySelector('#client-id').value;
            let email = document.querySelector('#email').value;
            let invoice = document.querySelector('#invoice').value;
            let address = document.querySelector('#address').value;
            let zip = document.querySelector('#zip').value;

            // append parameters (if integrated)
            if ('true' === integrated) {
                if ('' !== amount) {
                    params.append('amount', amount);
                }
    
                if ('' !== clientId) {
                    params.append('client_id', clientId);
                }
    
                if ('' !== email) {
                    params.append('email', email);
                }
    
                if ('' !== invoice) {
                    params.append('invoice', invoice);
                }

                if ('' !== address) {
                    params.append('address', address);
                }

                if ('' !== zip) {
                    params.append('zip', zipc054049);
                }

                url = url + '?' + params.toString();
            }

            //document.querySelector('#script').removeAttribute('disabled');
            document.querySelector('#webpay').src = url;
            document.querySelector('#webpay-url').value = url;
        }
    }
});

document.addEventListener('change', (event) => {
    let trigger = event.target;

    if (null !== trigger.attributes['id'].value && 'integrated' === trigger.attributes['id'].value) {
        let integrated = trigger.value;

        if ('true' === integrated) {
            document.querySelectorAll('.integration').forEach((integration) => {
                integration.classList.remove('d-none');
            });
        } else {
            document.querySelectorAll('.integration').forEach((integration) => {
                integration.classList.add('d-none');
            });
        }
    }
});
