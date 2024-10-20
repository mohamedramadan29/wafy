<div class="modal" id="edit_model_{{$type['id']}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"> تعديل نوع الفحص   </h6>
                <button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(Auth::guard('center')->check())
                <form method="post"
                      action="{{url('center/inspection-type/update/'.$type['id'])}}">
            @elseif(Auth::check())
                <form method="post"
                      action="{{url('admin/inspection-type/update/'.$type['id'])}}">
            @endif

                @csrf
                <div class="modal-body">
                    <div>
                        <label for=""> اسم الفحص  </label>
                        <input class="form-control" type="text" name="name" value="{{$type['name']}}" required>
                    </div>
                    <div>
                        <label for=""> السعر   </label>
                        <input class="form-control" type="number" name="price" value="{{$type['price']}}" required>
                    </div>
                    <div>
                        <label for=""> حدد حالة التفعيل  </label>
                        <select name="status" required class="form-control" id="">
                            <option value=""> -- حدد  -- </option>
                            <option @if($type['status'] == 1) selected @endif value="1"> فعال </option>
                            <option @if($type['status'] == 0) selected @endif value="0"> غير فعال  </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit"> تعديل
                    </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">رجوع
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
