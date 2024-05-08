let xLabels = null, yLabels = null;

function getChartData() {
    xLabels = [];
    yLabels = [];

    $.post({
        url: "api/traffic.php",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            let traffic = data.traffic, j = 30;
            for(let i = 0; i < 30; i++) {
                xLabels.push(j--);
                yLabels.push(traffic[i]);
            }
        }
    });
}

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

const fetchDiskUsage = ()=> {
    $.post(
        "side/apps.php?usage",
        {api_key: App.appKey},
        (data)=> {
            $("#accounts-usage").html(data["accounts"][1] +
                " kb <i>(Found " + data["accounts"][0] + " rows)</i>");

            $("#database-usage").html(data["database"][1] +
                " kb <i>(Found " + data["database"][0] + " rows)</i>");

            $("#da-id-usage").html(data["data_analytics_id"][1] +
                " kb <i>(Found " + data["data_analytics_id"][0] + " rows)</i>");

            $("#da-paging-usage").html(data["data_analytics_page"][1] +
                " kb <i>(Found " + data["data_analytics_page"][0] + " rows)</i>");

            $("#da-tracker-usage").html(data["data_analytics_track"][1] +
                " kb <i>(Found " + data["data_analytics_track"][0] + " rows)</i>");

            $("#activity-logs-usage").html(data["logs"][1] +
                " kb <i>(Found " + data["logs"][0] + " rows)</i>");

            $("#sms-auth-usage").html(data["sms_auth"][1] +
                " kb <i>(Found " +data["sms_auth"][0] + " rows)</i>");

            $("#storage-usage").html(data["storage"][1] +
                " kb <i>(Found " + data["storage"][0] + " rows)</i>");
        }
    );
};

window.onload = ()=> {
    getChartData();
    fetchDiskUsage();

    let chart = new Chart("traffic", {
        type: "line",
        data: {
            labels: xLabels,
            datasets: [{
                label: "Traffic Count",
                pointRadius: 1,
                borderColor: "#158cba",
                data: yLabels,
            }]
        },
        options: {
            legend: {display: false},
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                      display: true,
                      labelString: "Days Ago"
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                      display: true,
                      labelString: "Request Traffic Count"
                    }
                }]
            },
            plugins: {
                title: {
                    display: true,
                    text: "Request Network Traffic Data"
                }
            }
        }
    });

    $("#btn-copy-key").click(()=> copyToClipboard("API Key", App.appKey));
    $("#btn-copy-id").click(()=> copyToClipboard("API ID", App.appId));

    setInterval(()=> {
        getChartData();
        chart.update();

        fetchDiskUsage();
    }, 1000);
};