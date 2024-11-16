/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

const ctx = document.getElementById("tempChart");
const chart = new Chart(ctx, {
    type: "line",
    data: {
        labels: ["0", "+1", "+2", "+3", "+4", "+5", "+6", "+7", "+8", "+9", "+10", "+11", "+12", "+13", "+14", "+15", "+16", "+17", "+18", "+19"],
        datasets: [
            {
                label: 'Temperature',
                fill: true,
                borderColor: '#4582ec',
                tension: 0.3
            },
            {
                label: 'Humidity',
                fill: false,
                borderColor: '#f0ad4e',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        scales: {y: {beginAtZero: true}}
    }
});

const updateGraph = ()=> {
    $.ajax({
        url: Environment.action("track_fetch_all"),
        type: "POST",
        headers: {
            "QLBase-API-Key": Environment.key,
            "QLBase-App-ID": Environment.id
        },
        contentType: false,
        processData: false,
        dataType: "json",
        success: (data)=> {
            if(data.result != '1')
                return;

            const tempData = [], humidData = [];
            for(let row of data.value.slice(-20)) {
                let jsonData = JSON.parse(atob(row[5]));

                tempData.push(jsonData.temp);
                humidData.push(jsonData.humid);
            }

            tempData.reverse();
            humidData.reverse();

            chart.data.datasets[0].data = tempData;
            chart.data.datasets[1].data = humidData;
            chart.update("none");
        }
    });
};

updateGraph();
setInterval(updateGraph, 2000);
