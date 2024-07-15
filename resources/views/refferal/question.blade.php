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
            <form method="POST" action="/refferal/unlock-membership" id="signup-form" class="signup-form" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <input type="text" name="lead_id" id="lead_id" value="{{ $leadId }}" style="display:none;" />

                <?php foreach ($questionList as $row => $value) {  ?>

                    <h3></h3>
                    <fieldset>
                        <span class="step-current">Step {{ ($row) }} / {{ (count($questionList)) }}</span>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p style="font-size: 25px; font-weight:900;text-transform: uppercase;padding-bottom: 2rem;">
                                        Isi kuisioner untuk dapatkan <br>
                                        harga presale yang paling cocok <br>
                                        dengan kebutuhan kamu!!!
                                    </p>
                                </div>
                            </div>

                            <?php foreach ($value as $r => $v) { ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="text-question" style="font-size: 14px; font-weight: bold; color: black;padding-bottom:1rem;">
                                            {{$v['question']}}
                                        </p>

                                        <?php if ($v['confirmation'] == '1') { ?>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                                        <input class="form-check-input" type="radio" name="question_confirmation_{{$v['id']}}" value="1" id="confirmation_yes_{{$v['id']}}">
                                                        <label class="form-check-label" for="confirmation_{{$vv['id']}}" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                                            Yes
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-1">
                                                    <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                                        <input class="form-check-input" type="radio" name="question_confirmation_{{$v['id']}}" value="0" id="confirmation_no_{{$v['id']}}">
                                                        <label class="form-check-label" for="confirmation_{{$vv['id']}}" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $("input[name$='question_confirmation_{{$v['id']}}']").click(function() {
                                                    var val = $(this).val();
                                                    if (val == 1) {
                                                        $("#confirmation_{{$v['id']}}").show();
                                                    } else {
                                                        $("#confirmation_{{$v['id']}}").hide();
                                                    }
                                                });
                                            });
                                        </script>

                                        <div class="row" style=<?= ($v['confirmation'] == '1' ? "display:none" : "") ?> id="confirmation_{{$v['id']}}">
                                            <?php $maxRow = $v['type_grid'];
                                            $currentRow = 0;
                                            foreach ($v['detail'] as $rr => $vv) { ?>

                                                <?php if ($currentRow == $maxRow) {  ?>
                                        </div>
                                    <?php } ?>

                                    <?php if ($rr == 0 || $currentRow == $maxRow) {
                                                    $currentRow = 0; ?>
                                        <div class="col-sm-3" style="max-width: 300px;">
                                        <?php } ?>

                                        <div class="form-check" style="padding-left: 2.5em;padding-bottom: 1rem;">
                                            <input class="form-check-input" type=<?= ($v['multiple_answer'] == '1' ? "checkbox" : "radio") ?> name=<?= ($v['multiple_answer'] == '1' ? "question_{$v['id']}[]" : "question_{$v['id']}") ?> value="{{$vv['id']}}" id="flexRadioDefault{{$vv['id']}}">
                                            <label class="form-check-label" for="flexRadioDefault{{$vv['id']}}" style="font-weight: 600;vertical-align: -webkit-baseline-middle;">
                                                {{$vv['answer']}}
                                            </label>
                                        </div>

                                    <?php $currentRow++;
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </fieldset>

                <?php } ?>

            </form>
        </div>
    </div>

</div>
@endsection