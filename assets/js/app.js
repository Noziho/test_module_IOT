let startBtn = document.querySelector('#startBtn');
let automaticBtn = document.querySelector('#automatic_btn');
let card = document.querySelector('.card');
let cardTitle = document.querySelectorAll('.card-title');
let duration = document.querySelectorAll('.duration');
let dataConsumed = document.querySelectorAll('.dataConsumed');
let sentData = document.querySelectorAll('.sentData');
let status = document.querySelectorAll('.status');
let ids = document.querySelectorAll('.id');
let modules = [];

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

fetch('http://localhost:8000/module/getAll')
    .then(r => r.json())
    .then(r => {
        r.forEach((item) => {
            modules.push(item)
        })

        if (modules.length > 0) {
            setInterval(() => {
                fetch('http://localhost:8000/operatingHistory/random')
                    .then(r => r.json())
                    .then(r => {
                        for (let i = 0; i < ids.length; i++) {
                            let OperatingHistoryDuration = r[i].OperatingHistory[r[i].OperatingHistory.length -1].duration;
                            let OperatingHistoryData = r[i].OperatingHistory[r[i].OperatingHistory.length -1].consumedData;
                            let OperatingHistorySentData = r[i].OperatingHistory[r[i].OperatingHistory.length -1].dataSent;
                            let OperatingHistoryStatus = r[i].OperatingHistory[r[i].OperatingHistory.length -1].status;

                            status[i].innerHTML= "Status: " + OperatingHistoryStatus;

                            if (!OperatingHistoryDuration) {
                                duration[i].innerHTML= "Durée d'utilisation actuelle (h): ";
                            }
                            else {
                                duration[i].innerHTML= "Durée d'utilisation actuelle (h): " + OperatingHistoryDuration;
                            }

                            if (!OperatingHistoryData) {
                                dataConsumed[i].innerHTML= "Données consommées (go): ";
                            }
                            else {
                                dataConsumed[i].innerHTML= "Données consommées (go): " + OperatingHistoryData;
                            }

                            if (!OperatingHistorySentData ) {
                                sentData[i].innerHTML= "Données envoyées (go): ";
                            }
                            else {
                                sentData[i].innerHTML= "Données envoyées (go): " + OperatingHistorySentData;
                            }
                        }
                    })
            }, 10000);
        }
    })
console.log(modules.length);


import '../styles/app.css';
import '/node_modules/bootstrap/dist/css/bootstrap.css';