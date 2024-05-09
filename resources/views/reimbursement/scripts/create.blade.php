<script>
    $("#form_create").on("show.bs.modal", function(e) {
        document.getElementById("bt_submit_create").reset();
    });
    $("#bt_submit_create").on("submit", function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Apakah data Anda sudah benar dan sesuai?",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.value) {
                const action = "{{ route('reimbursement.store') }}";
                const formData = new FormData();
                formData.append("nama_reimbursement", $("#nama_reimbursement").val());
                formData.append("tanggal_reimbursement", $("#tanggal_reimbursement").val());
                formData.append("deskripsi_reimbursement", $("#deskripsi_reimbursement").val());
                formData.append("nominal_reimbursement", $("#nominal_reimbursement").val());
                if ($("#file_reimbursement")[0].files.length > 0) {
                    formData.append("file_reimbursement", $("#file_reimbursement")[0].files[0]);
                }
                DataManager.formData(action, formData, 'POST').then(response => {
                        console.log(response);
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Oops...', 'Terjadi Kesalahan Validasi', 'error');
                        }

                        // Kasus 2: success = false & errors = tidak ada data
                        if (!response.success && !response.errors) {
                            Swal.fire('Oops...', response.message, 'error');
                        }

                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Error');
                    });

            }
        })

    });
</script>
