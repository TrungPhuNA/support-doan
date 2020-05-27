@extends('test::layouts.app_test_master')
@section('content-test')
	<style>
		#selectedFiles {
			padding: 10px;
		}
		#selectedFiles p {
			margin-bottom: 5px;
			border-bottom: 1px solid #dedede;
		}
		#selectedFiles p:last-child{
			border-bottom: none;
		}
	</style>
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
		<h1 class="h2">Thêm mới document</h1>
	</div>
	<div class="">
		<form action="" enctype="multipart/form-data" method="POST">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Upload</span>
				</div>
				<div class="custom-file">
					<input required type="file" id="document" name="file[]" multiple  class="custom-file-input">
					<label class="custom-file-label" for="inputGroupFile01">Chọn file</label>
				</div>
			</div>
			<div id="selectedFiles">

			</div>
			<div class="input-group mb-3">
				<select name="dcm_category_id" class="custom-select">
					<option selected>Chọn danh mục</option>
					@foreach($categories as $item)
						<option value="{{ $item['id'] }}">{{ $item['c_name'] }}</option>
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Xác nhận</button>
		</form>
	</div>
@stop
<script>

	var selDiv = "";
	document.addEventListener("DOMContentLoaded", init, false);
	function init() {
		document.querySelector('#document').addEventListener('change', handleFileSelect, false);
		selDiv = document.querySelector("#selectedFiles");
	}

	function handleFileSelect(e) {
		if(!e.target.files) return;
		selDiv.innerHTML = "";

		var files = e.target.files;
		for(var i=0; i<files.length; i++) {
			var f = files[i];
			selDiv.innerHTML += `<p>${f.name }</p>`;
		}
	}
</script>