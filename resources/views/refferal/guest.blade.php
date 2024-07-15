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
            <form method="POST" action="/refferal/save-guest" id="signup-form" class="signup-form" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="form-group">

                    <div class="row">
                        <div class="col-sm-12">
                            <p style="font-size: 25px; font-weight:900;text-transform: uppercase;padding-bottom: 2rem;">
                                Lengkapi data diri untuk mendapatkan akses ke aplikasi!!!
                            </p>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 1rem;">
                        <div class="col-sm-6">
                            <label for="club_id" class="normal">Club<span style="color:red;"> *</span></label>
                            <select class="form-select @error('club_id') is-invalid @enderror" id="club_id" name="club_id">
                                <option selected value="">-- Select Club --</option>
                                @foreach ($clubList as $club)
                                <option value="{{ $club['id'] }}">{{ $club['name'] }}</option>
                                @endforeach
                            </select>
                            @error('club_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="refferal_code" class="normal">Refferal Code<span style="color:red;"> *</span></label>
                            <input type="text" name="refferal_code" id="refferal_code" value="{{ $refferalCode }}" readonly />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="full_name" class="normal">Nama lengkap kamu<span style="color:red;"> *</span></label>
                            <input type="text" name="name" id="name" required />
                        </div>

                        <div class="col-sm-6">
                            <label for="age" class="normal">Berapa usia kamu<span style="color:red;"> *</span></label>
                            <input type="text" name="age" id="age" class="number" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="phone" class="normal">Phone Number<span style="color:red;"> *</span></label>
                            <input type="text" name="phone" id="phone" class="number" required />
                        </div>

                        <div class="col-sm-6">
                            <label for="email" class="normal">Email<span style="color:red;"> *</span></label>
                            <input type="email" name="email" id="email" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="instagram" class="normal">Instagram</label>
                            <input type="text" name="instagram" id="instagram" />
                        </div>

                        <div class="col-sm-6">
                            <label for="work" class="normal">Apa pekerjaan kamu</label>
                            <input type="text" name="work" id="work" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="company_name" class="normal">Nama perusahaan tempat kamu bekerja</label>
                            <input type="text" name="company_name" id="company_name" />
                        </div>

                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="text-question" style="font-size: 14px; font-weight: bold; color: black;padding-bottom:1rem;">
                                        Mengisi Beberapa Pertanyaan Untuk Guest Profile
                                    </p>
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                                <input class="form-check-input" type="radio" name="guest_profile" value="1" id="guest_profile_yes">
                                                <label class="form-check-label" for="guest_profile" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                                    Ya
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                                <input class="form-check-input" type="radio" name="guest_profile" value="0" id="guest_profile_no" checked>
                                                <label class="form-check-label" for="guest_profile" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                                    Tidak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Selanjutnya</button>

                </div>
            </form>

        </div>
    </div>

</div>

<script>
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