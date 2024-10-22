@extends('admin.layouts.master')
@section('title')
    مشاهدة جميع معلومات العملية
@endsection
@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرئيسية </h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/  مشاهدة جميع معلومات العملية   </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <!-- row -->
    <div class="row row-sm">

        <!-- Col -->
        <div class="col-lg-12">
            <div class="card">


                <div class="card-body">
                    @if(Session::has('Success_message'))
                        <div
                            class="alert alert-success"> {{Session::get('Success_message')}} </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="multiStepForm"
                          action="{{url('admin/transaction/show/'.$transaction['id'])}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="step" id="step1">
                            <h5> المعلومات العامة </h5>
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="title"> عنوان المعاملة <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="title" id="title"
                                           class="form-control"
                                           value="{{$transaction['title']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="price"> السعر
                                    </label>
                                    <input disabled type="number" name="price" id="price"
                                           class="form-control"
                                           value="{{ $transaction['price']}}">

                                </div>
                            </div>
                            <div class="row">

                                <label for="description"> الوصف <span class="star"> *  </span>
                                </label>
                                <textarea readonly disabled rows="8" name="description"
                                          id="description"
                                          class="form-control">{{$transaction['description']}}</textarea>

                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <label for="description"> صور السيارة
                                    </label>
                                    <div class="car_images">
                                        @php $car_images = explode(',',$transaction['images']);
                                        @endphp
                                        @foreach($car_images as $image)
                                            <div>
                                                <img width="80px" height="80px"
                                                     src="{{asset('assets/uploads/car_images/'.$image)}}"
                                                     alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- الخطوة 2 -->
                        <div class="step" id="step2">
                            <h5> معلومات السيارة </h5>
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="car_mark"> الماركة <span class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="car_mark"
                                           id="car_mark"
                                           class="form-control"
                                           value="{{$transaction['question']['car_mark']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="car_model"> الموديل <span class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="car_model"
                                           id="car_model"
                                           class="form-control"
                                           value="{{$transaction['question']['car_model']}}">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="car_mark"> سنة الصنع <span class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="number" name="car_year"
                                           id="car_year"
                                           class="form-control"
                                           value="{{$transaction['question']['car_year']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="body_type"> نوع الجسم
                                    </label>
                                    <input readonly disabled type="text" name="body_type"
                                           id="car_year"
                                           class="form-control"
                                           value="{{$transaction['question']['body_type']}}">


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="door_number"> عدد الابواب <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="number" name="door_number"
                                           id="door_number"
                                           class="form-control"
                                           value="{{$transaction['question']['door_number']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="car_color"> لون السيارة <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="car_color"
                                           id="car_color"
                                           class="form-control"
                                           value="{{$transaction['question']['car_color']}}">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="car_distance"> المسافة المقطوعة <span
                                            class="badge badge-danger bg-danger"> الكيلومترات  </span>
                                        <span class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="number" name="car_distance"
                                           id="car_distance"
                                           class="form-control"
                                           value="{{$transaction['question']['car_distance']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="solar_type"> نوع الوقود <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="solar_type"
                                           id="solar_type"
                                           class="form-control"
                                           value="{{$transaction['question']['solar_type']}}">

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="engine_capacity"> سعة المحرك <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="engine_capacity"
                                           id="engine_capacity"
                                           class="form-control"
                                           value="{{$transaction['question']['engine_capacity']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="car_transmission"> ناقل الحركة <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="car_transmission"
                                           id="car_transmission"
                                           class="form-control"
                                           value="{{$transaction['question']['car_transmission']}}">

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 col-12">

                                    <label for="car_accedant"> الحوادث ان وجدت <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="car_accedant"
                                           id="car_accedant"
                                           class="form-control"
                                           value="{{$transaction['question']['car_accedant']}}">

                                </div>
                                <div class="col-lg-6 col-12">

                                    <label for="car_any_damage"> وجود أي أضرار أو خدوش <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="car_any_damage"
                                           id="car_any_damage"
                                           class="form-control"
                                           value="{{$transaction['question']['car_any_damage']}}">

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-12">

                                    <label for="tire_condition"> حالة الإطارات <span
                                            class="star"> *  </span>
                                    </label>
                                    <input readonly disabled type="text" name="tire_condition"
                                           id="tire_condition"
                                           class="form-control"
                                           value="{{$transaction['question']['tire_condition']}}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>

                        <h6> نتائج الفحص </h6>
                        @if($transaction['TransactionResult']->count() > 0 )
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th> الملف</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transaction['TransactionResult'] as $result)
                                        <tr>
                                            <td><a target="_blank" class="btn btn-primary btn-sm"
                                                   href="{{asset('assets/uploads/results/'.$result['file'])}}"> مشاهدة
                                                    الملف </a></td>

                                        </tr>
                                        @include('admin.transactions.delete_result')
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12 col-12">

                                <label for="tire_condition"> تحديد الحالة النهائية للعملية <span
                                        class="star"> *  </span>
                                </label>
                                <select name="admin_last_status" id="" class="form-control">
                                    <option value="" selected disabled> -- حدد --</option>
                                    <option @if($transaction['admin_last_status'] == 'متوافق') selected @endif value="متوافق"> متوافق</option>
                                    <option @if($transaction['admin_last_status'] == 'غير متوافق') selected @endif value="غير متوافق"> غير متوافق</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="submit" class="btn btn-primary"> تعديل الحالة النهائية للمعاملة</button>
                            </div>

                        </div>


                    </form>

                </div>

            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/admin/js/table-data.js') }}"></script>
    <script src="{{URL::asset('assets/admin/js/modal.js')}}"></script>
@endsection
