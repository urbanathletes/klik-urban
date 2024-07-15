    @extends('master')

    @section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Refferal Form Fitnessworks" />
    <title>Fitnessworks - Refferal</title>
    <link rel="icon" href="{{ URL::asset('../assets/refferal/img/favicon.ico'); }}">
    <link rel="stylesheet" href="{{ URL::asset('../assets/refferal/css/bootstrap/bootstrap.css'); }}" />
    <link rel="stylesheet" href="{{ URL::asset('../assets/refferal/fonts/material-icon/css/material-design-iconic-font.min.css'); }}">
    <link rel="stylesheet" href="{{ URL::asset('../assets/refferal/font-awesome/all.css'); }}">
    <script src="{{ URL::asset('../assets/refferal/vendor/jquery/jquery.min.js'); }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="main">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <img src="assets/img/promo/special-deal/Logo-UA.png" alt="" class="img-logo">
                        <h1 class="header-1">GET FREE TRIAL!!</h1>
                        <hr class="separator">
                        <p class="detail-1">
                            Mulailah fitness journey Anda dengan cara klaim <br>
                            voucher Free Trial di Urban Athletes! Nikmati <br>
                            puluhan jenis kelas setiap minggunya dan rasakan <br>
                            fitness dengan fasilitas premium. <br>
                            Klaim voucher sekarang!
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
                                <h2 class="form-title" style="text-align: left;">NIKMATI FREE TRIAL ANDA SEKARANG JUGA!!!</h2>
                                <div class="form-group">
                                    <label for="full_name" class="normal" style="font-weight: 600;margin-left: 5px;">Nama Lengkap<span style="color:red;"> *</span></label>
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
                                    <label for="phone" class="normal" style="font-weight: 600;margin-left: 5px;">No Handphone<span style="color:red;"> *</span></label>
                                    <input type="text" class="form-input number" name="phone" id="phone" placeholder="" required />
                                    @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="club_id" class="normal" style="font-weight: 600;margin-left: 5px;">Club yang dipilih<span style="color:red;"> *</span></label>
                                    <select class="form-select" id="club_id" name="club_id" data-placeholder="Pilih club" <?= ($withClub ? "disabled" : "") ?>>
                                        <?php foreach ($club as $r => $v) {
                                            if ($v->id == 14 || $v->id == 15) { ?>
                                                <option value="{{ $v->id }}" <?= ($v->is_active == 0 ? "disabled" : "") ?>>
                                                    {{ $v->name }} <?= ($v->is_active == 0 ? "<p style='text-align:right;font-color:red;font-size:10px;'>(Coming Soon)</p>" : "") ?>
                                                </option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="time_call" class="normal" style="font-weight: 600;margin-left: 5px;">Pilih waktu untuk dihubungi<span style="color:red;"> *</span></label>
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
                                <!-- <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="agree-term" class="agree-term" />
                                    <label for="agree-term" class="label-agree-term"><span><span></span></span>Saya telah membaca dan menyetujui <a href="#" class="term-service">Syarat Ketentuan</a> Berlaku</label>
                                    <br>
                                    @if ($errors->has('checkbox'))
                                    <span class="text-danger">{{ $errors->first('checkbox') }}</span>
                                    @endif
                                </div> -->
                                <div class="form-group">
                                    @csrf
                                    <input type="button" name="benefit" id="benefit" class="button-benefit" value="Member Benefit" />
                                    <input type="button" name="submit-s" id="submit" class="form-submit" value="Submit" />
                                    <input type="submit" name="submit" id="real-submit" class="form-submit" style="display:none" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>

    <script>
        // $("form").submit(function() {
        //     $("#club_id").prop("disabled", false);
        // });

        $(".button-benefit").click(function() {
            Swal.fire({
                html: '<p class="header-rule-1">Member Benefit Urban Athletes :</p>' +
                    '<div class="row d-flex justify-content-center">' +
                    ' <div class="col-lg-2 col-md-6"><img src="assets/specialdeal/img/benefit-1.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis akses puluhan jenis exersice</p></div>' +
                    ' <div class="col-lg-2 col-md-6"><img src="assets/specialdeal/img/benefit-2.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis fasilitas sauna untuk Urban Athletes Lenmarc</p></div>' +
                    ' <div class="col-lg-2 col-md-6"><img src="assets/specialdeal/img/benefit-3.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis fasilitas kolam renang untuk Urban Athletes Gunawangsa Merr dan Tidar</p></div>' +
                    ' <div class="col-lg-2 col-md-6"><img src="assets/specialdeal/img/benefit-4.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis cek komposisi tubuh dan konsultasi dengan Personal Trainer</p></div>' +
                    ' <div class="col-lg-2 col-md-6"><img src="assets/specialdeal/img/benefit-5.png" class="img-fluid" loading="lazy"><p class="benefit-font">Gratis 1x (satu kali) kelas The Valor</p></div>' +
                    '</div>',
                customClass: 'swal-wide',
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

        $('#submit').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            Swal.fire({
                html: '<p style="color:#000000" class="header-rule-1">Syarat dan ketentuan Free Trial :</p>' +
                    '<table style="color:#000000" class="table-responsive table-rule"><tbody> ' +
                    '<tr><td style="vertical-align: top;min-width:25px;">1</td><td>Free trial di tujukan untuk non-member yang belum pernah menjadi member dan atau belum pernah melakukan free trial sebelumnya dalam waktu 6 bulan kebelakang.</td></tr>' +
                    '<tr><td style="vertical-align: top;min-width:25px;">2</td><td>Wajib membawa ID Card (KTP/Paspor/SIM/Kartu Pelajar/Kartu Keluarga) sebagi tanda pengenal saat akan melakukan aktivasi.</td></tr>' +
                    '<tr><td style="vertical-align: top;min-width:25px;">3</td><td>Free trial tidak bisa di uangkan dalam bentuk apapun.</td></tr>' +
                    '<tr><td style="vertical-align: top;min-width:25px;">4</td><td>Berlaku untuk usia minimal 18 tahun keatas.</td></tr>' +
                    '<tr><td style="vertical-align: top;min-width:25px;">5</td><td>Free trial harus di gunakan secara berturut-turut.</td></tr>' +
                    '<tr><td style="vertical-align: top;min-width:25px;">6</td><td>Free trial tidak bisa di pindah tangankan.</td></tr>' +
                    '<tr><td style="vertical-align: top;min-width:25px;">7</td><td>Wajib membawa kunci loker dan handuk sendiri serta mengenakan pakaian olahraga lengkap.</td></tr>' + '</tbody></table>' +
                    '<div style="text-align:left;"><input type="checkbox" name="checkbox" id="agree-term" class="agree-term" />' +
                    '<label for="agree-term" class="label-agree-term" style="color:black; font-weight: bold;"><span><span></span></span>Saya telah membaca dan menyetujui <a href="#" class="term-service" style="color:#0038FF!important;">Syarat Ketentuan</a> Berlaku</label>' +
                    '<hr>',
                showCloseButton: true,
                showConfirmButton: true,
                customClass: {
                    container: 'custom-swal-container',
                    popup: 'custom-swal-popup',
                },
                width: '957px',
                height: '447px',
                backdrop: 'rgba(0,0,123,0.4)',
                allowOutsideClick: false,
                confirmButtonColor: '#0D0D0D',
                confirmButtonText: 'JOIN SEKARANG',
            }).then((result) => {
                if ($('#agree-term').is(':checked')) {
                    if (result.isConfirmed) {
                        $("#club_id").prop("disabled", false);
                        $('#real-submit').trigger('click');
                    }
                } else {
                    Swal.fire('Syarat & Ketentuan harus disetujui', '', 'error')
                }
            });
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
    @if (session()->has('message'))
    <script>
        Swal.fire({
            html: `
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .separator {
            border: 10;
            height: 2px;
            margin: 20px 0;
            background: #000;
        }

         .container {
            width: 721px;
            height: 563px;
            padding: 20px;
            box-sizing: border-box;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
        }
            
        .container img.logo {
            max-width: 40%;
            height: auto;
        }

        .container img.icon {
            max-width: 30px;
            height: auto;
            margin: 0 10px;
        }

        .container img.small-icon {
            max-width: 40px;
            height: auto;
            margin: 10px 0;
        }

        .container h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .container p {
            font-size: 14px;
            font-weight: bold;
        }

        .container .download-icons img {
            max-width: 100px;
            height: auto;
            margin: 10px;
        }

        .container .download-text {
            font-size: 1.25rem;
            font-weight: bold;
            margin: 20px 0;
        }

        .container .message {
            font-size: 16 px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        @media only screen and (max-device-width: 640px) {
            .container {
                width: 100%;
                height: auto;
                padding: 10px;
            }

            .container h2 {
                font-size: 1.25rem;
            }

            .container p {
                font-size: 0.875rem;
            }

            .container .download-icons img {
                max-width: 80px;
            }

            .container .download-text {
                font-size: 1rem;
            }

            .container img.small-icon {
                max-width: 30px;
            }

            .container .message {
                font-size: 8px;
                font-weight: 500;
            }
        }
    </style>
    <div class="container">
        <img src="../assets/img/logoUA-tem.png" alt="Urban Athletes" class="logo">
        <hr class="separator">
        <div style="display: flex; align-items: center; justify-content: center;">
            <img src="../assets/img/celebrate.png" alt="Celebration Icon" class="icon">
            <h2>SELAMAT!</h2>
            <img src="../assets/img/celebrate.png" alt="Celebration Icon" class="icon">
        </div>
        <p class="message">Terima kasih telah mendaftar Freetrial Urban Athletes!<br>Cek email Anda untuk akun akses dan<br>download aplikasi Member Urban Athletes.<br>Ayo mulai latihan Anda dan jadilah yang terbaik! 💪</p>
        <div>
            <a href="https://apps.apple.com/id/app/fitnessworks/id1637403401?l=id">
                <img src="../assets/img/UA-Vector.png" alt="Download on the App Store" class="small-icon">
            </a>
        </div>
        <div class="download-text">Download Now</div>
        <div class="download-icons">
            <a href="https://play.google.com/store/apps/details?id=com.fitnessworks">
                <img src="../assets/img/playstore.png" alt="Get it on Google Play" class="download-icon">
            </a>
            <a href="https://apps.apple.com/id/app/fitnessworks/id1637403401?l=id">
                <img src="../assets/img/apss.png" alt="Download on the App Store" class="download-icon">
            </a>
        </div>
    </div>`,
            showCloseButton: false,
            showConfirmButton: false,
        });
    </script>
    {{ session()->get('message') }}
    @endif
    @endsection