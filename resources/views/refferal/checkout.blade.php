@extends('refferal.master')

@section('content')
<div class="container-fluid p0">
    <div class="signup-content h100vh">
        <div class="signup-desc">
            <div class="signup-desc-content" style="padding-left: 30px;padding-right: 30px;padding-top: 25%;text-align:center;">
                <img src="../assets/refferal/img/logo.png" alt="" class="img-fluid img-logo">
            </div>
        </div>
        <div class="signup-form-conent">
            <form method="POST" action="/refferal/order" id="signup-form" class="signup-form" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form-group">

                    <div class="row">
                        <div class="col-sm-12">
                            <p style="font-size: 25px; font-weight:900;text-transform: uppercase;padding-bottom: 2rem;">
                                Pastikan paket Membership cocok untuk dukung resolusi body goalsmu!!!
                            </p>
                        </div>
                    </div>

                    <input type="text" name="checkout_id" id="checkout_id" value="{{ $data['checkout_number'] }}" style="display:none;" />
                    <input type="text" name="lead_id" id="lead_id" value="{{ $leadId }}" style="display:none;" />
                    <input type="text" name="club_id" id="club_id" value="{{ $clubId }}" style="display:none;" />
                    <input type="text" name="package_membership_id" id="package_membership_id" value="{{ $packageMembership->id }}" style="display:none;" />
                    <input type="text" name="package_trainer_id" id="package_trainer_id" value="{{ isset($packageTrainer) ? $packageTrainer->id : '' }}" style="display:none;" />

                    <div class="row" style="padding-bottom:2rem;">
                        <div class="col-sm-12">
                            <?php $total = $data['total']; ?>
                            <table class="table-responsive table-checkout">
                                <tbody>
                                    <tr>
                                        <th style="width:15%;">PAKET MEMBERSHIP</th>
                                        <th style="width:20%;">Duration</th>
                                        <?php if ($data['type_payment'] == 'eft') { ?>
                                            <th style="width:20%;">Description</th>
                                        <?php } ?>
                                        <th style="width: 10%;">Exp</th>
                                        <th style="width:20%;">Price</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $packageMembership->shift_name }} - {{ $packageMembership->name }}</td>
                                        <td>{{ $packageMembership->description }}</td>
                                        <?php if ($data['type_payment'] == 'eft') { ?>
                                            <td>(First Month Payment + Last Month Payment)</td>
                                        <?php } ?>
                                        <td>{{ $packageMembership->expired }}</td>
                                        <td style="font-size: 20px;font-weight: 700;">IDR {{ number_format($data['grand_total']) }}</td>
                                    </tr>
                                    <?php if (isset($packageTrainer)) { ?>
                                        <tr>
                                            <th>PERSONAL TRAINER SESSION</th>
                                            <th>Session</th>
                                            <th>Exp</th>
                                            <th>Price</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $packageTrainer->name }} - {{ $packageTrainer->description }}</td>
                                            <td>{{ $packageTrainer->session }} Session</td>
                                            <td>{{ $packageTrainer->expired }} Days</td>
                                            <td style="font-size: 20px;font-weight: 700;">IDR {{ number_format($packageTrainer->price) }}</td>
                                        </tr>
                                        <?php $total += $packageTrainer->price; ?>
                                    <?php } ?>
                                    <tr>
                                        <?php if ($data['type_payment'] == 'eft') { ?>
                                            <td colspan="3"></td>
                                        <?php } else { ?>
                                            <td colspan="2"></td>
                                        <?php } ?>
                                        <td style="font-weight:bold;">Total</td>
                                        <td style="font-size: 20px;font-weight: 700;">IDR {{ number_format($total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                <input class="form-check-input check-terms" type="checkbox" name="terms_1" id="terms_1">
                                <label class="form-check-label" for="terms_1" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                    Dengan mencentang kotak di sebelah kiri saya menyatakan menyetujui dan paham dari isi syarat dan ketentuan yang berlaku di Fitnessworks
                                    <a href="{{ URL::asset('assets/docs/Syarat & Ketentuan Fitnessworks.pdf'); }}" target="_blank" class="terms-syarat">Lihat Syarat & Ketentuan</a>
                                </label>
                            </div>

                            <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                <input class="form-check-input check-terms" type="checkbox" name="terms_2" id="terms_2">
                                <label class="form-check-label" for="terms_2" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                    Dengan mencentang kotak di sebelah kiri saya menyatakan menyetujui dan paham dari isi surat penyerahan tuntutan
                                    <a href="{{ URL::asset('assets/docs/Surat Penyerahan Tuntutan Fitnessworks.pdf'); }}" target="_blank" class="terms-tuntutan">Lihat Surat Penyerahan Tuntutan</a>
                                </label>
                            </div>

                            <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                <input class="form-check-input check-terms" type="checkbox" name="terms_3" id="terms_3">
                                <label class="form-check-label" for="terms_3" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                    Dengan mencentang kotak di sebelah kiri saya menyetujui menerima dan mengikuti semua update, promo, dan informasi Fitnessworks
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Pembayaran</button>

                </div>
            </form>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $(':input[type="submit"]').prop('disabled', true);

        $(".check-terms").change(function() {
            if ($('#terms_1').is(':checked') && $('#terms_2').is(':checked') && $('#terms_3').is(':checked')) {
                $(':input[type="submit"]').prop('disabled', false);
            } else {
                $(':input[type="submit"]').prop('disabled', true);
            }
        });

        $("#type_order").change(function () {
            var selectedValue = $(this).val();

            if (selectedValue == "online" || selectedValue == "cash" || selectedValue == "") {
                $('#card_number').prop('disabled', true);
                $('#required_card_number').addClass('d-none');
            } else {
                $('#required_card_number').removeClass('d-none');
                $('#card_number').prop('disabled', false);
                $('#card_number').removeClass('is-invalid');
            }
        })

        // $(".terms-syarat").click(function() {
        //     Swal.fire({
        //         html: '<p class="header-rule-1">Syarat dan Ketentuan keanggotaan</p>, ' +
        //             '<p class="header-rule-2"></p> ',
        //         showCloseButton: true,
        //         showConfirmButton: false,
        //     })
        // });

        // $(".terms-tuntutan").click(function() {
        //     Swal.fire({
        //         html: '<p class="header-rule-1">Harap Baca Dokumen Ini dengan Teliti</p>, ' +
        //             '<p class="header-rule-2"></p> ',
        //         showCloseButton: true,
        //         showConfirmButton: false,
        //     })
        // });
    });
</script>

@endsection
