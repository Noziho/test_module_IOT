let startBtn = document.querySelector('#startBtn');
let automaticBtn = document.querySelector('#automatic_btn');

startBtn.addEventListener('click', () => {
    window.location.href = 'http://localhost:8000/module';
});

automaticBtn.addEventListener('click', () => {
    window.location.href = 'http://localhost:8000/module/generate';
});
import '../styles/app.css';