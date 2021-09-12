@extends ('layouts.dashboard')
@section('page_heading','Generate Trialbalance per State per Branch')

@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-6">
        <form role="form" action="{{ url('export') }}" method="POST" name="state">
        @csrf
        <div class="form-group">
                <label>Select State</label>
                <select class="form-control" name="state">
                    <option value="ABIA">ABIA</option>
                    <option value="ABUJA">ABUJA</option>
                    <option value="ADAMAWA">ADAMAWA</option>
                    <option value="AKWA IBOM">AKWA IBOM</option>
                    <option value="ANAMBRA">ANAMBRA</option>
                    <option value="BAUCHI">BAUCHI</option>
                    <option value="BAYELSA">BAYELSA</option>
                    <option value="BENUE">BENUE</option>
                    <option value="BORNO">BORNO</option>
                    <option value="CROSS RIVER">CROSS RIVER</option>
                    <option value="DELTA">DELTA</option>
                    <option value="EBONYI">EBONYI</option>
                    <option value="EDO">EDO</option>
                    <option value="EKITI">EKITI</option>
                    <option value="ENUGU">ENUGU</option>
                    <option value="GOMBE">GOMBE</option>
                    <option value="IMO">IMO</option>
                    <option value="JIGAWA">JIGAWA</option>
                    <option value="KADUNA">KADUNA</option>
                    <option value="KANO">KANO</option>
                    <option value="KATSINA">KATSINA</option>
                    <option value="KEBBI">KEBBI</option>
                    <option value="KOGI">KOGI</option>
                    <option value="KWARA">KWARA</option>
                    <option value="LAGOS">LAGOS</option>
                    <option value="NASARAWA">NASARAWA</option>
                    <option value="NIGER">NIGER</option>
                    <option value="OGUN">OGUN</option>
                    <option value="ONDO">ONDO</option>
                    <option value="OSUN">OSUN</option>
                    <option value="OYO">OYO</option>
                    <option value="PLATEAU">PLATEAU</option>
                    <option value="RIVERS">RIVERS</option>
                    <option value="SOKOTO">SOKOTO</option>
                    <option value="TARABA">TARABA</option>
                    <option value="YOBE">YOBE</option>
                    <option value="ZAMFARA">ZAMFARA</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Generate</button>
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
