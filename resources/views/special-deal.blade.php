@extends('master')

@section('content')

<div class="main">

    <section class="signup">
        <!-- <img src="images/signup-bg.jpg" alt=""> -->
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <img src="assets/img/logo.png" alt="" class="img-logo">
                    <h1 class="header-1">GET SPECIAL DEAL!!</h1>
                    <p class="detail-1">
                        Jangan lewatkan Promo Spesial Deal dari Fitnessworks untuk Anda hari ini!<br>
                        Dapatkan harga khusus untuk pendaftaran membership di Fitnessworks. <br>
                        Bergabunglah dengan ribuan member lainnya dan rasakan nikmatnya ngegym dengan fasilitas premium.
                        Segera daftar sekarang!
                    </p>
                </div>
                <div class="col-sm-5">
                    <div class="signup-content">

                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                            Session::forget('success');
                            @endphp
                        </div>
                        @endif

                        <!-- Way 1: Display All Error Messages -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" id="signup-form" class="signup-form">
                            {{ csrf_field() }}
                            <h2 class="form-title" style="text-align: left;">DAPATKAN PROMO MENARIK SEKARANG JUGA!!!
                            </h2>
                            <div class="form-group">
                                <label for="full_name" class="normal" style="font-weight: 600;margin-left: 5px;">Nama
                                    Lengkap<span style="color:red;"> *</span></label>
                                <input type="text" class="form-input" name="name" id="name" placeholder="" required />
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email" class="normal" style="font-weight: 600;margin-left: 5px;">Email<span style="color:red;"> *</span></label>
                                <input type="email" class="form-input" name="email" id="email" placeholder="" required />
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="phone" class="normal" style="font-weight: 600;margin-left: 5px;">No
                                    Handphone<span style="color:red;"> *</span></label>
                                <input type="text" class="form-input number" name="phone" id="phone" placeholder="" required />
                                @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="club_id" class="normal" style="font-weight: 600;margin-left: 5px;">Club yang
                                    dipilih<span style="color:red;"> *</span></label>
                                <select class="form-select" id="club_id" name="club_id" data-placeholder="Pilih club" <?= ($withClub ? "disabled" : "") ?>>
                                    <?php foreach ($club as $r => $v) { ?>
                                        <option value="{{ $v->id }}" <?= ($v->is_active == 0 ? "disabled" : "") ?>>
                                            {{ $v->name }}
                                            <?= ($v->is_active == 0 ? "<p style='text-align:right;font-color:red;font-size:10px;'>(Coming Soon)</p>" : "") ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="time_call" class="normal" style="font-weight: 600;margin-left: 5px;">Pilih
                                    waktu untuk dihubungi<span style="color:red;"> *</span></label>
                                <input style="display:none;" type="text" class="form-input" name="time_call" id="time_call" placeholder="" />
                                <div class="row">
                                    <div class="col-sm-4" style="text-align: center;">
                                        <button onclick="selectTime(this)" value="pagi" class="btn-time" type="button" style="width:100%;border-radius: 15px;background-color: white;height: 40px;">Pagi</button>
                                    </div>
                                    <div class="col-sm-4" style="text-align: center;">
                                        <button onclick="selectTime(this)" value="siang" class="btn-time" type="button" style="width:100%;border-radius: 15px;background-color: white;height: 40px;">Siang</button>
                                    </div>
                                    <div class="col-sm-4" style="text-align: center;">
                                        <button onclick="selectTime(this)" value="malam" class="btn-time" type="button" style="width:100%;border-radius: 15px;background-color: white;height: 40px;">Malam</button>
                                    </div>
                                </div>
                                @if ($errors->has('time_call'))
                                <span class="text-danger">{{ $errors->first('time_call') }}</span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="checkbox" name="checkbox" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>Saya telah
                                    membaca dan menyetujui <a href="#" class="term-service">Syarat Ketentuan</a>
                                    Berlaku</label>
                                <br>
                                @if ($errors->has('checkbox'))
                                <span class="text-danger">{{ $errors->first('checkbox') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="button" name="benefit" id="benefit" class="button-benefit" value="Member Benefit" />
                                <input type="submit" name="submit" id="submit" class="form-submit" value="Submit" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

</div>

<script>
    $("form").submit(function() {
        $("#club_id").prop("disabled", false);
    });

    $(".button-benefit").click(function() {
        Swal.fire({
            html: '<p class="header-rule-1">Member Benefit Fitnessworks :</p>' +
                '<div class="row d-flex justify-content-center">' +
                ' <div class="col-lg-2 col-md-6"><img src="assets/img/benefit-1.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis akses puluhan jenis exersice</p></div>' +
                ' <div class="col-lg-2 col-md-6"><img src="assets/img/benefit-2.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis fasilitas gym area premium</p></div>' +
                ' <div class="col-lg-2 col-md-6"><img src="assets/img/benefit-3.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis fasilitas studio kelas eksklusif</p></div>' +
                ' <div class="col-lg-2 col-md-6"><img src="assets/img/benefit-4.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis cek komposisi tubuh (In Body)</p></div>' +
                ' <div class="col-lg-2 col-md-6"><img src="assets/img/benefit-5.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis fasilitas konsultasi dengan Personal Trainer</p></div>' +
                '</div>',
            customClass: 'swal-wide',
            showCloseButton: true,
            showConfirmButton: false,
        })
    });

    $(".term-service").click(function() {
        Swal.fire({
            html: '<p class="header-rule-1">Syarat dan ketentuan Special Deal :</p>' +
                '<table class="table-responsive table-rule"><tbody> ' +
                '<tr><td style="vertical-align: top;">1</td><td>Jenis promo bisa berubah, mengikuti sesuai periode promo yang sedang berlaku.</td></tr>' +
                '<tr><td style="vertical-align: top;">2</td><td>Promo ditujukan untuk pembelian program membership dan atau paket personal trainer.</td></tr>' +
                '<tr><td style="vertical-align: top;">3</td><td>Detail promo akan di jelaskan secara rinci oleh tim Fit Consultant Fitnessworks.</td></tr>' +
                '<tr><td style="vertical-align: top;">4</td><td>Penawaran bersifat terbatas pada periode dan kuota promo, amankan kuota segera!</td></tr>' +
                '</tbody></table>',
            showCloseButton: true,
            showConfirmButton: false,
        })
    });

    function selectTime(elem) {
        var value = elem.getAttribute('value');
        $('.btn-time').removeClass("btn-active");
        if ($(elem).hasClass("btn-active")) {
            $(elem).removeClass("btn-active");
        } else {
            $(elem).addClass("btn-active");
            $('#time_call').val(value);
        }
    }

    $(':input[type="submit"]').prop('disabled', true);

    $(".agree-term").change(function() {
        if ($('#agree-term').is(':checked')) {
            $(':input[type="submit"]').prop('disabled', false);
        } else {
            $(':input[type="submit"]').prop('disabled', true);
        }
    });

    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        };
    }(jQuery));
    $(document).ready(function() {
        $(".number").inputFilter(function(value) {
            return /^\d*$/.test(value); // Allow digits only, using a RegExp
        });
    });
</script>
@endsection