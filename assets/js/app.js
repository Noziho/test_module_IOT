let startBtn = document.querySelector('#startBtn');
let automaticBtn = document.querySelector('#automatic_btn');
let card = document.querySelector('.card');

if (startBtn) {
    startBtn.addEventListener('click', () => {
        window.location.href = 'http://localhost:8000/module';
    });
}

if (automaticBtn) {
    automaticBtn.addEventListener('click', () => {
        window.location.href = 'http://localhost:8000/module/generate';
    });
}

if (card) {
    setInterval(() => {
        fetch('http://localhost:8000/operatingHistory/random').then(r => console.log('Success'));
    }, 30000);
}

import '../styles/app.css';
import '/node_modules/bootstrap/dist/css/bootstrap.css';