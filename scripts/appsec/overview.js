let xLabels = [], yLabels = []; // Dummy y-axis data
(()=> {
    for(let i = 0; i < 31; i++) {
        xLabels.push("");
        yLabels.push(Math.floor(Math.random() * 100));
    }
})();

window.onload = ()=> {
    new Chart("traffic", {
        type: "line",
        data: {
            labels: xLabels,
            datasets: [{
                pointRadius: 1,
                borderColor: "rgb(0,0,255)",
                data: yLabels,
            }]
        },
        options: {
            legend: {display: false},
        }
    });
};