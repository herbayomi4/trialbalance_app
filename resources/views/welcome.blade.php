<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
    <FORM ACTION="{{ URL('/import_sb') }}" METHOD="POST" ENCTYPE="MULTIPART/FORM-DATA">
    @CSRF
    <DIV CLASS = "FORM-GROUP">
        <LABEL>GENERAL SB</LABEL><INPUT TYPE="FILE" NAME="file" CLASS="FORM-CONTROL" REQUIRED><BR>
        @IF (SESSION('ERROR'))
            <DIV CLASS="ALERT ALERT-DANGER">
            {{ SESSION('ERROR')}}
            </DIV>
        @ENDIF
        <BUTTON CLASS="BTN BTN-SUCCESS">UPLOAD SB</BUTTON>
    </DIV>
    </FORM> 
    <BR>
    <BR>
    <FORM ACTION="{{ URL('/import_tb') }}" METHOD="POST" ENCTYPE="MULTIPART/FORM-DATA">
    @CSRF
    <DIV CLASS = "FORM-GROUP">
        <LABEL>GENERAL SB</LABEL><INPUT TYPE="FILE" NAME="file" CLASS="FORM-CONTROL" REQUIRED><BR>
        @IF (SESSION('ERROR'))
            <DIV CLASS="ALERT ALERT-DANGER">
            {{ SESSION('ERROR')}}
            </DIV>
        @ENDIF
        <BUTTON CLASS="BTN BTN-SUCCESS">UPLOAD TRIAL BAL</BUTTON>
    </DIV>
    </FORM>  
    <br>
    <br>
    <form action="{{ url('/export') }}" method="POST">
    @csrf
    <div class = "form-group">
        <div class="input-group mb-3">
            <select name="state" class="custom-select" id="inputGroupSelect02">
                <option selected>Choose...</option>
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
            <div class="input-group-append">
                <label class="input-group-text" for="inputGroupSelect02">State</label>
            </div>
        </div>
        <br>
        @if (session('error'))
            <div class="alert alert-danger">
            {{ session('error')}}
            </div>
        @endif
        <button class="btn btn-success">Export</button>
    </div>
    </form>
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
    @endif
    </body>
</html>
