@extends('admin.layout.app')

@section('page')
    Avantages
@endsection
@section('Information')
    Modification de {{$avantage->Description}}
@endsection


@section('content')
    <div class="card">
        @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card-header">
            Formulaire de modification d'<strong>Avantages</strong>
        </div>
        <form action="{{ route('Admin.Avantage.Update') }}" method="post" class="form">
            @csrf
            <div class="card-body card-block">
                <div class="form-group">
                    <label for="nf-password" class="form-control-label">Description</label>
                    <input type="text" id="nf-password" name="Description" value="{{$avantage->Description}}"
                        placeholder="Saisissez la description" class="form-control">
                    @error('Description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-none" aria-hidden="true">
                    <label for="nf-password" class="form-control-label">Description</label>
                    <input type="hidden" id="nf-password" name="Id" value="{{$avantage->id}}"
                        placeholder="Saisissez la description" class="form-control">
                    @error('Description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> Modifier
                </button>
                <a href="{{route('Admin.Avantage.List')}}" class="btn btn-danger btn-sm">
                    <i class="fa fa-ban"></i> Annuler
                </a>
            </div>
        </form>
    </div>
@endsection
