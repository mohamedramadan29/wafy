@extends('admin.layouts.master')
@section('title')
   تعديل الخدمة
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرئيسية </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/   تعديل الخدمة   </span>
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
                    <div class="mb-4 main-content-label">  تعديل الخدمة  </div>
                    <form class="form-horizontal" method="post" action="{{url('admin/service/update/'.$service['id'])}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> القسم </label>
                                        </div>
                                        <div class="col-md-9">
                                            <select required class="form-control select2" name="cat_id" id="mainCategory">
                                                <option> -- حدد القسم --</option>
                                                @foreach($categories as $category)
                                                    <option @if($service['cat_id'] == $category['id']) selected @endif value="{{$category['id']}}"> {{$category['name']}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> القسم الفرعي </label>
                                        </div>
                                        <div class="col-md-9">
                                            <select required class="form-control select2" name="sub_cat_id" id="subCategory">
                                                <option> -- القسم الفرعي --</option>
                                                @foreach($subCategories as $subcategory)
                                                    <option @if($service['sub_cat_id'] == $subcategory['id']) selected @endif value="{{$subcategory['id']}}"> {{$subcategory['name']}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        var selectedCategoryId = $('#mainCategory').val();
                                        if (selectedCategoryId) {
                                            loadSubCategories(selectedCategoryId, "{{ $service['sub_cat_id'] }}");
                                        }

                                        $('#mainCategory').on('change', function() {
                                            var categoryId = $(this).val();
                                            if (categoryId) {
                                                loadSubCategories(categoryId, null);
                                            } else {
                                                $('#subCategory').empty();
                                                $('#subCategory').append('<option> -- حدد القسم الفرعي --</option>');
                                            }
                                        });

                                        function loadSubCategories(categoryId, selectedSubCatId) {
                                            $.ajax({

                                                url: 'http://127.0.0.1:8000/admin/service/get-subcategories/' + categoryId,
                                                type: 'GET',
                                                dataType: 'json',
                                                success: function(data) {
                                                    $('#subCategory').empty();
                                                    $('#subCategory').append('<option> -- حدد القسم الفرعي --</option>');
                                                    $.each(data, function(key, value) {
                                                        var isSelected = (selectedSubCatId && selectedSubCatId == value.id) ? 'selected' : '';
                                                        $('#subCategory').append('<option value="' + value.id + '" ' + isSelected + '>' + value.name + '</option>');
                                                    });
                                                }
                                            });
                                        }
                                    });
                                </script>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> اسم الخدمة  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input required type="text" class="form-control" name="name"
                                                   value="{{$service['name']}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> السعر  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input required type="number" class="form-control" name="price" value="{{$service['price']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> صورة الخدمة  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control" name="image">
                                            <img width="50px" height="50px" src="{{asset('assets/uploads/services/'.$service['image'])}}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">  وصف الخدمة  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea cols="" rows="10" class="form-control" required name="description">{{$service['description']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> الكلمات المفتاحية <span class="badge badge-danger"> افصل بين كل كلمة والاخري ب (,) </span> </label>
                                        </div>
                                        <div class="col-md-9">
                                            <input required type="text" class="form-control" name="tags" value="{{$service['tags']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label"> حالة الخدمة  </label>
                                        </div>
                                        <div class="col-md-9">
                                            <select required class="form-control select" name="status">
                                                <option> -- حدد --</option>
                                                <option @if($service['status'] == 1) selected @endif value="1"> فعالة  </option>
                                                <option @if($service['status'] == 0) selected @endif value="0">  غير فعالة </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">  تعديل الخدمة
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

