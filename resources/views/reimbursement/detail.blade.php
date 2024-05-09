<div class="modal fade" id="form_detail" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <a type="button" class="badge badge-dark" data-dismiss="modal" aria-label="Close">X</a>
            </div>
            <div class="modal-body">
                <div id="null_data" style="display: none;">
                    <h3>Data not found</h3>
                </div>
                <div id="show_data" style="display: none;">
                    <div class="row">

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Nama Karyawan</span>
                            </label>
                            <p id="show_data_nama_karyawan"></p>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Reimbursement</span>
                            </label>
                            <p id="show_data_nama_reimbursement"></p>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Tanggal</span>
                            </label>
                            <p id="show_data_tanggal_reimbursement"></p>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Nominal</span>
                            </label>
                            <p id="show_data_nominal_reimbursement"></p>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Status</span>
                            </label>
                            <p id="show_data_status"></p>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>File )* Klik "LIHAT FILE"</span>
                            </label>
                            <a id="show_data_file" class="text-upprecase">Lihat File</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Deskripsi</span>
                            </label>
                            <p id="show_data_deskripsi"></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span>Keterangan Approval</span>
                            </label>
                            <p id="show_data_keterangan"></p>
                        </div>
                    </div>
                    @can('direktur-role')
                        <div class=" text-center">
                            <form method="POST" id="submit_approve" class="text-center">
                                <div class="row justify-content-md-center">
                                    <div class="col-sm-12">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Keterangan</span>
                                        </label>
                                        <!--end::Label-->
                                        <textarea class="form-control form-control-sm" name="keterangan_reimbursement" id="keterangan_reimbursement"
                                            rows="5" placeholder="Masukkan Kereangan"></textarea>
                                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-primary" id="terima_one">Terima</button>
                                <button class="btn btn-sm btn-danger" id="tolak_one">Tolak</button>
                            </form>
                        </div>
                    @elsecan('finance-role')
                        <div class=" text-center">
                            <form method="POST" id="submit_approve" class="text-center">
                                <div class="row justify-content-md-center">
                                    <div class="col-sm-12">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Keterangan</span>
                                        </label>
                                        <!--end::Label-->
                                        <textarea class="form-control form-control-sm" name="keterangan_reimbursement" id="keterangan_reimbursement"
                                            rows="5" placeholder="Masukkan Kereangan"></textarea>
                                        <ul id="error-list" class="list-unstyled text-danger"></ul>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-primary" id="terima_one">Terima</button>
                                <button class="btn btn-sm btn-danger" id="tolak_one">Tolak</button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
