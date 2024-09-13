@extends('admin.layouts.master')
@section('title')
     الشروط والاحكام
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @endsection
<style>
    #editor {
        height: 300px;
    }
</style>
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرئيسية </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                      الشروط والاحكام  </span>
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


                    <form class="form-horizontal" method="post" action="{{ url('admin/terms') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-12">

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea id="summernote" required class='form-control' name='terms' rows="10">{{$terms['terms']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class='btn btn-primary' type='submit'> تعديل  <i class="fa fa-edit"></i></button>
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

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
                $('#summernote').summernote({
                tabsize: 2,
                height: 250
            });
        });
    </script>

@endsection
