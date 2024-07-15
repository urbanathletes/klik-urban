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
            <form method="POST" action="/refferal/choose-package" id="choose-form" class="signup-form" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <input type="text" name="club_id" id="club_id" value="{{ $clubId }}" style="display:none;" />
                <input type="text" name="lead_id" id="lead_id" value="{{ $leadId }}" style="display:none;" />
                <input type="text" name="package_membership_id" id="package_membership_id" value="" style="display:none;" />
                <input type="text" name="package_trainer_id" id="package_trainer_id" value="" style="display:none;" />

                <h3></h3>
                <fieldset>
                    <div class="row">
                        <div class="col-sm-12">
                            <p style="font-size: 25px; font-weight:900;text-transform: uppercase;padding-bottom: 2rem;">
                                Pilih berbagai penawaran paket <br>
                                terbaik kami!!!
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" style="text-align: center;padding-bottom: 3rem;">
                            <?php foreach ($allShift as $r => $v) { ?>
                                <button type="button" class="btn btn-card btn-shift {{ $r == 0 ? 'checked' : ''; }}" data-id="{{ $v->id }}">
                                    <p style="text-transform: uppercase;font-weight:600;">{{ $v->name }}</p>
                                    <p style="font-size:13px;">{{ $v->description }}</p>
                                </button>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row package-all">
                        <?php foreach ($packageAll as $row => $value) { ?>
                            <div class="col-lg-3 shift_{{ $value->shift_id }} shift-all">
                                <div class="" style="padding-bottom: 2rem;">
                                    <div class="card">
                                        <div class="card-head" style="min-height: 95px;">
                                            <p style="font-size: 15px;font-weight: 600;color: #fecc09;">{{ $value->name }}</p>
                                            <?php if ($value->membership_payment_id == 1) { ?>
                                                <p style="font-size: 16px;font-weight: 700;">IDR {{ number_format($value->price/12) }}</p>
                                            <?php } else { ?>
                                                <p style="font-size: 16px;font-weight: 700;">IDR {{ number_format($value->price) }}</p>
                                            <?php } ?>
                                        </div>
                                        <div class="card-body" style="font-size:12px;">
                                            <p style="padding: 0.5rem;"><i style="color: #261f53;" class="fa-solid fa-circle-check"></i>&nbsp;&nbsp; {{ $value->description }}</p>
                                            <p style="padding: 0.5rem;"><i style="color: #261f53;" class="fa-solid fa-circle-check"></i>&nbsp;&nbsp; {{ $value->shift_name }} ({{ $value->shift_start }})</p>
                                            <?php if ($value->membership_payment_id == 1) { ?>
                                                <p style="padding: 0.5rem;"><i style="color: #261f53;" class="fa-solid fa-circle-check"></i>&nbsp;&nbsp; IDR {{ number_format($value->price/12) }} / Month</p>
                                                <p style="padding: 0.5rem;"><i style="color: #261f53;" class="fa-solid fa-circle-check"></i>&nbsp;&nbsp; Payment of the first and last month in advance (IDR {{ number_format(($value->price/12)*2) }} + admin fee)</p>
                                                <p style="padding: 0.5rem;"><i style="color: #261f53;" class="fa-solid fa-circle-check"></i>&nbsp;&nbsp; Minimum 12 Month Membership</p>
                                            <?php } else { ?>
                                                <p style="padding: 0.5rem;"><i style="color: #261f53;" class="fa-solid fa-circle-check"></i>&nbsp;&nbsp; IDR {{ number_format($value->price/$value->month) }} / Month</p>
                                            <?php } ?>
                                            <br>
                                        </div>
                                        <div class="card-footer">
                                            <div class="card-button" style="text-align:center;">
                                                <button type="button" class="btn btn-card btn-choose-package" data-id="{{ $value->id }}" style="min-height: 62px;">Choose Package</button>
                                            </div>
                                        </div>
                                        <div class="recommend">
                                            <?php if ($value->recommend == 'yes') { ?>
                                                <p style="font-size: 15px;font-weight: 600;color: #261f53;text-align: center;background: #fecc09;">Rekomendasi</p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </fieldset>

            </form>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var shiftId = $('.checked').data("id");
        $('.shift-all').hide();
        $('.shift_' + shiftId).show();

        var session = $('.checked-trainer').data("id");
        $('.trainer-all').hide();
        $('.' + session).show();

        $(".btn-shift").click(function() {
            $(".btn-shift").removeClass("checked");
            $(this).addClass("checked");
            var shiftId = $(this).data("id");
            $('.shift-all').hide();
            $('.shift_' + shiftId).show();
        });

        $(".btn-trainer").click(function() {
            $(".btn-trainer").removeClass("checked-trainer");
            $(this).addClass("checked-trainer");
            var session = $(this).data("id");
            $('.trainer-all').hide();
            $('.' + session).show();
        });

        $(".btn-choose-package").click(function() {
            $(".btn-choose-package").removeClass("checked-choose");
            $('#package_membership_id').val('');
            $('.btn-choose-package').text('Choose Package');

            $(this).addClass("checked-choose");
            $(this).text('Selected');
            $('#package_membership_id').val($(this).data("id"));
        });

        $(".btn-choose-trainer").click(function() {
            $(".btn-choose-trainer").removeClass("checked-choose");
            $('#package_trainer_id').val('');
            $('.btn-choose-trainer').text('Choose Package');

            $(this).addClass("checked-choose");
            $(this).text('Selected');
            $('#package_trainer_id').val($(this).data("id"));
        });

        var $input = $('<li aria-hidden="false"><a href="#" class="rule-presale" role="menuitem" style="background: #fecc09;color: #261f53; display:none;">Ketentuan Pre-sale</a></li>');
        $input.insertBefore($('li[aria-hidden=false]'));

        $(".rule-presale").click(function() {
            Swal.fire({
                html: '<p class="header-rule-1">Periode promo <br> pre-sale Fitnessworks</p>, ' +
                    '<p class="header-rule-2">Dapatkan Extra jam akses selama periode promo. Tunggu apalagi, Daftar sekarang untuk dapatkan extra bonusnya!!!</p> ' +
                    '<table class="table-responsive table-rule"><tbody> ' +
                    '<tr><td>Periode Pembelian</td><td>Bonus Extra</td></tr>' +
                    '<tr><td>Bulan Februari</td><td>Extra 4 Jam Akses</td></tr>' +
                    '<tr><td>Bulan Maret</td><td>Extra 3 Jam Akses</td></tr>' +
                    '<tr><td>Bulan April</td><td>Extra 2 Jam Akses</td></tr>' +
                    '<tr><td>Bulan Mei</td><td>Extra 1 Jam Akses</td></tr>' +
                    '</tbody></table>',
                showCloseButton: true,
                showConfirmButton: false,
            })
        });
    });
</script>

@endsection