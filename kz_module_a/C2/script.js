const recurring = document.getElementById('recurring');
const recurringFields = document.getElementById('recurringFields');

recurring.onchange = () => {
    recurringFields.disabled = !recurring.checked;
};
