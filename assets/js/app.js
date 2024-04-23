let startBtn = document.querySelector('#startBtn');
let automaticBtn = document.querySelector('#automatic_btn');

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

import '../styles/app.css';
import '/node_modules/bootstrap/dist/css/bootstrap.css';