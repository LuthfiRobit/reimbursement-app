<!DOCTYPE html>
<html lang="en">

<head>
    <title>E-Reimbursement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <link href="{{ asset('assets/plugins/custom/font/font.css?family=Poppins:300,400,500,600,700') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet">
    <meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
        style="background-image: url({{ asset('assets/media/illustrations/14.png') }});">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST"
                    action="{{ route('authenticate') }}">
                    @csrf
                    @method('POST')
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> Pastikan data yang anda benar!
                            @error('message')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="text-center mb-11">
                        <h1 class="text-dark fw-bolder mb-3">Login</h1>
                        <p class="fw-bolder mx-2 my-3">E-Reimbursement</p>
                    </div>
                    <div class="fv-row mb-8">
                        <label class="d-flex align-items-center fw-bold mb-2"><span class="required">NIP</span></label>
                        <input type="text" placeholder="NIP" name="nip" autocomplete="off"
                            class="bg-transparent form-control-sm form-control fs-8">
                    </div>
                    <div class="fv-row mb-3" data-kt-password-meter="true">
                        <label class="d-flex align-items-center fw-bold mb-2"><span
                                class="required">Password</span></label>
                        <div class="position-relative mb-3">
                            <input class="bg-transparent form-control-sm form-control fs-8" type="password"
                                placeholder="Password" name="password" autocomplete="off">
                        </div>
                    </div>
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-sm btn-primary">
                            <span class="indicator-label">Login</span>
                            <span class="indicator-progress">Tunggu Sebentar... <span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/global/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>

</html>
