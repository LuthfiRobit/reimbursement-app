<script>
    $("#terima").click(function() {
        if (rows_selected.length > 0) {
            $("#terima").prop("disabled", true);
            const input = {
                "id_reimbursement": rows_selected,
                "status": "y",
            };
            DataManager.postData('{{ route('reimbursement.approve.multiple') }}', input).then(
                    response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                        $("#terima").prop("disabled", false);
                    })
                .catch(error => {
                    $("#terima").prop("disabled", false);
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }
    });

    $("#tolak").click(function() {
        if (rows_selected.length > 0) {
            $("#tolak").prop("disabled", true);
            const input = {
                "id_reimbursement": rows_selected,
                "status": "t",
            };
            DataManager.postData('{{ route('reimbursement.approve.multiple') }}', input).then(
                    response => {
                        if (response.success) {
                            Swal.fire('Success', "Data telah berhasil dikirim", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                        $("#tolak").prop("disabled", false);
                    })
                .catch(error => {
                    $("#tolak").prop("disabled", false);
                    Swal.fire('Oops...', 'Kesalahan server', 'error');
                });
        }
    });
</script>
