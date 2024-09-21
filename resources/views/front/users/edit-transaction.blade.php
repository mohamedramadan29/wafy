@extends('front.layouts.master')
@section('title')
    حسابي -  تعديل المعادلة
@endsection
@section('content')
    <div class="page_content">
        <div class="main_dashboard">
            <div class="container">
                <div class="data">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="main_dashboard_sidebar">
                                <div class="user_data">
                                    <div class="image">
                                        @if(auth()->user()->image !='')
                                            <img src="{{asset('assets/uploads/user_images/'.auth()->user()->image)}}" alt="">
                                        @else
                                            <img src="{{asset('assets/uploads/user_images/user_avatar.png')}}" alt="">
                                        @endif
                                    </div>
                                    <div class="info">
                                        <p> مرحبا ، {{ auth()->user()->name }} </p>
                                        <span>  <i class="bi bi-phone"></i>  {{auth()->user()->phone}} </span>
                                    </div>
                                </div>
                                <br>
                                <div class="start_order">
                                    <a href="{{url('user/transactions')}}" class="btn btn-warning global_button">  جميع المعاملات  <i class="bi bi-arrow-left"></i>  </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/add-transaction')}}" class="btn btn-primary global_button"> بدء معاملة جديد <i class="bi bi-plus-circle"></i>  </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/profile')}}" class="btn btn-success global_button"> بيانات حسابي  <i class="bi bi-pencil-square"></i>  </a>
                                    <br>
                                    <br>
                                    <a href="{{url('user/change-password')}}" class="btn btn-danger global_button">  تعديل رمز الحماية   <i class="bi bi-lock"></i> </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="last_order">
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
                                <div class="head_section">
                                    <div>
                                        <h4> تعديل المعاملة </h4>
                                    </div>
                                </div>

                                <div class="add_order">
                                    <form id="CompanyRegister"
                                          action="{{url('user/transaction/edit/'.$transaction['seller_id'].'-'.$transaction['slug'])}}"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="step" id="step1">
                                            <h5> المعلومات العامة </h5>
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="title"> عنوان الاعلان : <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input type="text" name="title" id="title" class="form-control"
                                                               value="{{$transaction['title']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_mark"> الماركة <span class="star"> *  </span>
                                                        </label>
                                                        <select name="car_mark" id="car_mark" class="form-select">
                                                            <option value=""> -- حدد --</option>
                                                            @foreach($marks as $mark)
                                                                <option {{$transaction['question']['car_mark'] == $mark['id'] ? 'selected' : ''}}
                                                                    value="{{$mark['id']}}">{{$mark['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_mark"> النوع <span class="star"> *  </span>
                                                        </label>
                                                        <select name="car_mark_type" id="car_type" class="form-select">

                                                        </select>
                                                    </div>
                                                </div>
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script>

                                                    $(document).ready(function () {
                                                        // الحصول على القيمة المحفوظة مسبقًا لـ car_mark_type
                                                        var selectedCarType = "{{ old('car_mark_type', $transaction['question']['car_mark_type'] ?? '') }}";
                                                        console.log(selectedCarType);
                                                        // عند تغيير car_mark
                                                        $("#car_mark").on('change', function () {
                                                            var markid = $(this).val();
                                                            if (markid) {
                                                                $.ajax({
                                                                    url: '/get-types/' + markid,
                                                                    type: 'GET',
                                                                    datatype: 'json',
                                                                    success: function (data) {
                                                                        $("#car_type").empty();
                                                                        $("#car_type").append('<option value="">-- حدد --</option>');
                                                                        // إضافة الخيارات الجديدة للأنواع
                                                                        $.each(data, function (key, value) {
                                                                            // هنا نقارن النصوص بدلًا من الـ id
                                                                            var isSelected = (value === selectedCarType) ? 'selected' : '';
                                                                            $('#car_type').append('<option value="' + value + '" ' + isSelected + '>' + value + '</option>');
                                                                        });
                                                                    }
                                                                });
                                                            } else {
                                                                $('#car_type').empty(); // تفريغ حقل الأنواع في حال عدم اختيار ماركة
                                                                $('#car_type').append('<option value="">-- حدد --</option>');
                                                            }
                                                        });

                                                        // Trigger change event to load types if car_mark is already selected
                                                        if ($("#car_mark").val()) {
                                                            $("#car_mark").trigger('change');
                                                        }
                                                    });

                                                </script>

                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_model"> الموديل <span class="star"> *  </span>
                                                        </label>
                                                        <select name="car_model" id="car_model" class="form-select">
                                                            <option value="">-- حدد --</option>
                                                            @for($year = date('Y') + 1; $year >= 1970 ; $year--)
                                                                <option {{ old('car_model', $transaction['question']['car_model'] ?? '') == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_category_select"> اختيار الفئة <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <div class="select_options_category">
                                                            <input type="radio" class="btn-check" name="car_category"
                                                                   id="option5" autocomplete="off" value="DLX" {{$transaction['question']['car_category'] == 'DLX' ?'checked' :''}}>
                                                            <label class="btn" for="option5">DLX</label>

                                                            <input type="radio" class="btn-check" name="car_category" value="STD" {{$transaction['question']['car_category'] == 'STD' ?'checked' :''}}
                                                                   id="option6" autocomplete="off">
                                                            <label class="btn" for="option6">STD</label>

                                                            <input type="radio" class="btn-check" name="car_category" value="SUPER DLX" {{$transaction['question']['car_category'] == 'SUPER DLX' ?'checked' :''}}
                                                                   id="option7" autocomplete="off">
                                                            <label class="btn" for="option7">SUPER DLX</label>

                                                            <input type="radio" class="btn-check" name="car_category" value="DC" {{$transaction['question']['car_category'] == 'DC' ?'checked' :''}}
                                                                   id="option8" autocomplete="off">
                                                            <label class="btn" for="option8">DC</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_category_select"> القير <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <div class="select_options_category">
                                                            <input type="radio" value="قير عادي" class="btn-check"
                                                                   name="car_gear"
                                                                   id="gear1" autocomplete="off" {{$transaction['question']['car_gear'] == 'قير عادي' ?'checked' :''}}>
                                                            <label class="btn" for="gear1">قير عادي </label>

                                                            <input type="radio" value="قير اوتماتيك" class="btn-check"
                                                                   name="car_gear"
                                                                   id="gear2" autocomplete="off" {{$transaction['question']['car_gear'] == 'قير اوتماتيك' ?'checked' :''}}>
                                                            <label class="btn" for="gear2">قير اوتماتيك </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="solar_type"> نوع الوقود <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <div class="select_options_category">
                                                            <input type="radio" value="بنزين" class="btn-check"
                                                                   name="solar_type"
                                                                   id="solar1" autocomplete="off" {{$transaction['question']['solar_type'] == 'بنزين' ?'checked' :''}}>
                                                            <label class="btn" for="solar1">بنزين</label>

                                                            <input type="radio" value="ديزل" class="btn-check"
                                                                   name="solar_type" {{$transaction['question']['solar_type'] == 'ديزل' ?'checked' :''}}
                                                                   id="solar2" autocomplete="off">
                                                            <label class="btn" for="solar2">ديزل</label>
                                                            <input type="radio" value="هايبرد" class="btn-check"
                                                                   name="solar_type" {{$transaction['question']['solar_type'] == 'هايبرد' ?'checked' :''}}
                                                                   id="solar3" autocomplete="off">
                                                            <label class="btn" for="solar3">هايبرد</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_distance"> الممشي ( <span
                                                                id="distance_value"> <strong>  {{$transaction['question']['car_distance']}} </strong></span> الف
                                                            كيلو)
                                                            <span class="star"> *  </span>
                                                        </label>
                                                        <input type="range" name="car_distance" class="form-range"
                                                               id="car_distance" min="1"
                                                               max="300" value="{{$transaction['question']['car_distance']}}" oninput="updateDistance(this.value)">

                                                        <!-- عنصر لعرض القيمة -->
                                                    </div>
                                                    <script>
                                                        function updateDistance(value) {
                                                            document.getElementById('distance_value').textContent = value;
                                                        }
                                                    </script>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="form-check form-switch" style="margin-bottom: 20px;">
                                                        <input class="form-check-input" name="car_double"
                                                               type="checkbox" role="switch" id="double" {{$transaction['question']['car_double'] == 1 ? 'checked':''}}>
                                                        <label style="font-size: 18px" class="form-check-label"
                                                               for="double"> دبل </label>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="car_board_letters"> رقم لوحة السيارة   <span class="star"> * </span></label>
                                                        <div class="input-group">
                                                            <!-- الحقل الخاص بالأحرف -->
                                                            <input type="text" name="car_board_letters" id="car_board_letters"
                                                                   class="form-control"
                                                                   placeholder="أحرف اللوحة" style="text-transform:uppercase;"
                                                                   value="{{ $transaction['question']['car_board_letters'] }}">
                                                            <!-- الحقل الخاص بالأرقام -->
                                                            <input type="text" name="car_board_numbers" id="car_board_numbers"
                                                                   class="form-control"
                                                                   placeholder="أرقام اللوحة"
                                                                   value="{{ $transaction['question']['car_board_numbers'] }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="car_color"> لون السيارة <span
                                                                class="star"> *  </span>
                                                        </label>
                                                        <input type="text" name="car_color" id="car_color"
                                                               class="form-control"
                                                               value="{{$transaction['question']['car_color']}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="box">
                                                        <label for="price"> السعر <span class="star"> *  </span>
                                                        </label>
                                                        <input type="number" name="price" id="price"
                                                               class="form-control"
                                                               value="{{$transaction['price']}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="box">
                                                    <label for="description"> الوصف <span class="star"> *  </span>
                                                    </label>
                                                    <textarea rows="8" name="description" id="description"
                                                              class="form-control">{{$transaction['description']}}</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="front_image">صورة من الأمام <span
                                                                class="star"> * </span></label>
                                                        <div class="image-upload-wrapper" onclick="document.getElementById('front_image').click();">
                                                            @if($transaction['front_image'])
                                                                <img id="front_preview" src="{{ asset('assets/uploads/car_images/' . $transaction['front_image']) }}" alt="معاينة الصورة" style="width: 100%; height: auto;"/>
                                                            @else
                                                                <span id="upload_text" style="font-size: 18px; text-align: center; color: #888;">انقر لاختيار صورة</span>
                                                            @endif
                                                        </div>
                                                        <input type="file" class="form-control" name="front_image"
                                                               id="front_image" accept="image/*"
                                                               style="display:none;"
                                                               onchange="previewImage(this, 'front_preview')">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="back_image">صورة من الخلف <span class="star"> * </span></label>
                                                        <div class="image-upload-wrapper" onclick="document.getElementById('back_image').click();">
                                                           @if($transaction['back_image'])
                                                                <img id="back_preview" src="{{ asset('assets/uploads/car_images/' . $transaction['back_image']) }}" alt="معاينة الصورة" style=" width: 100%; height: auto;"/>
                                                            @else
                                                                <span id="upload_text_back" style="font-size: 18px; text-align: center; color: #888;">انقر لاختيار صورة</span>
                                                           @endif
                                                        </div>
                                                        <input type="file" class="form-control" id="back_image" name="back_image" accept="image/*" style="display:none;" onchange="previewImage(this, 'back_preview', 'upload_text_back')">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="left_image">صورة من اليسار <span class="star"> * </span></label>
                                                        <div class="image-upload-wrapper" onclick="document.getElementById('left_image').click();">
                                                            @if($transaction['left_image'])
                                                                <img id="left_preview" src="{{ asset('assets/uploads/car_images/' . $transaction['left_image']) }}" alt="معاينة الصورة" style="width: 100%; height: auto;"/>
                                                            @else
                                                                <span id="upload_text_left" style="font-size: 18px; text-align: center; color: #888;">انقر لاختيار صورة</span>
                                                            @endif
                                                        </div>
                                                        <input type="file" class="form-control" id="left_image" name="left_image" accept="image/*" style="display:none;" onchange="previewImage(this, 'left_preview', 'upload_text_left')">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-12">
                                                    <div class="box">
                                                        <label for="right_image">صورة من اليمين <span class="star"> * </span></label>
                                                        <div class="image-upload-wrapper" onclick="document.getElementById('right_image').click();">
                                                            @if($transaction['right_image'])
                                                                <img id="right_preview" src="{{ asset('assets/uploads/car_images/' . $transaction['right_image']) }}" alt="معاينة الصورة" style="width: 100%; height: auto;"/>
                                                            @else
                                                                <span id="upload_text_right" style="font-size: 18px; text-align: center; color: #888;">انقر لاختيار صورة</span>
                                                            @endif
                                                        </div>
                                                        <input type="file" class="form-control" id="right_image" name="right_image" accept="image/*" style="display:none;" onchange="previewImage(this, 'right_preview', 'upload_text_right')">
                                                    </div>
                                                </div>

                                                <script>
                                                    function previewImage(input, previewId) {
                                                        const file = input.files[0];
                                                        if (file) {
                                                            const reader = new FileReader();
                                                            reader.onload = function (e) {
                                                                const img = document.getElementById(previewId);
                                                                img.src = e.target.result;
                                                                img.style.display = 'block'; // إظهار الصورة
                                                            }
                                                            reader.readAsDataURL(file); // قراءة الملف وعرضه كمعاينة
                                                        }
                                                    }
                                                </script>
                                            </div>
                                            <!-- زر الانتقال إلى الخطوة 2 -->
                                            <button type="button" class="btn btn-primary" onclick="showStep(2)">التالي
                                                <i style="position: relative;top: 2px"
                                                   class="bi bi-arrow-left-short"></i></button>
                                        </div>
                                        <div class="step" id="step2" style="display:none;">
                                            <div class="row">
                                                <h5>حالة السيارة</h5>
                                                <div class="col-lg-12 col-12">
                                                    <!-- عرض الأسئلة مع الخيارات -->
                                                    @foreach($questions as $question)
                                                        <div class="box">
                                                            <label>{{ $question->question }} <span class="star"> * </span></label>
                                                            <div class="select_options_category">
                                                                @foreach($question->options as $option)
                                                                    @php
                                                                        // التحقق مما إذا كانت الإجابة الحالية مطابقة للإجابة المحفوظة
                                                                        $isChecked = $order_conditions->where('question_id', $question->id)
                                                                            ->where('option_id', $option->id)
                                                                            ->isNotEmpty();
                                                                    @endphp
                                                                    <input type="radio" value="{{ $option->id }}" class="btn-check"
                                                                           name="conditions[{{ $question->id }}]"
                                                                           id="conditions[{{ $question->id }}_{{ $option->id }}]"
                                                                           autocomplete="off"
                                                                        {{ $isChecked ? 'checked' : '' }}>
                                                                    <label class="btn" for="conditions[{{ $question->id }}_{{ $option->id }}]">
                                                                        {{ $option->option }}
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <!-- زر العودة إلى الخطوة 1 -->
                                            <button type="button" class="btn btn-secondary" onclick="showStep(1)"><i
                                                    style="position: relative;top: 2px"
                                                    class="bi bi-arrow-right-short"></i> السابق
                                            </button>



                                            <button id="submitBtncompany" type="submit" class="btn btn-primary"> تعديل البيانات  <i
                                                    class="bi bi-floppy-fill"></i></button>
                                            <span class="loader" id="loaderCompany"
                                                  style="display: none;">جاري التحميل ... </span>
                                        </div>
                                    </form>
                                    <script>
                                        document.getElementById('CompanyRegister').addEventListener('submit', function (event) {
                                            document.getElementById('submitBtncompany').disabled = true; // تعطيل زر الإرسال
                                            document.getElementById('submitBtncompany').style.display = 'none'; // إخفاء زر الإرسال
                                            document.getElementById('loaderCompany').style.display = 'inline'; // إظهار مؤشر التحميل
                                        });
                                    </script>
                                    <script>
                                        function showStep(step) {
                                            // إخفاء جميع الخطوات
                                            document.getElementById('step1').style.display = 'none';
                                            document.getElementById('step2').style.display = 'none';

                                            // إظهار الخطوة المطلوبة
                                            document.getElementById('step' + step).style.display = 'block';
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    .image-upload-wrapper {
        width: 200px;
        height: 200px;
        border: 2px dashed #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        margin-top: 10px;
        transition: border-color 0.3s;
        position: relative;
    }

    .image-upload-wrapper:hover {
        border-color: #999;
    }

    .image-upload-wrapper img {
        max-width: 100%;
        max-height: 100%;
    }

    #upload_text, #upload_text_back, #upload_text_left, #upload_text_right {
        position: absolute;
        text-align: center;
        font-size: 16px;
    }
</style>

