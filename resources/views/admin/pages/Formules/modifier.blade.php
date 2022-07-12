@extends('admin.layout.app')
@section('page')
    Formules
@endsection
@section('Information')
 Modification de la formule {{$data->Libelle}}
@endsection

@section('content')
<div class="card">
    @if (Session::get('success'))
        <div class="alert alert-success">
            <ul class="ml-5">
                @foreach (Session::get('success') as $item => $key)
                    <li>
                        {{$key}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-header">
        Formulaire de modification de<strong> formule d'abonnement</strong>
    </div>
    <div class="card-body card-block">
        <form action="{{route('Admin.Formule.Update')}}" method="POST" class="form form-responsive">
            {{ csrf_field() }}
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class="form-control-label">Libelle</label></div>
                <div class="col-12 col-md-9"><input type="text" value="{{$data->Libelle}}" id="text-input" name="Libelle" class="form-control" required>
                    <small class="form-text text-muted">
                        @error('Libelle')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </small></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Description</label></div>
                <div class="col-12 col-md-9"><input type="text" value="{{$data->Description}}" id="text-input" name="Description" class="form-control" required>
                    <small class="form-text text-muted">
                        @error('Description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </small>
                </div>
            </div>
            <div aria-hidden="true" class="row form-group d-none">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Id</label></div>
                <div class="col-12 col-md-9"><input type="text" value="{{$data->id}}" id="text-input" name="Id" class="form-control" required>
                    <small class="form-text text-muted">
                        @error('Description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </small>
                </div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Durée du tarif</label></div>
                <div class="col-9 col-md-9"><input type="number"text-input" name="Duree" min="1" value="{{$data->DureeTarif}}" required class="form-control"><small class="form-text text-muted">@error('Duree')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror</small></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Prix</label></div>
                <div class="col-12 col-md-9"><input type="text" name="Prix"value="{{$data->Prix}}"required class="form-control"><small class="form-text text-muted">@error('Prix')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror</small></div>
            </div>
                <div class="row form-group">
                    <div class="col col-md-3"><label for="multiple-select" class=" form-control-label">Les avantages</label></div>
                    <div class="col col-md-9">
                        <select name="Avantages[]" id="multiple-select" required
                        data-placeholder="Sélectionner les avantages..." multiple class="form-control standardSelect">
                            @foreach ($avantages as $item => $key)
                                <option value="{{$key->id}}"
                                    @foreach ($avantage as $av => $va)
                                        @if ($va->id == $key->id)
                                            @selected(true)
                                        @endif
                                    @endforeach>
                                    {{$key->Description}}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">@error('Avantages')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror</small>
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
</div>
@endsection

@section('script')
<script>
    jQuery(document).ready(function() {
        jQuery(".standardSelect").chosen({
            disable_search_threshold: 10,
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });
    });
</script>
@endsection


