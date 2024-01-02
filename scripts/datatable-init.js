const initDataTable = (tableId, emptyMessage)=> {
    return new DataTable(tableId, {
        "language": {
            "emptyTable": emptyMessage,
            "zeroRecords": emptyMessage
        },
        "responsive": true
    });
};