@extends('admin.layout.app')

@section('page')
    Formules
@endsection
@section('Information')
  Ajout de formule
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
        Formulaire d'ajout de<strong> formule d'abonnement</strong>
    </div>
    <div class="card-body card-block">
        <form action="{{route('Admin.Formule.Add')}}" method="POST" class="form">
            {{ csrf_field() }}
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class="form-control-label">Libelle</label></div>
                <div class="col-12 col-md-9"><input type="text" placeholder="Exemple Standart" id="text-input" name="Libelle" class="form-control" required><small class="form-text text-muted">Saisissez le libelle de la formule que vous voulez ajouter</small></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Description</label></div>
                <div class="col-12 col-md-9"><input type="text" placeholder="Exemple accès limité aux fonctionnalités de la plateforme" id="text-input" name="Description" class="form-control" required><small class="form-text text-muted">Saisissez la description de la formule que vous voulez ajouter</small></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Duree</label></div>
                <div class="col-9 col-md-9"><input type="number"text-input" name="Duree" min="1" required placeholder="Exemple 31" class="form-control"><small class="form-text text-muted">Choisissez la durée de la formule que vous voulez ajouter</small></div>
            </div>
            <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Prix</label></div>
                <div class="col-12 col-md-9"><input type="text" name="Prix" placeholder="Exemple 5000" required class="form-control"><small class="form-text text-muted">Saisissez le prix de la formule que vous voulez ajouter</small></div>
            </div>
                <div class="row form-group">
                    <div class="col col-md-3"><label for="multiple-select" class=" form-control-label">Les avantages</label></div>
                    <div class="col col-md-9">
                        <select name="Avantages[]" id="multiple-select" required
                        data-placeholder="Sélectionner les avantages..." multiple class="form-control standardSelect">
                            @foreach ($avantages as $item)
                                <option value="{{$item->id}}">{{$item->Description}}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Séléctionnez les avantages de la formule que vous voulez ajouter</small>
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
