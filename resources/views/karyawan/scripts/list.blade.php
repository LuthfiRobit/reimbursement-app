<script>
    load_data();
    const rows_selected = [];

    function load_data() {

        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: "lBfrtip",
            stateSave: true,
            stateDuration: -1,
            lengthmenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'noVis'
            }],
            buttons: [{
                    extend: 'colvis',
                    collectionLayout: 'fixed columns',
                    collectionTitle: 'Column visibility control',
                    className: 'btn btn-sm btn-primary rounded',
                    columns: ':not(.noVis)'
                },
                {
                    extend: "csv",
                    titleAttr: 'Csv',
                    action: newexportaction,
                    className: 'btn btn-sm btn-primary rounded',
                },
                {
                    extend: "excel",
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-primary rounded',
                },
            ],
            language: {
                processing: '<p >Please wait...</p>'
            },
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            scroller: {
                loadingIndicator: true
            },
            deferRender: true,
            destroy: true,
            ajax: {
                url: '{{ route('karyawan.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            rowCallback: function(row, data, dataIndex) {
                const rowId = data['id_karyawan'];
                // If row ID is in the list of selected row IDs
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            },
            columns: [{
                    data: "DT_RowIndex",
                    render: function(data) {
                        if (data != null) {
                            return "";
                        }
                        return data;
                    },
                    orderable: false,
                },
                {
                    data: "action",
                    render: function(data) {
                        let x_edit = "";
                        let x_detail = "";
                        x_detail = `<a
                                data-id="${data}"
                                title='Detail'
                                data-toggle="modal"
                                data-target="#form_detail"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1'>
                                <span class='bi bi-file-text ' aria-hidden='true'></span>
                            </a>`;
                        x_edit = `<a
                                data-id="${data}"
                                title='Edit'
                                data-toggle="modal"
                                data-target="#form_edit"
                                aria-label="Close"
                                data-dismiss="modal"
                                class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1'>
                                <span class='bi bi-pencil' aria-hidden='true'></span>
                            </a>`;
                        x_delete = `<a
                                    data-toggle='tooltip'
                                    data-placement='top'
                                    title='Delete'
                                    onclick='deleteConfirmation("${data}")'
                                    class='btn btn-icon btn-bg-light btn-active-text-primary btn-sm me-1'>
                                    <span class='bi bi-trash ' aria-hidden='true'></span>
                                </a>`;
                        return `${x_detail} ${x_edit} ${x_delete}`
                    },
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "nip",
                    name: "nip"
                },
                {
                    data: "nama_karyawan",
                    name: "nama_karyawan"
                },
                {
                    data: "jabatan",
                    name: "jabatan"
                }
            ],
        });


        const performOptimizedSearch = _.debounce(function(query) {
            try {
                if (query.length >= 4 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error("Error during search:", error);
            }
        }, 500);

        $('#example_filter input').unbind().on('input', function() {
            performOptimizedSearch($(this).val());
        });

        $('#example tbody').on('click', 'input[type="checkbox"]', function(e) {
            const $row = $(this).closest('tr');
            const data = table.row($row).data();
            const rowId = data['id_karyawan'];
            const index = $.inArray(rowId, rows_selected);
            if (this.checked && index === -1) {
                rows_selected.push(rowId);
            } else if (!this.checked && index !== -1) {
                rows_selected.splice(index, 1);
            }

            if (this.checked) {
                $row.addClass('selected');
            } else {
                $row.removeClass('selected');
            }
            updateDataTableSelectAllCtrl(table);
            e.stopPropagation();
        });


    }
</script>
