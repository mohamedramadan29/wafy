@extends('admin.layouts.master')
@section('title')
    رفع نتائج فحص السيارة
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرئيسية </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                      رفع نتائج فحص السيارة    </span>
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


                    <form class="form-horizontal" method="post" action="{{ url('center/results/'.$transaction['id']) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> رقم المعاملة </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input readonly disabled type="text" class="form-control"
                                                   name="transaction_id" value="{{$transaction['id']}}">
                                            <input type="hidden" class="form-control" name="transaction_id"
                                                   value="{{$transaction['id']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> اسم المعاملة </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input readonly disabled type="text" class="form-control"
                                                   name="transaction_name" value="{{$transaction['title']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> نوع الفحص </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input readonly disabled type="text" class="form-control"
                                                   name="transaction_name"
                                                   value="{{$transaction['inspectiontype']['name']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> رفع نتائج الفحص </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="file" required multiple class="form-control" name="files[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class='btn btn-primary' type='submit'> اضافة <i class="fa fa-plus"></i></button>
                        </div>
                    </form>
                    <br>
                    <br>

                    @if($transaction['TransactionResult']->count() > 0 )
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th> الملف</th>
                                    <th> العمليات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transaction['TransactionResult'] as $result)
                                    <tr>
                                        <td><a target="_blank" class="btn btn-primary btn-sm"
                                               href="{{asset('assets/uploads/results/'.$result['file'])}}"> مشاهدة
                                                الملف </a></td>
                                        <td>
                                            <button data-target="#delete_model_{{$result['id']}}"
                                                    data-toggle="modal" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('admin.transactions.delete_result')
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

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
