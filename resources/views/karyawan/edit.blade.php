<div class="modal fade" id="form_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" id="bt_submit_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_data_exampleModalLabel">Edit</h5>
                    <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">NIP</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_data_nip"
                                id="edit_data_nip" placeholder="Masukkan NIP" minlength="16" maxlength="16" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Karyawan</span>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-sm" name="edit_data_nama_karyawan"
                                id="edit_data_nama_karyawan" placeholder="Masukkan Nama Karyawan" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Email</span>
                            </label>
                            <!--end::Label-->
                            <input type="email" class="form-control form-control-sm" name="edit_data_email"
                                id="edit_data_email" placeholder="Masukkan Email" required />
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jabatan</span>
                            </label>
                            <select class="selectpicker form-control form-control-sm" name="edit_data_jabatan"
                                id="edit_data_jabatan" data-live-search="true" title="Pilih Jabatan" required>
                                <option value="STAFF">STAFF</option>
                                <option value="FINANCE">FINANCE</option>
                                <option value="DIREKTUR">DIREKTUR</option>
                            </select>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Password</span>
                            </label>
                            <!--end::Label-->
                            <input type="password" class="form-control form-control-sm" name="edit_data_password"
                                id="edit_data_password" placeholder="Masukkan Password"
                                autocomplete="current-password" />
                            <span class="form-text text-muted font-size-sm">*) Kosongkan jika tidak ingin
                                diperbarui</span>
                            <ul id="error-list" class="list-unstyled text-danger"></ul>
                        </div>
                        <div class="col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Konfirmasi Password</span>
                            </label>
                            <!--end::Label-->
                            <input type="password" class="form-control form-control-sm"
                                name="edit_data_password_confirmation" id="edit_data_password_confirmation"
                                placeholder="Konfirmasi Password" autocomplete="current-password" />
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
