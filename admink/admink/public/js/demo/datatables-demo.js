// Call the dataTables jQuery plugin
$(document).ready(function() {
    $("#dataTableClientes").DataTable({
        mark: true,
        scrollY: "500px",
        columnDefs: [
            { orderable: false, targets: 0 },
            { type: "date-eu", targets: 5 },
            { type: "chinese-string", targets: [1, 2] }
        ],
        order: [[1, "asc"]],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
        }
    });
    $("#dataTable").DataTable({});
});

$(document).ready(function() {
    $("#dataTableArtistas").DataTable({
        mark: true,
        scrollY: "500px",
        columnDefs: [
            { orderable: false, targets: 0 },
            { type: "date-eu", targets: 5 },
            { type: "chinese-string", targets: [1, 2] }
        ],
        order: [[1, "asc"]],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
        }
    });
    $("#dataTable").DataTable({});
});

$(document).ready(function() {
    $("#dataTableEstacoes").DataTable({
        mark: true,
        scrollY: "500px",
        columnDefs: [
            { orderable: false, targets: 0 }
        ],
        order: [[1, "asc"]],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
        }
    });
    $("#dataTable").DataTable({});
});

$(document).ready(function() {
    $("#dataTableOrcamentos").DataTable({
        mark: true,
        scrollY: "500px",
        columnDefs: [
            { orderable: false, targets: 0 },
            { type: "date-euro", targets: [5, 6] },
        ],
        order: [[1, "asc"]],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
        }
    });
    $("#dataTable").DataTable({});
});

$(document).ready(function() {
    $("#dataTableAgendamentos").DataTable({
        mark: true,
        scrollY: "500px",
        columnDefs: [
            { orderable: false, targets: [0, 6] },
            { type: "date-euro", targets: 5 },
        ],
        order: [[1, "desc"]],
        language: {
            url:
                "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Portuguese-Brasil.json"
        }
    });
    $("#dataTable").DataTable({});
});
