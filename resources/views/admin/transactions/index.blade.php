@extends('admin.layouts.master')
@section('title')
    العمليات علي الموقع
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
                        class="text-muted mt-1 tx-13 mr-2 mb-0">/العمليات علي الموقع  </span>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example2">
                                <thead>
                                @if(Auth::guard('center')->check())
                                    <tr>
                                        <th class="border-bottom-0"> رقم المعاملة</th>
                                        <th class="wd-15p border-bottom-0"> عنوان العملية</th>
                                        <th class="wd-15p border-bottom-0"> نوع الفحص  </th>
                                        <th class="wd-15p border-bottom-0"> الماركة</th>
                                        <th class="wd-15p border-bottom-0"> النوع</th>
                                        <th class="wd-15p border-bottom-0"> الموديل</th>
                                        <th class="wd-15p border-bottom-0"> الممشي</th>
                                        <th class="wd-15p border-bottom-0"> العمليات</th>
                                    </tr>
                                @elseif(Auth::check())
                                    <tr>
                                        <th class="border-bottom-0"> رقم المعاملة</th>
                                        <th class="wd-15p border-bottom-0"> عنوان العملية</th>
                                        <th class="wd-15p border-bottom-0"> البائع</th>
                                        <th class="wd-15p border-bottom-0"> المشتري</th>
                                        <th class="wd-15p border-bottom-0"> السعر</th>
                                        <th class="wd-15p border-bottom-0"> الحالة</th>
                                        <th class="wd-15p border-bottom-0"> الحالة النهائية للعملية  </th>
                                        <th class="wd-15p border-bottom-0"> العمليات</th>
                                    </tr>
                                @endif

                                </thead>
                                <tbody>
                                @if(Auth::guard('center')->check())
                                    @foreach($transactions  as $transaction)
                                        <tr>
                                            <td> {{$transaction['id']}} </td>
                                            <td> {{$transaction['title']}} </td>
                                            <td> {{$transaction['inspectiontype']['name']}} </td>
                                            @php
                                                $mark = \App\Models\admin\TraderMark::where('id',$transaction['question']['car_mark'])->select('name')->first();
                                            @endphp
                                            <td> {{$mark['name']}} </td>
                                            <td>
                                                {{$transaction['question']['car_mark_type']}}
                                            </td>
                                            <td> {{$transaction['question']['car_model']}}  </td>
                                            <td>
                                                {{$transaction['question']['car_distance']}}
                                            </td>
                                            <td>
                                                <a href="{{url('center/results/'.$transaction['id'])}}"
                                                   class="btn btn-primary btn-sm"> <i class="fa fa-upload"></i>
                                                    نتائج الفحص </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif(Auth::check())
                                    @foreach($transactions  as $transaction)
                                        <tr>
                                            <td>  {{$transaction['id']}} </td>
                                            <td> {{$transaction['title']}} </td>
                                            <td> {{$transaction['seller']['name']}} </td>
                                            <td>
                                                @if($transaction['buyer_id'] !=null)
                                                    {{$transaction['buyer']['name']}}
                                                @else
                                                    <span class="badge badge-danger">   لا يوجد </span>
                                                @endif
                                            </td>
                                            <td>  {{ number_format($transaction['price'],2)}} ريال</td>
                                            <td>
                                                <span class="badge badge-warning"> {{$transaction['status']}} </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-danger"> {{$transaction['admin_last_status']}} </span>
                                            </td>
                                            <td>
                                                <a href="{{url('admin/transaction/show/'.$transaction['id'])}}"
                                                   class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i> مشاهدة
                                                    جميع المعلومات </a>
{{--                                                <a href="{{url('admin/transaction/steps/'.$transaction['id'])}}"--}}
{{--                                                   class="btn btn-warning btn-sm"> <i class="fa fa-eye"></i> مشاهدة--}}
{{--                                                    خطوات العملية </a>--}}
                                                {{--                                            <button data-target="#delete_model_{{$center['id']}}"--}}
                                                {{--                                                    data-toggle="modal" class="btn btn-danger btn-sm">  <i--}}
                                                {{--                                                    class="fa fa-trash"></i>--}}
                                                {{--                                            </button>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div><!-- bd -->
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
