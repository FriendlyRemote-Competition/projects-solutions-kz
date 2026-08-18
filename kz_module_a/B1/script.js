const gradientBox = document.getElementById('gradientBox')

const startInput = document.getElementById('startColor')

const endInput = document.getElementById('endColor')

const randomColor = () => {
    const number = Math.floor(Math.random() * 0xffffff);

    return `#${number.toString(16).padStart(6, '0')}`;
}

let startColor = '#ff0000';
let endColor = '#0000ff';

const drawGradient = () => {
    startColor = startInput.value;
    endColor = endInput.value;

    gradientBox.style.background = `linear-gradient(to right, ${startColor}, ${endColor})`
}

const createButtons = (grid, input) => {
    for (let index = 0; index < 12; index++) {
        const color = randomColor();
        const button = document.createElement('button')

        button.className = 'color-button';
        button.style.backgroundColor = color;
        button.onclick = () => {
            input.value = color;
            drawGradient();
        }

        grid.append(button)
    }
}

createButtons(document.getElementById('startColors'), startInput)
createButtons(document.getElementById('endColors'), endInput)

startInput.oninput = drawGradient;
endInput.oninput = drawGradient;

drawGradient()