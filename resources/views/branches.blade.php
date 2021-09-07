@extends ('layouts.dashboard')
@section('page_heading','Update Branch & State')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-6">
        <form role="form" ACTION="{{ URL('/import_sb') }}" METHOD="POST" ENCTYPE="MULTIPART/FORM-DATA">
        @csrf
            <div class="form-group">
                <label>Select File</label>
                <input type="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
</div>
@stop