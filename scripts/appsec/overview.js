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
            if(data.result == "0")
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