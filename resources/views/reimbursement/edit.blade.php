<div class="modal fade" id="form_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" id="bt_submit_edit" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_data_exampleModalLabel">Edit</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Reimbursement</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm"
                                name="edit_data_nama_reimbursement" id="edit_data_nama_reimbursement"
                                placeholder="Masukkan Nama Reimbursement" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Tanggal</span>
                            </label>
                            <!--end::Label-->
                            <input type="date" class="form-control form-control-sm"
                                name="edit_data_tanggal_reimbursement" id="edit_data_tanggal_reimbursement"
                                placeholder="Masukkan Tanggal" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nominal</span>
                            </label>
                            <!--end::Label-->
                            <input type="number" class="form-control form-control-sm"
                                name="edit_data_nominal_reimbursement" id="edit_data_nominal_reimbursement"
                                placeholder="Masukkan Nominal" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">File )* Kosongkan Jika Tidak Perlu</span>
                            </label>
                            <!--end::Label-->
                            <input type="file" class="form-control form-control-sm"
                                name="edit_data_file_reimbursement" id="edit_data_file_reimbursement"
                                placeholder="Masukkan File" accept="image/*,.pdf" />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Deskripsi</span>
                            </label>
                            <!--end::Label-->
                            <textarea class="form-control form-control-sm" name="edit_data_deksripsi_reimbursement"
                                id="edit_data_deksripsi_reimbursement" rows="5" placeholder="Masukkan Deskripsi"></textarea>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal" aria-label="Close">Tutup
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
