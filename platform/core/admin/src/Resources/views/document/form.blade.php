<style type="text/css">
    .custom-file-upload {
        cursor: pointer;
    }
</style>
<form role="form" action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-sm-8">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Thông tin cơ bản</h3>
            </div>
            <div class="box-body">
                <div class="form-group ">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="dcm_name" placeholder="Iphone 5s ...." autocomplete="off" value="{{  $document->dcm_name ?? old('dcm_name') }}">
                    @if ($errors->first('dcm_name'))
                        <span class="text-danger">{{ $errors->first('dcm_name') }}</span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá tài liệu</label>
                             <input type="text" name="dcm_price" value="{{  $document->dcm_price ?? old('dcm_price',0) }}"
                                    class="form-control" id="money" data-type="currency" placeholder="15.000.000">
                             @if ($errors->first('dcm_price'))
                                <span class="text-danger">{{ $errors->first('dcm_price') }}</span>
                            @endif
                        </div>
                    </div>
{{--                    <div class="col-sm-3">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleInputEmail1">Số Trang</label>--}}
{{--                            <input type="text" name="dcm_number" value="{{  $document->dcm_number ?? old('dcm_number') }}" class="form-control"  placeholder="15">--}}
{{--                            @if ($errors->first('dcm_number'))--}}
{{--                                <span class="text-danger">{{ $errors->first('dcm_number') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-sm-9">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="tag">Keyword</label>--}}
{{--                            <select name="keywords[]" class="form-control js-select2-keyword" multiple="">--}}
{{--                                <option value="">__Click__</option>--}}
{{--                                @foreach($keywords as $keyword)--}}
{{--                                    <option value="{{ $keyword->id }}" {{ in_array($keyword->id, $keywordOld ) ? "selected='selected'"  : '' }}>--}}
{{--                                        {{ $keyword->k_name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="form-group ">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea name="dcm_description" class="form-control" cols="5" rows="2" autocomplete="off">{{  $document->dcm_description ?? old('dcm_description','') }}</textarea>
                    @if ($errors->first('dcm_description'))
                        <span class="text-danger">{{ $errors->first('dcm_description') }}</span>
                    @endif
                </div>

                <div class="form-group ">
                    <label class="control-label">Danh mục <b class="col-red">(*)</b></label>
                    <select name="dcm_category_id" class="form-control ">
                        <option value="">__Click__</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{  old('dcm_category_id',$document->dcm_category_id ?? 0) == $category->id ? "selected='selected'" : "" }}>
                                <?php $str = '' ;for($i = 0; $i < $category->level; $i ++){ echo $str; $str .= '-- '; }?> {{  $category->c_name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->first('dcm_category_id'))
                        <span class="text-danger">{{ $errors->first('dcm_category_id') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Nội dung</h3>
            </div>
            <div class="box-body">
                <div class="form-group ">
                    <label for="exampleInputEmail1">Content</label>
                    <textarea name="dcm_content" id="content" class="form-control textarea" cols="5" rows="2" >{{ $document->dcm_content ?? '' }}</textarea>
                    @if ($errors->first('dcm_content'))
                        <span class="text-danger">{{ $errors->first('dcm_content') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Ảnh đại diện</h3>
            </div>

            <div class="box-body block-images">
                <div style="margin-bottom: 10px">
                    <img src="{{ pare_url_file(($document->dcm_avatar ?? ''),'uploads_preview') ?? '/images/no-image.jpg' }}" onerror="this.onerror=null;this.src='/images/no-image.jpg';" alt="" class="img-thumbnail" style="width: 200px;height: 200px;">
                </div>
                <div style="position:relative;">
                    <a class="btn btn-primary" href="javascript:;"> Choose File...
                        <input type="file" style="position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:&quot;progid:DXImageTransform.Microsoft.Alpha(Opacity=0)&quot;;opacity:0;background-color:transparent;color:transparent;" name="dcm_avatar" size="40" accept="image/*" class="js-upload"> </a> &nbsp;
                    <span class="label label-info" id="upload-file-info"></span>
                </div>
            </div>
        </div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Link preview (Nếu có)</h3>
            </div>
            <div class="box-body">
                <textarea name="dcm_link_preview" class="form-control" id="" cols="30" rows="3">{{ $document->dcm_link_preview ?? "" }}</textarea>
            </div>
        </div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">File</h3>
            </div>
            <div class="box-body">
                <label for="file-upload" class="custom-file-upload">
                    <i class="fa fa-cloud-upload"></i> Upload File
                </label>
                <input id="file-upload" name='dcm_file' accept=".doc, .docx,.ppt, .pptx,.pdf, .ppt" type="file" style="display:none;">
                @if (isset($document->dcm_file))
                    <p>Name: {{  $document->dcm_file }}</p>
                    <p>Size: {{  $document->dcm_size }}</p>
                    <p>Page: {{  $document->dcm_number }}</p>
                @endif
            </div>

        </div>
    </div>
    <div class="col-sm-12 clearfix">
        <div class="box-footer text-center">
            <a href="{{ route('admin.document.index') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ isset($document) ? "Cập nhật" : "Thêm mới" }} </button> </div>
    </div>
</form>

<script src="{{  asset('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">

    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };

    CKEDITOR.replace( 'content' ,options);

    $(function(){
        $('#file-upload').change(function() {
            var i = $(this).prev('label').clone();
            var file = $('#file-upload')[0].files[0].name;
            $(this).prev('label').text(file);
        });

        $('#money').on('input', function(e){
            $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
        }).on('keypress',function(e){
            if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
        }).on('paste', function(e){
            var cb = e.originalEvent.clipboardData || window.clipboardData;
            if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
        });
        function formatCurrency(number){
            var n = number.split('').reverse().join("");
            var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");
            return  n2.split('').reverse().join('') ;
        }
    })
</script>
