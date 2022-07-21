@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
@endsection

@section('InfoLabel')
    Page de vente
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour faire votre vente
    </p>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="form-example-wrap mg-t-30">
                    <div class="cmp-tb-hd cmp-int-hd">
                        <h2>Renseignement concernant la vente</h2>
                    </div>
                    <div class="form-example-int form-horizental">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm">Article</label>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                    <div class="chosen-select-act fm-cmp-mg">
                                        <select class="chosen" data-placeholder="Séléctionnez l'article">
                                            <option disabled selected>Séléctionnez l'article</option>
                                            @forelse ($articles as $item)
                                                <option value="{{ $item->Libelle }}">{{ $item->Libelle }}</option>
                                            @empty
                                                <option disabled value="">Aucun article de disponible</option>
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
                                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm text-center">Liste des entrepots de l'article</label>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                    <div class="nk-int-st">
                                        <input type="number" id="AbonnementDure" min="5"
                                            class="form-control input-sm" placeholder="Ajouter une durée personnalisée">
                                    </div>
                                    <small class="text-center">Selectionnez l'entrepot de déstockage de
                                        l'article</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-example-int form-horizental mg-t-15">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm text-center">Quantité</label>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                    <div class="nk-int-st">
                                        <input type="number" id="AbonnementDure" min="5"
                                            class="form-control input-sm" placeholder="Ajouter une durée personnalisée">
                                    </div>
                                    <small class="text-center">Saisissez la quantité à vendre</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-example-int form-horizental mg-t-15">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                    <label class="hrzn-fm text-center">Réduction</label>
                                </div>
                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                    <div class="nk-int-st">
                                        <input type="number" id="AbonnementDure" min="5"
                                            class="form-control input-sm" placeholder="Ajouter une durée personnalisée">
                                    </div>
                                    <small class="text-center">Réudction</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-example-int mg-t-15">
                        <div class="row">
                            <div class="col-lg">
                                <div class="col-lg-4 d-flex justify-content-end">
                                    <button class="btn btn-success" onclick="AddPanier();" id="AddPanier">Ajouter au
                                        panier</button>
                                </div>
                                <div class="col-lg-4 d-flex justify-content-end">
                                    <button class="btn btn-success" onclick="Vente();" id="BtnEffectuer">Effectuer</button>
                                </div>
                                <div class="col-lg-4 text-center" id="AbonnementPrix">
                                    Prix total ?
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 animation-action" hidden id="VenteInfoDiv">
                <div class="form-example-wrap mg-t-30">
                    <div class="cmp-tb-hd cmp-int-hd ">
                        <h2 id="VenteLabel">Article séléctionner</h2>
                    </div>
                    <div class="card" id="SimpleVente" hidden>
                        <div class="card-body">
                            <h4 class="card-title">Vente de ...</h4>
                            <p class="card-text">Informations sur la vente</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Article</li>
                            <li class="list-group-item">Entrepot de déstockage</li>
                            <li class="list-group-item">Quantité à vendre</li>
                            <li class="list-group-item">Réduction</li>
                        </ul>
                    </div>
                    <table class="table table-responsive table-hover table-stiped" hidden id="PanierTable">
                        <thead>
                            <tr>
                                <th class="text-center">Article</th>
                                <th class="text-center">Entrepôt</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">Réduction</th>
                                <th class="text-center">Retirer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Article</th>
                                <th class="text-center">Entrepôt</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">Réduction</th>
                                <th class="text-center">Retirer</th>
                            </tr>
                        </tfoot>
                    </table>
                    <button class="btn btn-success" style="display: none" id="Valider" hidden>Valider</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/client/js/animation/animation-active.js"></script>
    <script src="/client/js/dropzone/dropzone.js"></script>
    <script src="/client/js/bootstrap-select/bootstrap-select.js"></script>
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/chosen/chosen.jquery.js"></script>
    <script>
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });

        function Vente() {
            document.getElementById("AddPanier").disabled = true;
            document.getElementById("SimpleVente").hidden = false;
            document.getElementById("VenteInfoDiv").hidden = false;
            document.getElementById("Valider").style.display = "block";
            document.getElementById("BtnEffectuer").innerHTML = "Modifier";
        }

        function AddPanier() {
            var label = document.getElementById("VenteLabel");
            label.innerHTML = "Panier";
            document.getElementById("Valider").style.display = "block";
            document.getElementById("BtnEffectuer").disabled = true;
            document.getElementById("SimpleVente").hidden = true;
            document.getElementById("PanierTable").hidden = false;
            document.getElementById("VenteInfoDiv").hidden = false;
            document.getElementById("PanierBtn").hidden = false;
            $('#PanierTable').DataTable({
                select: true,
                stateSave: true,
                paging: true,
                "language": {
                    "url": "/French.json"
                }
            });
        }
        var VentesNavHeader = document.getElementById("VentesNavHeader");
        var NavVentes = document.getElementById("NavVentes");
        var oldClassHeader = VentesNavHeader.getAttribute("class");
        var oldClassNav = NavVentes.getAttribute("class");
        VentesNavHeader.setAttribute("class", oldClassHeader + " active");
        NavVentes.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
