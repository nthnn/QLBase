let xLabels = [], yLabels = [];
(()=> {
    $.post({
        url: "api/traffic.php",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            let traffic = data.traffic;
            for(let i = 0; i < 30; i++) {
                xLabels.push(i + 1);
                yLabels.push(traffic[i]);
            }
        }
    });
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