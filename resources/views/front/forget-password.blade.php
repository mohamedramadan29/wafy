@extends('front.layouts.master')
@section('title')
    نسيت كلمة المرور
@endsection
@section('content')
    <div class="page_content">

        <div class="register_page">
            <div class="container">
                @if (Session::has('Success_message'))
                    <div class="alert alert-success"> {{Session::get('Success_message')}} </div>
                    @php
                        //emotify('success', \Illuminate\Support\Facades\Session::get('Success_message'));

                    @endphp
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger"> {{$error}} </div>
                        @php
                            //  emotify('error', $error);
                        @endphp
                    @endforeach
                @endif
                <div class="data">
                    <div class="row">
                        <div class="col-lg-6 col-12">

                            <div class="account_type">
                                <div class="type seller active" data-target="login">
                                    نسيت كلمة المرور
                                </div>
                            </div>
                            <div class="login active" id="login">
                                <form method="post"
                                      action="@if(isset($step) && $step == 2) {{ url('forget-password-step2') }}
                  @elseif(isset($step) && $step == 3) {{ url('reset-password') }}
                  @else {{ url('forget-password') }}
                  @endif">
                                    @csrf
                                    <div class="box">
                                        <label for="phone">ادخل رقم الهاتف <span class="star"> * </span></label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                               value="@if(isset($phone)) {{ $phone }} @endif">
                                    </div>

                                    @if (isset($step) && $step == 2)

                                        <div class="box">
                                            <label for="confirm_code">  كود التحقق  <span class="star"> * </span> </label>
                                            <div id="code-input">
                                                <input type="text" maxlength="1" class="code-digit form-control" name="confirm_code[]" id="confirm_code1" autofocus>
                                                <input type="text" maxlength="1" class="code-digit form-control" name="confirm_code[]" id="confirm_code2">
                                                <input type="text" maxlength="1" class="code-digit form-control" name="confirm_code[]" id="confirm_code3">
                                                <input type="text" maxlength="1" class="code-digit form-control" name="confirm_code[]" id="confirm_code4">
                                            </div>
                                        </div>

                                    @endif

                                    @if (isset($step) && $step == 3)
                                        <div class="box">
                                            <label for="new_password"> رمز الحماية الجديد  <span class="star"> * </span></label>
                                            <div id="code-input2">
                                                <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password1" autofocus>
                                                <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password2">
                                                <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password3">
                                                <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password4">
                                                <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password5">
                                                <input type="password" maxlength="1" class="code-digit2 form-control" name="new_password[]" id="new_password6">
                                            </div>


                                        </div>


                                        <div class="box">
                                            <label for="confirm_password"> تأكيد رمز الحماية  <span
                                                    class="star"> * </span></label>
                                            <div id="code-input3">
                                                <input type="password" maxlength="1" class="code-digit3 form-control" name="confirm_password[]" id="confirm_password1" autofocus>
                                                <input type="password" maxlength="1" class="code-digit3 form-control" name="confirm_password[]" id="confirm_password2">
                                                <input type="password" maxlength="1" class="code-digit3 form-control" name="confirm_password[]" id="confirm_password3">
                                                <input type="password" maxlength="1" class="code-digit3 form-control" name="confirm_password[]" id="confirm_password4">
                                                <input type="password" maxlength="1" class="code-digit3 form-control" name="confirm_password[]" id="confirm_password5">
                                                <input type="password" maxlength="1" class="code-digit3 form-control" name="confirm_password[]" id="confirm_password6">
                                            </div>


                                        </div>
                                    @endif

                                    <div class="box">
                                        <button type="submit" class="btn btn-primary global_button">
                                            {{ isset($step) && $step == 2 ? 'تحقق من الكود' : (isset($step) && $step == 3 ? 'تحديث كلمة المرور' : 'إرسال') }}
                                        </button>
                                    </div>
                                </form>
                            </div>


                            <style>
                                #code-input,
                                #code-input2,
                                #code-input3{
                                    display: flex;
                                    justify-content: space-between;
                                    max-width: 50%;
                                    direction: ltr; /* يجعل اتجاه الإدخال من اليسار إلى اليمين */
                                }

                                .code-digit2,
                                .code-digit3,
                                .code-digit {
                                    width: 50px;
                                    height: 50px !important;
                                    text-align: center;
                                    margin-right: 5px;
                                    font-size: 20px;
                                    direction: ltr; /* يضمن أن الإدخال يبدأ من اليسار */

                                }
                            </style>

                            <script>
                                const inputs = document.querySelectorAll('.code-digit');

                                // التنقل للأمام عند إدخال رقم
                                inputs.forEach((input, index) => {
                                    input.addEventListener('input', () => {
                                        if (input.value.length === 1 && index < inputs.length - 1) {
                                            inputs[index + 1].focus();
                                        }
                                    });
                                });

                                // التنقل للخلف عند الضغط على Backspace
                                inputs.forEach((input, index) => {
                                    input.addEventListener('keydown', (event) => {
                                        if (event.key === 'Backspace' && input.value.length === 0 && index > 0) {
                                            inputs[index - 1].focus();
                                        }
                                    });
                                });

                            </script>
                            <script>
                                const inputs2 = document.querySelectorAll('.code-digit2');

                                // التنقل للأمام عند إدخال رقم
                                inputs2.forEach((input, index) => {
                                    input.addEventListener('input', () => {
                                        if (input.value.length === 1 && index < inputs2.length - 1) {
                                            inputs2[index + 1].focus();
                                        }
                                    });
                                });

                                // التنقل للخلف عند الضغط على Backspace
                                inputs2.forEach((input, index) => {
                                    input.addEventListener('keydown', (event) => {
                                        if (event.key === 'Backspace' && input.value.length === 0 && index > 0) {
                                            inputs2[index - 1].focus();
                                        }
                                    });
                                });

                            </script>
                            <script>
                                const inputs3 = document.querySelectorAll('.code-digit3');

                                // التنقل للأمام عند إدخال رقم
                                inputs3.forEach((input, index) => {
                                    input.addEventListener('input', () => {
                                        if (input.value.length === 1 && index < inputs3.length - 1) {
                                            inputs3[index + 1].focus();
                                        }
                                    });
                                });

                                // التنقل للخلف عند الضغط على Backspace
                                inputs3.forEach((input, index) => {
                                    input.addEventListener('keydown', (event) => {
                                        if (event.key === 'Backspace' && input.value.length === 0 && index > 0) {
                                            inputs3[index - 1].focus();
                                        }
                                    });
                                });

                            </script>

                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="info">
                                <img src="{{asset('assets/website/uploads/seller.webp')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </
            >
        </div>

    </div>
@endsection
