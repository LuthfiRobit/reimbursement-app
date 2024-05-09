<script>
    let id = '';
    $("#form_edit").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_edit").reset();
        const button = $(e.relatedTarget);
        id = button.data("id");
        const detail = '{{ route('reimbursement.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    $("#edit_data_nama_reimbursement").val(response.data.nama_reimbursement);
                    $("#edit_data_tanggal_reimbursement").val(response.data.tanggal_reimbursement);
                    $("#edit_data_deksripsi_reimbursement").val(response.data.deskripsi_reimbursement);
                    $("#edit_data_nominal_reimbursement").val(response.data.nominal_reimbursement);
                    $('.selectpicker').selectpicker('refresh').selectpicker('render');
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
            });
    });

    $("#bt_submit_edit").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Apakah data Anda sudah benar dan sesuai dengan peraturan?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const update = '{{ route('reimbursement.update', [':id']) }}';
                const formData = new FormData();
                formData.append("nama_reimbursement", $("#edit_data_nama_reimbursement").val());
                formData.append("tanggal_reimbursement", $("#edit_data_tanggal_reimbursement").val());
                formData.append("nominal_reimbursement", $("#edit_data_nominal_reimbursement").val());
                formData.append("deskripsi_reimbursement", $("#edit_data_deksripsi_reimbursement")
                    .val());
                if ($("#edit_data_file_reimbursement")[0].files.length > 0) {
                    formData.append("file_reimbursement",
                        $("#edit_data_file_reimbursement")[0].files[0]);
                }
                formData.append("_method", "PUT");
                DataManager.formData(update.replace(':id', id), formData, "POST").then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }

                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_data_");
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }

                        // Kasus 2: success = false & errors = tidak ada data
                        if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });
            }
        })

    });
</script>
