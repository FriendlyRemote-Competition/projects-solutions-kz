const buttons = document.querySelectorAll('.tab-button');
const panels = document.querySelectorAll('.tab-panel');

buttons.forEach(button => {
    button.onclick = () => {
        buttons.forEach(item => item.classList.remove('active'));
        panels.forEach(panel => panel.classList.remove('active'));

        button.classList.add('active');
        document.getElementById(button.dataset.tab).classList.add('active');
    }
})