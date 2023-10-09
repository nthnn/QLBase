const fetchSMSLogs = ()=> {
};

$(document).ready(()=> {
    new DataTable("#sms-table");
    setInterval(fetchSMSLogs, 2000);
});

fetchSMSLogs();