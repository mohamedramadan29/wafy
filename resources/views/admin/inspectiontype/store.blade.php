<div class="modal" id="add_model">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"> اضافة نوع فحص   </h6>
                <button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(\Illuminate\Support\Facades\Auth::guard('center')->check())
                <form method="post"
                      action="{{url('center/inspection-type/store')}}">
                    @elseif(\Illuminate\Support\Facades\Auth::check())
                        <form method="post"
                              action="{{url('admin/inspection-type/store')}}">
                            @endif

                            @csrf
                            <div class="modal-body">
                                <div>
                                    <input type="hidden" name="center_id" value="{{$center['id']}}">
                        <label for=""> اسم الفحص  </label>
                        <input class="form-control" type="text" name="name" required>
                    </div>
                    <div>
                        <label for=""> السعر   </label>
                        <input class="form-control" type="number" name="price" required>
                    </div>
                    <div>
                        <label for=""> حدد حالة التفعيل  </label>
                        <select name="status" required class="form-control" id="">
                            <option value=""> -- حدد  -- </option>
                            <option value="1"> فعال </option>
                            <option value="0"> غير فعال  </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit"> اضافة
                    </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                            type="button">رجوع
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
