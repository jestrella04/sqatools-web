let currentYear = new Date().getFullYear();
let currentYearDiv = document.querySelector('#current-year');

if (null !== currentYearDiv && 'undefined' !== currentYearDiv) {
    currentYearDiv.innerHTML = currentYear;
}

document.addEventListener('click', (event) => {
    let trigger = event.target;
    let bubble = trigger.closest('button');

    if (null !== bubble) {
        trigger = bubble;
    }

    if (trigger.classList.contains('close')) {
        event.preventDefault();
        
        document.querySelector('#alert').classList.add('d-none');
    }
});
