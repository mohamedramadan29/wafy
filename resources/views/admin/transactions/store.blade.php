@extends('admin.layouts.master')
@section('title')
   اضافة مركز صيانة
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرئيسية </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                      اضافة مركز صيانة   </span>
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
                    @if (Session::has('Success_message'))
                        <div class="alert alert-success"> {{ Session::get('Success_message') }} </div>
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


                    <form class="form-horizontal" method="post" action="{{ url('admin/inspection-center/store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">  الاسم </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input required type="text" class="form-control" name="name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> رقم الهاتف  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input required type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">  العنوان  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input required type="text" class="form-control" name="address" value="{{old('address')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> حالة مركز الصيانة  </label>
                                        </div>
                                        <div class="col-md-9">
                                           <select class="form-control select2" name="status">
                                               <option value=""> -- حدد  الحالة  -- </option>
                                               <option value="1"> فعال </option>
                                               <option value="0"> غير فعال  </option>
                                           </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button class='btn btn-primary' type='submit'> اضافة   <i class="fa fa-plus"></i></button>
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
