@extends('client.layout.app')
@section('style')
    <link rel="stylesheet" href="/client/css/animate.css">
    <link rel="stylesheet" href="/client/css/animation/animation-custom.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="form-example-wrap mg-t-30">
                    <div class="cmp-tb-hd cmp-int-hd">
                        <h2>Formulaire d'abonnement</h2>
                    </div>
                    <div class="form-example-int form-horizental">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm">Formule d'abonnement</label>
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <div class="nk-int-st fm-cmp-mg">
                                        <select class="chosen" id="FormuleSelected" onchange="FormuleContrainte();"
                                            name="Formule">
                                            <option disabled selected value="">Faite votre choix</option>
                                            @forelse ($formules as $item)
                                                <option value="{{ $item->Libelle }}">
                                                    {{ $item->Libelle }}
                                                </option>
                                            @empty
                                                <option disabled>Aucune formule</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-example-int form-horizental mg-t-15">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm">Durée de l'abonnement</label>
                                </div>
                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                    <div class="nk-int-st">
                                        <input type="number" id="AbonnementDure" min="5"
                                            class="form-control input-sm" placeholder="Ajouter une durée personnalisée">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-example-int mg-t-15">
                        <div class="row">
                            <div class="col-lg">
                                <div class="col-lg-6 d-flex justify-content-end">
                                    <button class="btn btn-success">Effectuer</button>
                                </div>
                                <div class="col-lg-6 text-center" id="AbonnementPrix">
                                    Prix total ?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 animation-action" id="FormuleDiv">
                <div class="form-example-wrap mg-t-30">
                    <div class="cmp-tb-hd cmp-int-hd animate-two">
                        <h2 id="FormuleLabel">Formule choisie</h2>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Main</a></li>
                            <li class="breadcrumb-item"><a href="#">Sub</a></li>
                            <li class="breadcrumb-item active">Active</li>
                        </ul>
                        @foreach ($avantages as $item => $value)
                            <div id="Avantages{{ $item }}">

                            </div>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script src="/client/js/animation/animation-active.js"></script>
        <script src="/client/js/dropzone/dropzone.js"></script>
        <script src="/client/js/bootstrap-select/bootstrap-select.js"></script>
        <script src="/client/js/chosen/chosen.jquery.js"></script>
        <script>
            function FormuleContrainte(test = {!! json_encode($formules) !!}) {
                var tem = test;
                let selected = document.getElementById('FormuleSelected').value
                tem.forEach(element => {
                    if (element['Libelle'] == selected) {
                        document.getElementById('AbonnementDure').value = element['DureeTarif']
                        document.getElementById('AbonnementDure').min = element['DureeTarif']
                        document.getElementById('AbonnementDure').max = element['DureeTarif'] * 2
                        document.getElementById('AbonnementPrix').innerHTML = "Prix total = " + element['Prix'] +
                            " francs CFA"
                    }
                });
            }
        </script>
    @endsection
