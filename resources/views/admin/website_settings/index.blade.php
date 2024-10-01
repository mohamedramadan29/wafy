@extends('admin.layouts.master')
@section('title')
     اعدادات الموقع
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرئيسية </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اعدادات الموقع  </span>
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
                    <div class="mb-4 main-content-label">بيانات الموقع </div>
                    <form class="form-horizontal" method="post" action="{{url('admin/setting/update')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">اسم الموقع  </label>
                                </div>
                                <div class="col-md-9">
                                    <input  type="text" name="name" class="form-control" value="{{$setting['name']}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label"> الوصف   </label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="description" id=""  class="form-control">{{$setting['description']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">  لوجو الموقع  </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="file" class="form-control" name="logo" value="">
                                    <img width="80px" height="80px" class="img-fluid img-thumbnail" src="{{asset('assets/uploads/settings/'.$setting['logo'])}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label"> عمولة المشتري  </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="buyer_tax"
                                           value="{{$setting['buyer_tax']}}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">تعديل البيانات
                            </button>
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

