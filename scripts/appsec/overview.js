let xLabels = [], yLabels = []; // Dummy y-axis data
(()=> {
    for(let i = 0; i < 31; i++) {
        xLabels.push("");
        yLabels.push(Math.floor(Math.random() * 100));
    }
})();

let shouldBeShown = true;
function copyToClipboard(name, value) {
    if(!shouldBeShown)
        return;

    $("#toast-title").html(name);
    $("#toast-copied").show();
    shouldBeShown = false;

    setTimeout(()=> {
        $("#toast-copied").hide();
        shouldBeShown = true;
    }, 3000);

    (async ()=> {
        try {
            await navigator.clipboard.writeText(value);
        }
        catch(err) { }
    })();
}

window.onload = ()=> {
    new Chart("traffic", {
        type: "line",
        data: {
            labels: xLabels,
            datasets: [{
                pointRadius: 1,
                borderColor: "#158cba",
                data: yLabels,
            }]
        },
        options: {
            legend: {display: false},
        }
    });

    $("#btn-copy-key").click(()=> copyToClipboard("API Key", App.appKey));
    $("#btn-copy-id").click(()=> copyToClipboard("API ID", App.appId));
};