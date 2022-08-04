@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
@endsection

@section('InfoLabel')
    Page d'ajout de commande
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour ajouter une commande.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-example-wrap mg-t-30">
                        <div class="cmp-tb-hd cmp-int-hd">
                            <h2>Renseignement concernant la vente commande</h2>
                        </div>
                        <form action="" id="FakeForm" method="post">
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Article</label>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                            <div class="chosen-select-act fm-cmp-mg">
                                                <select class="chosen" id="ArticleSelect" required
                                                    data-placeholder="Séléctionnez l'article">
                                                    <option disabled selected>Séléctionnez l'article</option>
                                                    @forelse ($articles as $item)
                                                        <option title="Prix {{ $item->Prix }} fcfa"
                                                            value="{{ $item->id }}">{{ $item->Libelle }}</option>
                                                    @empty
                                                        <option disabled value="">Aucun article de disponible</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Fournisseur</label>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                            <div class="chosen-select-act fm-cmp-mg">
                                                <select class="chosen" id="FournisseurSelect" required
                                                    data-placeholder="Séléctionnez le fournisseur">
                                                    <option disabled selected>Séléctionnez le fournisseur</option>
                                                    @forelse ($fournisseurs as $item)
                                                        <option value="{{ $item->id }}">{{ $item->Nom }}</option>
                                                    @empty
                                                        <option disabled value="">Aucun fournisseur de disponible
                                                        </option>
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
                                            <label class="hrzn-fm text-center">Liste des entrepots</label>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                            <div class="chosen-select-act fm-cmp-mg">
                                                <select class="chosen" id="EntrepotSelect" name="Entrepot" required
                                                    data-placeholder="Séléctionnez l'entrepot">
                                                    @forelse ($entrepots as $item)
                                                        @if ($item->Description == 'Local')
                                                            <option selected value="{{ $item->id }}">
                                                                {{ $item->Description }}</option>
                                                        @else
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->Description }}</option>
                                                        @endif
                                                    @empty
                                                        <option disabled value="">Aucun entrepot de disponible
                                                        </option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            <small class="text-center">Selectionnez l'entrepot de stockage de
                                                l'article</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int form-horizental">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                            <label class="hrzn-fm">Modèle</label>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                            <div class="chosen-select-act fm-cmp-mg">
                                                <select class="chosen" name="Modele" id="ModeleSelect">
                                                    <option disabled selected>Séléctionnez le modèle</option>
                                                    @forelse ($modeles as $item)
                                                        <option title="{{ $item->Quantite }}" value="{{ $item->id }}">
                                                            {{ $item->Description }}
                                                        </option>
                                                    @empty
                                                        <option disabled value="">Aucun modèle de disponible</option>
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
                                            <label class="hrzn-fm text-center">Quantité</label>
                                        </div>
                                        <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                            <div class="nk-int-st">
                                                <input type="number" required id="CommandeQuantite" min="1"
                                                    class="form-control input-sm"
                                                    placeholder="Ajouter une durée personnalisée">
                                            </div>
                                            <small class="text-center">Saisissez la quantité à vendre</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-example-int mg-t-15">
                                <div class="row">
                                    <div class="col-lg">
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <button class="btn btn-success" type="submit"
                                                id="BtnEffectuer">Effectuer</button>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <button class="btn btn-success" type="reset" id="BtnReset">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 animation-action" style="display: none"
                    id="CommandeInfoDiv">
                    <div class="form-example-wrap mg-t-30">
                        <div class="cmp-tb-hd cmp-int-hd ">
                            <h2 id="VenteLabel" class="text-center">Informations sur la commande</h2>
                        </div>
                        <table class="table table-responsive table-hover table-stiped" id="PanierTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Article</th>
                                    <th class="text-center">Fournisseur</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-center" id="TableModele">Modèle</th>
                                    <th class="text-center">Entrepôt</th>
                                    <th class="text-center">Retirer</th>
                                </tr>
                            </thead>
                            <tbody id="TableTbody">

                            </tbody>
                        </table>
                        <div class="d-inline">
                            <button class="btn btn-success" id="Valider">Valider</button>
                            <button class="btn btn-danger" onclick="DropData()" type="reset"
                                id="PanierReset">Annuler</button>
                        </div>
                        <form action="{{ route('User.Commande.Add') }}" method="POST" id="RealFormPanier">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/client/js/icheck/icheck.min.js"></script>
    <script src="/client/js/icheck/icheck-active.js"></script>
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>
    <script src="/client/js/chosen/chosen.jquery.js"></script>
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>
    <script>
        $('.chosen').chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucun modèle disponible !",
            width: "95%"
        });
        var myform = document.getElementById("RealFormPanier");
        var tbody = document.getElementById("TableTbody");
        var articleChoisi = document.getElementById("ArticleSelect");
        var fournisseurChoisi = document.getElementById("FournisseurSelect");
        var modeleChoisi = document.getElementById("ModeleSelect");
        var entrepotChoisi = document.getElementById("EntrepotSelect");
        var CommandeInfoDiv = document.getElementById('CommandeInfoDiv');


        function MakeCommandeTableData() {
            var tr = document.createElement("tr")
            var tdArticle = document.createElement("td");
            var tdFournisseur = document.createElement("td");
            var tdModele = document.createElement("td");
            var tdQuantite = document.createElement("td");
            var tdEntrepot = document.createElement("td");
            var tdRetirer = document.createElement("td");
            var tdArticleCache = document.createElement("td");
            var tdFournisseurCache = document.createElement("td");
            var tdModeleCache = document.createElement("td");
            var tdEntrepotCache = document.createElement("td");
            tdArticleCache.style.display = "none";
            tdFournisseurCache.style.display = "none";
            tdModeleCache.style.display = "none";
            tdEntrepotCache.style.display = "none";
            tdArticle.setAttribute("class", "text-center");
            tdFournisseur.setAttribute("class", "text-center");
            tdModele.setAttribute("class", "text-center");
            tdQuantite.setAttribute("class", "text-center");
            tdEntrepot.setAttribute("class", "text-center");
            tdRetirer.setAttribute("class", "text-center");
            tdArticle.innerHTML = articleChoisi.options[articleChoisi.selectedIndex].text;
            tdArticleCache.innerHTML = articleChoisi.options[articleChoisi.selectedIndex].value;
            tdFournisseur.innerHTML = fournisseurChoisi.options[fournisseurChoisi.selectedIndex].text;
            tdFournisseurCache.innerHTML = fournisseurChoisi.options[fournisseurChoisi.selectedIndex].value;
            if (modeleChoisi.options[modeleChoisi.selectedIndex].text != "Séléctionnez le modèle") {
                tdModele.innerHTML = modeleChoisi.options[modeleChoisi.selectedIndex].text;
                tdModeleCache.innerHTML = modeleChoisi.options[modeleChoisi.selectedIndex].value;
            } else
                tdModele.innerHTML = " ";
            tdQuantite.innerHTML = document.getElementById("CommandeQuantite").value;
            tdEntrepot.innerHTML = entrepotChoisi.options[entrepotChoisi.selectedIndex].text;
            tdEntrepotCache.innerHTML = entrepotChoisi.options[entrepotChoisi.selectedIndex].value;
            var a = document.createElement("a");
            var i = document.createElement("i");
            i.setAttribute("class", "notika-icon notika-sent");
            a.setAttribute("class", "btn");
            a.appendChild(i);
            tdRetirer.appendChild(a);
            a.addEventListener("click", function() {
                SupprimerLigne(tdArticle.innerHTML)
            });
            tr.setAttribute("id", "TableElement " + tdArticle.innerHTML);
            tr.appendChild(tdArticleCache);
            tr.appendChild(tdFournisseurCache);
            tr.appendChild(tdModeleCache);
            tr.appendChild(tdEntrepotCache);
            tr.appendChild(tdArticle);
            tr.appendChild(tdFournisseur);
            tr.appendChild(tdQuantite);
            tr.appendChild(tdModele);
            tr.appendChild(tdEntrepot);
            tr.appendChild(tdRetirer);
            tbody.appendChild(tr);
        }

        function SupprimerLigne(test) {
            tbody.removeChild(document.getElementById("TableElement " + test));
            $.growl('Suppression de ' + test, {
                type: 'success',
                delay: 5000,
            });
            if (tbody.rows.length == 0) {
                DropData();
            }
        }

        function ControleSelection() {
            if (articleChoisi.options[articleChoisi.selectedIndex].text == "Séléctionnez l'article")
                return false;
            else
            if (fournisseurChoisi.options[fournisseurChoisi.selectedIndex].text == "Séléctionnez le fournisseur")
                return false;
            return true;
        }


        function MakeFormData() {
            var EntrepotForm = [];
            let formData = new FormData();
            var tableBody = document.getElementById("TableTbody");
            for (let index = 0; index < tableBody.rows.length; index++) {
                EntrepotForm[index] = {
                    "FormArticle": tableBody.rows[index].cells[0].innerHTML,
                    "FormFournisseur": tableBody.rows[index].cells[1].innerHTML,
                    "FormModele": tableBody.rows[index].cells[2].innerHTML,
                    "FormEntrepot": tableBody.rows[index].cells[3].innerHTML,
                    "FormQuantite": tableBody.rows[index].cells[6].innerHTML,
                }

            }
            EntrepotForm.forEach(element => {
                MakeFormInput("FormArticle", element["FormArticle"]);
                MakeFormInput("FormFournisseur", element["FormFournisseur"]);
                MakeFormInput("FormModele", element["FormModele"]);
                MakeFormInput("FormEntrepot", element["FormEntrepot"]);
                MakeFormInput("FormQuantite", element["FormQuantite"]);
            });
        }

        function MakeFormInput(name, value) {
            var inputCache = document.createElement("input");
            inputCache.setAttribute("name", name + "[]");
            inputCache.setAttribute("value", value);
            inputCache.setAttribute("class", "hidden");
            myform.appendChild(inputCache);
        }

        document.getElementById("FakeForm").addEventListener('submit', function(e) {
            if (ControleSelection()) {
                CommandeInfoDiv.style.display = "block";
                MakeCommandeTableData();
            } else {
                $.growl('Erreur, il vous manque une information à sélectioner.', {
                    type: 'info',
                    delay: 5000,
                });
            }
            e.preventDefault();
        });

        document.getElementById("Valider").addEventListener('click', function(e) {
            MakeFormData();
            myform.submit();
        });

        function DropData() {
            var Oldtbody = document.getElementById("TableTbody");
            var Newtbody = document.createElement("tbody");
            Newtbody.setAttribute("id", "TableTbody");
            Oldtbody.replaceWith(Newtbody);
            $.growl('Annulation de la demande.', {
                type: 'success',
                delay: 5000,
            })
            CommandeInfoDiv.style.display = "none";
        }

        var CommandesNavHeader = document.getElementById("CommandeNavHeader");
        var NavCommandes = document.getElementById("NavCommandes");
        var oldClassHeader = CommandesNavHeader.getAttribute("class");
        var oldClassNav = NavCommandes.getAttribute("class");
        CommandesNavHeader.setAttribute("class", oldClassHeader + " active");
        NavCommandes.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
