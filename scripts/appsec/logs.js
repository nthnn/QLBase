let prevLogsHash = "";
let dataTable = null;

const fetchLogs = ()=> {
    /*$.post({
        url: "api/index.php?action=file_fetch_all",
        headers: {
            "QLBase-App-ID": App.appId,
            "QLBase-API-Key": App.appKey
        },
        success: (data)=> {
            if(data.result == '0')
                return;

            if(prevLogsHash == CryptoJS.MD5(JSON.stringify(data)).toString())
                return;
            prevLogsHash = CryptoJS.MD5(JSON.stringify(data)).toString();

            if(data.value.length == 0 && (prevLogsHash != "" ||
                prevLogsHash != "")) {
                dataTable.clear().destroy();
                dataTable = initDataTable("#storage-table", "No stored files found.");

                return;
            }

            let fileRows = "";
            for(let files of data.value) {
                fileRows += "<tr><td>" + files[0].substring(1, 15) + "</td><td>" +
                    files[1] + "</td><td>" + files[2] + "</td><td>" + files[3] + "</td><td><button class=\"btn btn-sm btn-outline-danger mx-2\"" +
                    " onclick=\"deleteFile('" + files[0] + "', '" + files[1] +
                    "')\"><svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" widht=\"16\" height=\"16\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0\" /></svg></button></td></tr>";
            }

            dataTable.clear().destroy();
            $("#storage-table-body").html(fileRows);
            dataTable = initDataTable("#storage-table", "No stored files found.");
        }
    });*/
};

$(document).ready(()=> {
    dataTable = initDataTable("#logs-table", "No log records found.");

    fetchLogs();
    setInterval(fetchLogs, 2000);
});