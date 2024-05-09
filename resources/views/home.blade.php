@extends('layout.main')

@section('css-for-this-page')
@endsection

@section('content')
    <div class="content flex-column-fluid">
        <div class="row text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                <div class="p-3 bg-warning rounded shadow-sm">
                    <i class="bi bi-shield-minus fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Reimbursement Diajukan</h4>
                    <p class="font-weight-bold text-white">{{ $pengajuan }}</p>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="p-3 bg-success rounded shadow-sm">
                    <i class="bi bi-shield-check fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Reimbursement Diterima Direktur</h4>
                    <p id="totalAccount" class="font-weight-bold text-white">{{ $diterima_direktur }}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="p-3 bg-danger rounded shadow-sm">
                    <i class="bi bi-shield-exclamation fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Reimbursement Ditolak Direktur</h4>
                    <p class="font-weight-bold text-white">{{ $ditolak_direktur }}</p>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="p-3 bg-success rounded shadow-sm">
                    <i class="bi bi-shield-check fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Reimbursement Diterima Finance</h4>
                    <p class="font-weight-bold text-white">{{ $diterima_finance }}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="p-3 bg-danger rounded shadow-sm">
                    <i class="bi bi-shield-exclamation fa-2x mb-2 text-white"></i>
                    <h4 class="mb-2 text-white">Reimbursement Ditolak Finance</h4>
                    <p class="font-weight-bold text-white">{{ $ditolak_finance }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-for-this-page')
@endsection
