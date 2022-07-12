@extends('admin.layout.app')

@section('page')
    Avantage des formules
@endsection
@section('Information')
    Ajout d'avantages
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
            Formulaire d'ajout d'<strong>Avantages</strong>
        </div>
        <form action="{{ route('Admin.Avantage.Add') }}" method="post" class="form">
            @csrf
            <div class="card-body card-block">
                <div class="form-group">
                    <label for="nf-password" class="form-control-label">Description</label>
                    <input type="text" id="nf-password" name="Description" value="{{ old('Description') }}"
                        placeholder="Saisissez la description" class="form-control">
                    @error('Description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa fa-dot-circle-o"></i> Enrégistrer
                </button>
                <button type="reset" class="btn btn-danger btn-sm">
                    <i class="fa fa-ban"></i> Annuler
                </button>
            </div>
        </form>
    </div>
@endsection
