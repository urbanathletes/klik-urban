@extends('master2')

@section('content')
<div class="container-fluid p0">
    <div class="signup-content h100vh">
        <div class="signup-desc">
            <div class="signup-desc-content" style="padding-left: 30px;padding-right: 30px;text-align:center;">
                <img src="assets/img/logo.png" alt="" class="img-fluid img-logo">
                <!-- <img src="assets/img/bg-guest-profile.jpg" alt="" class="img-fluid" style="min-height: 100vh;"> -->
            </div>
        </div>
        <div class="signup-form-conent">
            <div class="signup-form">
                @csrf
                <div class="form-group">

                    <div class="row">
                        <div class="col-sm-12">
                            <p style="font-size: 25px; font-weight:900;text-transform: uppercase;padding-bottom: 2rem; color:#060606;">
                                Pemesanan Telah Berhasil, Silahkan melakukan pembayaran.
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <iframe src="{{ $url }}" style="width: 100%;height: 100%;min-height: 100vh;"></iframe>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>


@endsection