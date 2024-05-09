<script>
    $("#form_detail").on("show.bs.modal", function(e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('reimbursement.show', [':id']) }}';
        $("#null_data, #show_data").hide();
        DataManager.fetchData(detail.replace(':id', id))
            .then(function(response) {
                if (response.success) {
                    if (response.data.file_reimbursement != '' || response.data.file_reimbursement !=
                        null) {
                        file = "{{ asset('files/') }}" + "/" + response.data.file_reimbursement;
                    }
                    if (response.data.file_reimbursement == '' || response.data.file_reimbursement ==
                        null) {
                        file = "{{ asset('assets/media/logos/logo.png') }}";
                    }
                    $("#show_data_nama_karyawan").text(response.data.karyawan.name);
                    $("#show_data_nama_reimbursement").text(response.data.nama_reimbursement);
                    $("#show_data_tanggal_reimbursement").text(response.data.tanggal_reimbursement);
                    $("#show_data_status").text(response.data.status);
                    $("#show_data_nominal_reimbursement").text(response.data.nominal_reimbursement);
                    $("#show_data_file").attr('href', file);
                    $("#show_data_deskripsi").text(
                        response.data.deskripsi_reimbursement != null ?
                        response.data.deskripsi_reimbursement : '------');
                    $("#show_data_keterangan").text(
                        response.data.keterangan != null ?
                        response.data.keterangan : '------');
                    $("#null_data").hide();
                    $("#show_data").show();
                } else {
                    $("#null_data").show();
                    $("#show_data").hide();
                }
            })
            .catch(function(error) {
                Swal.fire('Oops...', 'Kesalahan server', 'error');
                // console.log(response);
            });

        let status = '';
        $("#terima_one").click(function() {
            $("#submit_approve").submit();
            $("#terima_one").prop("disabled", true);
            status = 'y';
        });

        $("#tolak_one").click(function() {
            $("#submit_approve").submit();
            $("#terima_one").prop("disabled", true);
            status = 't';
        });

        $("#submit_approve").on("submit", function(e) {
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
                    const input = {
                        "id_reimbursement": button.data("id"),
                        "status": status,
                        "keterangan": $("#keterangan_reimbursement").val(),
                    };
                    DataManager.postData('{{ route('reimbursement.approve') }}', input).then(
                            response => {
                                if (response.success) {
                                    Swal.fire('Success', "Data telah berhasil dikirim",
                                        'success');
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    Swal.fire('Oops...', response.message, 'error');
                                }
                                $("#terima_one").prop("disabled", false);
                            })
                        .catch(error => {
                            $("#terima_one").prop("disabled", false);
                            Swal.fire('Oops...', 'Kesalahan server', 'error');
                        });
                }

            })
        });
    });
</script>
