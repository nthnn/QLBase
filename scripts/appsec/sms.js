const fetchSMSLogs = ()=> {
    new DataTable("#sms-table");
};

$(document).ready(()=> {
    setInterval(fetchSMSLogs, 2000);
});

fetchSMSLogs();