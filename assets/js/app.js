import Chart from 'chart.js/auto';

//This const can be changed it depend on what interval u need a operatingHistory
const HISTORY_INTERVAL = 1000;
let startBtn = document.querySelector('#startBtn');
let automaticBtn = document.querySelector('#automatic_btn');
let card = document.querySelectorAll('.card');
let duration = document.querySelectorAll('.duration');
let dataConsumed = document.querySelectorAll('.dataConsumed');
let sentData = document.querySelectorAll('.sentData');
let status = document.querySelectorAll('.status');
//Used to stock each module on it.
let modules = [];
//An array which will contains each charts generated above.
let charts = [];

//Adding click event for redirect.
if (startBtn) {
    startBtn.addEventListener('click', () => {
        window.location.href = 'http://localhost:8000/module';
    });
}
//Adding click event for redirect.
if (automaticBtn) {
    automaticBtn.addEventListener('click', () => {
        window.location.href = 'http://localhost:8000/module/generate';
    });
}
function generateCharts(r)
{
    //Generate all canvas for create new charts for each module.
    for (let i = 0; i < modules.length; i++) {
        let canvas = document.createElement('canvas');
        canvas.id = "canvas" + i;
        if (card[i]) {
            card[i].append(canvas);

            let ctx = document.getElementById('canvas' + i);

            charts.push(
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Données consommées', 'Données envoyées'],
                        datasets: [{
                            label: 'Données utilisé/envoyées en go',
                            data:
                                [
                                    r[i].OperatingHistory[r[i].OperatingHistory.length -1].consumedData,
                                    r[i].OperatingHistory[r[i].OperatingHistory.length -1].dataSent,
                                ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                })
            )
        }

    }
}
/**
 *
 * @param chart the chart u want to add something into.
 * @param label the label according to the data.
 * @param data the data u want to add in.
 * This function is here to add data into a given chart
 */
function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

/**
 *
 * @param chart the chart u want to remove data of.
 */
function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}

function generateErrorMessages(status, id)
{
    if (status === "Hors service") {

        let errorMessageContainer = document.querySelector('.messageContainer');

        let alertBox = document.createElement('div');
        alertBox.className = 'alert alert-danger';

        let errorMessage = document.createElement('p');
        errorMessage.innerHTML = 'Le module ' + id + ' est hors service';

        alertBox.append(errorMessage);
        errorMessageContainer.append(alertBox);
    }
}

function removeErrorMessages()
{
    let errorMessages = document.querySelectorAll('.alert');

    errorMessages.forEach((item) => {
        item.remove();
    })
}

/**
 * This method generate a history for each module and refresh the display
 */
function getRandomHistoryAndDisplay(){
    fetch('http://localhost:8000/operatingHistory/random')
        .then(r => r.json())
        .then(r => {

            for (let i = 0; i < modules.length; i++) {
                let OperatingHistoryDuration = r[i].OperatingHistory[r[i].OperatingHistory.length -1].duration;
                let OperatingHistoryData = r[i].OperatingHistory[r[i].OperatingHistory.length -1].consumedData;
                let OperatingHistorySentData = r[i].OperatingHistory[r[i].OperatingHistory.length -1].dataSent;
                let OperatingHistoryStatus = r[i].OperatingHistory[r[i].OperatingHistory.length -1].status;
                if (status[i]){
                    status[i].innerHTML= "Status: " + OperatingHistoryStatus;

                    generateErrorMessages(OperatingHistoryStatus, r[i].id);

                    //Removing old data
                    removeData(charts[i]);
                    removeData(charts[i]);
                    //Add new data to the charts
                    addData(charts[i], 'Données consomées', OperatingHistoryData);
                    addData(charts[i], 'Données envoyées', OperatingHistorySentData);

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
            }
        })
}


//Fetching to get all module data including details and operatingHistory
fetch('http://localhost:8000/module/getAll')
    .then(r => r.json())
    .then(r => {
        r.forEach((item) => {
            modules.push(item);
        })

        generateCharts(r);
        //This call is for avoid to wait 30 sec again when u switch page, every time u switch ur page a random history will be generated, like that u doesn't have to wait 30 sec because the set interval will reset to 30sec each time u switch page
        //getRandomHistoryAndDisplay();

        if (modules.length > 0) {
            setInterval(() => {
                removeErrorMessages();
                getRandomHistoryAndDisplay();

            }, HISTORY_INTERVAL);
        }
    })

import '../styles/app.css';
import '/node_modules/bootstrap/dist/css/bootstrap.css';