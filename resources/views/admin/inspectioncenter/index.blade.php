@extends('admin.layouts.master')
@section('title')
    مراكز الصيانة
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
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/مراكز الصيانة     </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <!-- row -->
    <div class="row row-sm">

        <!-- Col -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{url('admin/inspection-center/store')}}" class="btn btn-primary btn-sm">  اضف مركز صيانة جديد   <i class="fa fa-plus"></i> </a>
                </div>

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
                                <tr>
                                    <th class="wd-15p border-bottom-0"> #</th>
                                    <th class="wd-15p border-bottom-0">  الاسم   </th>
                                    <th class="wd-15p border-bottom-0">  رقم الهاتف  </th>
                                    <th class="wd-15p border-bottom-0">   العنوان   </th>
                                    <th class="wd-15p border-bottom-0">   حالة التفعيل  </th>
                                    <th class="wd-15p border-bottom-0"> العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($centers as $center)
                                    <tr>
                                        <td> {{$i++}} </td>
                                        <td> {{$center['name']}} </td>
                                        <td> {{$center['phone']}} </td>
                                        <td> {{$center['address']}} </td>
                                        <td>
                                            @if($center['status'] == 1)
                                                <span class="badge badge-success"> فعال  </span>
                                            @else
                                                <span class="badge badge-danger"> غير فعال  </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('admin/inspection-center/update/'.$center['id'])}}" class="btn btn-primary btn-sm"> <i class="fa fa-edit"></i> </a>
                                            <a href="{{url('admin/inspection-type/'.$center['id'])}}" class="btn btn-warning btn-sm"> <i class="fa fa-eye"></i> مشاهدة انواع الفحص </a>
                                            <button data-target="#delete_model_{{$center['id']}}"
                                                    data-toggle="modal" class="btn btn-danger btn-sm">  <i
                                                    class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Delete Section Model  -->
                                    @include('admin.inspectioncenter.delete')
                                @endforeach
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
