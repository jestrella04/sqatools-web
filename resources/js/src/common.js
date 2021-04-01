document.addEventListener('click', (event) => {
    let trigger = event.target;
    let bubble = trigger.closest('button, .input-group-text');
    let triggerId = '';

    if (null !== bubble) {
        trigger = bubble;
    }

    if (null !== trigger.attributes['id'] && undefined !== trigger.attributes['id']) {
        triggerId = trigger.attributes['id'].value;
    }

    if (trigger.classList.contains('close')) {
        event.preventDefault();

        let alert = document.querySelector('#alert');

        if (null !== alert && undefined !== alert) {
            alert.classList.add('d-none');
        }
        
    }

    if ('global-filter-clear' === triggerId) {
        let query = document.querySelector('#global-filter-input');

        query.value = '';
        query.focus();
        query.dispatchEvent(new KeyboardEvent('keydown', { key: 'Enter' }));
    }
});

document.addEventListener('DOMContentLoaded', () => {
    let filterInput = document.querySelector('#global-filter-input');
    let currentYear = new Date().getFullYear();
    let currentYearDiv = document.querySelector('#current-year');

    if (null !== currentYearDiv && undefined !== currentYearDiv) {
        currentYearDiv.innerHTML = currentYear;
    }

    if (null !== filterInput && undefined !== filterInput) {
        filterInput.addEventListener('keydown', () => {
            let query = filterInput.value;
            let qaItems = document.querySelectorAll('.qa-item');

            qaItems.forEach((item) => {
                item.classList.add('d-none');
            });

            qaItems.forEach((item) => {
                if (item.textContent.toLowerCase().includes(query.toLowerCase())) {
                    item.classList.remove('d-none');
                }
            });
        });
    }
});
