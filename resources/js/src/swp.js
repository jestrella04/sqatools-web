document.addEventListener('click', (event)=> {
    let trigger = event.target;
    let bubble = trigger.closest('button, a, .btn');

    if (null !== bubble) {
        trigger = bubble;
    }

    if (trigger.classList.contains('swp-testcase')) {
        event.preventDefault();

        let alert = document.querySelector('#alert');
        let server = document.querySelector('#server').value;
        let plugin = document.querySelector('#plugin').value;
        let recaptcha = document.querySelector('#recaptcha').value;
        let file = trigger.attributes['id'].value;
        let options = trigger.attributes['data-targeturl'].value;

        if ('object' == plugin) {
            options = options + '-object';
        }

        document.querySelector('#alert').classList.remove('d-none');
        document.querySelector('#script').disabled = true;
        document.querySelector('#webpay').innerHTML = '';
        document.querySelector('#webpay-response').innerHTML = '';
        document.querySelector('#webpay-url').value = '';
        document.querySelectorAll('.list-group-item').forEach((listGroup) => {
            listGroup.classList.remove('list-group-item-primary');
        });

        trigger.classList.add('list-group-item-primary');

        if ('' === server || '' === plugin || '' === recaptcha) {
            alert.classList.remove('d-none');
        } else {
            let paramsUrl = ['html/', file, '.php'].join('');
            let urlBase = document.URL.substr(0, document.URL.lastIndexOf('/'));
            let urlTail = ['swp.php/', server, '/', options, '-recaptcha' + recaptcha, '/', file, '.php'].join('');
            let url = [urlBase, urlTail].join('/');

            alert.classList.add('d-none');

            /* $.get(paramsUrl, function (data) {
                document.querySelector('#script-source-body').textContent = data;
            }); */

            document.querySelector('#script').disabled = false;
            document.querySelector('#webpay').src = encodeURI(urlTail);
            document.querySelector('#webpay-url').value = encodeURI(url);
        }
    }
});