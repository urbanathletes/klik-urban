@extends('master')

@section('content')

<style>
    html {
        height: 100% !important;
    }
</style>

<div class="main">

    <section class="signup">
        <!-- <img src="images/signup-bg.jpg" alt=""> -->
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <img src="assets/img/logo.png" alt="" class="img-logo">
                    <h1 class="header-1"></h1>
                    <p class="detail-1"></p>
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

                        @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                            @php
                            Session::forget('error');
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
                            <h2 class="form-title" style="text-align: left;">REQUEST REMOVE ACCOUNT!!!
                            </h2>
                            <div class="form-group">
                                <label for="email" class="normal" style="font-weight: 600;margin-left: 5px;">Email<span style="color:red;"> *</span></label>
                                <input type="email" class="form-input" name="email" id="email" placeholder="" required />
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password" class="normal" style="font-weight: 600;margin-left: 5px;">Password<span style="color:red;"> *</span></label>
                                <input type="password" class="form-input" name="password" id="password" placeholder="" required />
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <input type="checkbox" name="checkbox" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>Agree <a href="#" class="term-service">Terms & Conditions</a> Remove Account</label>
                                <br>
                                @if ($errors->has('checkbox'))
                                <span class="text-danger">{{ $errors->first('checkbox') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
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
    $(".term-service").click(function() {
        Swal.fire({
            html: '<p class="header-rule-1">Terms & Conditions :</p>' +
                '<table class="table-responsive table-rule"><tbody> ' +
                '<tr><td style="vertical-align: top;">1</td><td>Account will be deleted.</td></tr>' +
                '<tr><td style="vertical-align: top;">2</td><td>Account cannot be returned.</td></tr>' +
                '<tr><td style="vertical-align: top;">3</td><td>All packages will be forfeited.</td></tr>' +
                '</tbody></table>',
            showCloseButton: true,
            showConfirmButton: false,
        })
    });

    $(':input[type="submit"]').prop('disabled', true);

    $(".agree-term").change(function() {
        if ($('#agree-term').is(':checked')) {
            $(':input[type="submit"]').prop('disabled', false);
        } else {
            $(':input[type="submit"]').prop('disabled', true);
        }
    });
</script>
@endsection