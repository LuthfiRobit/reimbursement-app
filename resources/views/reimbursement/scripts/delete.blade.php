<script>
    function deleteConfirmation(reimbursement) {
        Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Ini akan dihapus secara permanen!",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
        }).then((result) => {
            if (result.value) {
                const destroy = '{{ route('reimbursement.destroy', [':reimbursement']) }}';
                DataManager.deleteData(destroy.replace(':reimbursement', reimbursement)).then(response => {
                        if (response.success) {
                            Swal.fire('Success', "Data berhasil dihapus", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            Swal.fire('Oops...', response.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Oops...', 'Kesalahan server', 'error');
                    });

            }
        });
    }
</script>
