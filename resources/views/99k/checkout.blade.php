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
            <form method="POST" action="/order" id="order-form" class="signup-form">
                @csrf
                <div class="form-group">

                    <div class="row">
                        <div class="col-sm-12">
                            <p style="font-size: 25px; font-weight:900;text-transform: uppercase;padding-bottom: 2rem; color:#060606;">
                                Checkout Sekarang!!!
                            </p>
                        </div>
                    </div>

                    <input type="text" name="checkout_id" id="checkout_id" value="{{ $data['checkout_number'] }}" style="display:none;" />
                    <input type="text" name="lead_id" id="lead_id" value="{{ $leadsId }}" style="display:none;" />
                    <input type="text" name="package_membership_id" id="package_membership_id" value="{{ $packageMembership->id }}" style="display:none;" />

                    <div class="row" style="padding-bottom:2rem;">
                        <div class="col-sm-12">
                            <?php $total = $data['total']; ?>
                            <table class="table-responsive table-checkout" style="width:100%;">
                                <tbody>
                                    <tr>
                                        <th>PAKET MEMBERSHIP</th>
                                        <th>Duration</th>
                                        <th>Exp</th>
                                        <th>Price</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $packageMembership->shift_name }} - {{ $packageMembership->name }}</td>
                                        <td>{{ $packageMembership->description }}</td>
                                        <td>{{ $packageMembership->expired }} Hari</td>
                                        <td style="font-size: 20px;font-weight: 700;">IDR {{ number_format($data['grand_total']) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="font-weight:bold;">Total</td>
                                        <td style="font-size: 20px;font-weight: 700;">IDR {{ number_format($total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="form-group">
                                <input class="agree-term" type="checkbox" name="checkbox" id="terms_1" />
                                <label for="terms_1" class="label-agree-term"><span><span></span></span>
                                    Dengan mencentang kotak di sebelah kiri saya menyatakan menyetujui dan paham dari isi syarat dan ketentuan yang berlaku di Fitnessworks
                                    <a href="{{ URL::asset('assets/docs/Syarat & Ketentuan Fitnessworks.pdf'); }}" target="_blank" class="terms-syarat">Lihat Syarat & Ketentuan</a>
                                </label>
                            </div>

                            <div class="form-group">
                                <input class="agree-term" type="checkbox" name="checkbox" id="terms_2" />
                                <label for="terms_2" class="label-agree-term"><span><span></span></span>
                                    Dengan mencentang kotak di sebelah kiri saya menyatakan menyetujui dan paham dari isi surat penyerahan tuntutan
                                    <a href="{{ URL::asset('assets/docs/Surat Penyerahan Tuntutan Fitnessworks.pdf'); }}" target="_blank" class="terms-tuntutan">Lihat Surat Penyerahan Tuntutan</a>
                                </label>
                            </div>

                            <div class="form-group">
                                <input class="agree-term" type="checkbox" name="terms_3" id="terms_3" />
                                <label for="terms_3" class="label-agree-term"><span><span></span></span>
                                    Dengan mencentang kotak di sebelah kiri saya menyetujui menerima dan mengikuti semua update, promo, dan informasi Fitnessworks
                                </label>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="float:right;" id="orderButton">Pembayaran</button>

                </div>
            </form>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $(':input[type="submit"]').prop('disabled', true);

        $(".agree-term").change(function() {
            if ($('#terms_1').is(':checked') && $('#terms_2').is(':checked') && $('#terms_3').is(':checked')) {
                $(':input[type="submit"]').prop('disabled', false);
            } else {
                $(':input[type="submit"]').prop('disabled', true);
            }
        });
    });
</script>

@endsection