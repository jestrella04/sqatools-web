let currentYear = new Date().getFullYear();
let currentYearDiv = document.querySelector('#current-year');
var filterInput = document.querySelector('#global-filter-input');

if (null !== currentYearDiv && 'undefined' !== currentYearDiv) {
    currentYearDiv.innerHTML = currentYear;
}

document.addEventListener('click', (event) => {
    let trigger = event.target;
    let bubble = trigger.closest('button');
    let triggerId = '';

    if (null !== trigger.attributes['id'] && undefined !== trigger.attributes['id']) {
        triggerId = trigger.attributes['id'].value;
    }

    if (null !== bubble) {
        trigger = bubble;
    }

    if (trigger.classList.contains('close')) {
        event.preventDefault();
        
        document.querySelector('#alert').classList.add('d-none');
    }

    if ('#global-filter-clear' === triggerId) {
        let query = document.querySelector('#global-filter-input');

        query.value = '';
        query.focus();
        query.dispatchEvent(new Keydown());
    }
});

console.log(filterInput);
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
