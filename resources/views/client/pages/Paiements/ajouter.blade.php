@extends('client.layout.app')
@section('style')
    <link rel="stylesheet" href="/client/css/summernote/summernote.css">
    <link rel="stylesheet" href="/client/css/normalize.css">
@endsection

@section('content')
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="nk-int-mk">
            <h2>Credit Card</h2>
        </div>
        <div class="form-group ic-cmp-int form-elet-mg">
            <div class="form-ic-cmp">
                <i class="notika-icon notika-credit-card"></i>
            </div>
            <div class="nk-int-st">
                <input type="text" class="form-control" data-mask="999 999 999 9999" placeholder="Credit Card">
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="nk-int-mk">
            <h2>Postal Code</h2>
        </div>
        <div class="form-group ic-cmp-int form-elet-mg res-mg-fcs">
            <div class="form-ic-cmp">
                <i class="notika-icon notika-star"></i>
            </div>
            <div class="nk-int-st">
                <input type="text" class="form-control" data-mask="9999" placeholder="Postal Code">
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/client/js/jasny-bootstrap.min.js"></script>
@endsection
