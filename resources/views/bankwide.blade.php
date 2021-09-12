@extends ('layouts.dashboard')
@section('page_heading','Upload Bankwide Trialbalance')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-6">
        <form role="form" ACTION="{{ URL('/import_tb') }}" METHOD="POST" ENCTYPE="MULTIPART/FORM-DATA">
        @csrf
            <div class="form-group">
                <label>Select File</label>
                <input type="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <br>
        @if (!empty($error))
            <div class="alert alert-danger alert-block">
            {!! $error !!}
            </div>
        @endif

        @if (!empty($success))
            <div class="alert alert-success">
            {!! $success !!}
            </div>
        @endif
    </div>
</div>
</div>

@stop
