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
    Page d'ajout d'article
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour ajouter une nouvelle article.
    </p>
@endsection

@section('content')
    <div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <form action="" id="FakeForm">
                        <div class="form-element-list mg-t-30">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-edit"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" id="ArticleLibelle" required name="Libelle"
                                            class="form-control" placeholder="Libelle de l'article">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-draft"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="text" id="ArticleDescription" required name="Description"
                                            class="form-control" placeholder="Description de l'article">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-tax"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <div class="chosen-select-act fm-cmp-mg">
                                            <select class="chosen" id="ArticleCategorie" name="Categorie" required
                                                data-placeholder="Séléctionnez la categorie">
                                                <option disabled selected>
                                                    Categorie de l'article
                                                </option>
                                                @forelse ($categories as $item)
                                                    <option value="{{ $item->Libelle }}">
                                                        {{ $item->Libelle }}
                                                    </option>
                                                @empty
                                                    <option disabled value="">
                                                        Aucune categorie de disponible
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-credit-card"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="number" min="0" id="ArticlePrix" required name="Prix"
                                            class="form-control" placeholder="Prix de l'article">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-avable"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input type="number" required id="ArticleSeuil" name="Seuil" class="form-control"
                                            placeholder="Seuil de l'article">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-house"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <div class="chosen-select-act fm-cmp-mg">
                                            <select class="chosen" name="Entrepot[]" id="EntrepotChoisie" required>
                                                @forelse ($entrepots as $item)
                                                    @if ($item->Description == 'Local')
                                                        <option selected value="{{ $item->Description }}">
                                                            {{ $item->Description }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->Description }}">
                                                            {{ $item->Description }}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option disabled value="">
                                                        Aucune categorie de disponible
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline btn-success"> Ajouter</button>
                            <button class="btn btn-outline btn-danger" type="reset"> Annuler</button>
                        </div>
                </div>
                </form>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-element-list mg-t-30" hidden id="SecondSection">
                    <div class="row">
                        <div class="header">
                            Renseignez la quantité de l'article dans chaque entrepot
                        </div>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        Article
                                    </th>
                                    <th class="text-center">
                                        Entrepot
                                    </th>
                                    <th class="text-center">
                                        Quantité
                                    </th>
                                    <th class="text-center">
                                        Retirer
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="QuantiteTableBody">

                            </tbody>
                            <tfoot>
                                <th class="text-center">
                                    Article
                                </th>
                                <th class="text-center">
                                    Entrepot
                                </th>
                                <th class="text-center">
                                    Quantité
                                </th>
                                <th class="text-center">
                                    Retirer
                                </th>
                            </tfoot>
                        </table>
                        <button class="btn btn-success" id="Valider"> Valider </button>
                        <button class="btn btn-danger" onclick="DropData()" type="reset" id="Supprimer">
                            Réinitialiser </button>
                    </div>
                    <form action="{{ route('User.Article.Add') }}" method="POST" id="RealForm">
                        @csrf
                    </form>
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
    <script src="/client/js/jasny-bootstrap.min.js"></script>
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>

    <script>
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });

        function MakeTableData(data) {
            var tbody = document.getElementById("QuantiteTableBody");
            var trElement = document.createElement("tr");
            trElement.setAttribute("name", "element");
            var tdAricle = document.createElement("td");
            var tdRetirer = document.createElement("td");
            var tdEntrepot = document.createElement("td");
            var aRetirer = document.createElement("a");
            //aRetirer.setAttribute("href","");
            aRetirer.setAttribute("class", "btn");
            var iRetirer = document.createElement("i");
            var inputQuantite = document.createElement("input");
            inputQuantite.setAttribute("type", "number");
            inputQuantite.setAttribute("min", "1");
            inputQuantite.setAttribute("value", "1");
            inputQuantite.setAttribute("required", "required");
            inputQuantite.setAttribute("class", "form-control");
            inputQuantite.setAttribute("id", data + " Entrepot");
            inputQuantite.setAttribute("placeholder", "Séléctionner la quantité");
            var tdQuantite = document.createElement("td");
            tdEntrepot.innerHTML = data;
            tdAricle.innerHTML = document.getElementById("ArticleLibelle").value;
            iRetirer.setAttribute("class", "notika-icon notika-sent")
            aRetirer.appendChild(iRetirer);
            tdRetirer.appendChild(aRetirer);
            aRetirer.addEventListener("click", function() {
                SupprimerLinge(tdAricle.innerHTML)
            })
            trElement.setAttribute("id", "Ligne " + tdAricle.innerHTML);
            tdQuantite.appendChild(inputQuantite);
            tdAricle.setAttribute("class", "text-center")
            tdRetirer.setAttribute("class", "text-center")
            tdEntrepot.setAttribute("class", "text-center")
            // input cachés
            var tdCacheCategorie = document.createElement("td");
            var tdCacheDescription = document.createElement("td");
            var tdCachePrix = document.createElement("td");
            var tdCacheSeuil = document.createElement("td");
            tdCacheCategorie.setAttribute("class", "hidden")
            tdCacheDescription.setAttribute("class", "hidden")
            tdCachePrix.setAttribute("class", "hidden")
            tdCacheSeuil.setAttribute("class", "hidden")
            // Attribution des valeurs 
            tdCacheCategorie.innerHTML = document.getElementById("ArticleCategorie").value;
            tdCacheDescription.innerHTML = document.getElementById("ArticleDescription").value;
            tdCachePrix.innerHTML = document.getElementById("ArticlePrix").value
            tdCacheSeuil.innerHTML = document.getElementById("ArticleSeuil").value
            // Fin attribution des valeurs 
            //fin input cachés
            trElement.appendChild(tdCacheCategorie);
            trElement.appendChild(tdCacheDescription);
            trElement.appendChild(tdCachePrix);
            trElement.appendChild(tdCacheSeuil);
            trElement.appendChild(tdAricle);
            trElement.appendChild(tdEntrepot);
            trElement.appendChild(tdQuantite);
            trElement.appendChild(tdRetirer);
            tbody.prepend(trElement);
        }


        function SupprimerLinge(test) {
            var tbody = document.getElementById("QuantiteTableBody");
            tbody.removeChild(document.getElementById("Ligne " + test));
            $.growl('Suppression de ' + test, {
                type: 'success',
                delay: 5000,
            });
            if (tbody.rows.length == 0)
                document.getElementById("SecondSection").hidden = true;
        }


        function MakeFormData() {
            var EntrepotForm = [];
            let formData = new FormData();
            var tableBody = document.getElementById("QuantiteTableBody");
            for (let index = 0; index < tableBody.rows.length; index++) {
                EntrepotForm[index] = {
                    "FormCategorie": tableBody.rows[index].cells[0].innerHTML,
                    "FormDescription": tableBody.rows[index].cells[1].innerHTML,
                    "FormPrix": tableBody.rows[index].cells[2].innerHTML,
                    "FormSeuil": tableBody.rows[index].cells[3].innerHTML,
                    "FormArticle": tableBody.rows[index].cells[4].innerHTML,
                    "FormEntrepot": tableBody.rows[index].cells[5].innerHTML,
                    "FormQuantite": tableBody.rows[index].cells[6].getElementsByTagName('input')[0].value,
                }

            }
            EntrepotForm.forEach(element => {
                MakeFormInput("FormCategorie", element["FormCategorie"]);
                MakeFormInput("FormDescription", element["FormDescription"]);
                MakeFormInput("FormPrix", element["FormPrix"]);
                MakeFormInput("FormSeuil", element["FormSeuil"]);
                MakeFormInput("FormArticle", element["FormArticle"]);
                MakeFormInput("FormEntrepot", element["FormEntrepot"]);
                MakeFormInput("FormQuantite", element["FormQuantite"]);
            });
        }

        var myform = document.getElementById("RealForm");

        function MakeFormInput(name, value) {
            var inputCache = document.createElement("input");
            inputCache.setAttribute("name", name + "[]");
            inputCache.setAttribute("value", value);
            inputCache.setAttribute("class", "hidden");
            myform.appendChild(inputCache);

        }

        document.getElementById("Valider").addEventListener('click', function(e) {
            MakeFormData();
            myform.submit();
        });

        document.getElementById("FakeForm").addEventListener('submit', function(e) {
            if (ControlCategorie()) {
                document.getElementById("SecondSection").hidden = false;
                ArticleEntrepot();
                document.getElementById("FakeForm").reset();
            }
            e.preventDefault();
        });

        function ControlCategorie() {
            var Categorie = document.getElementById("ArticleCategorie").
            options[document.getElementById("ArticleCategorie").selectedIndex].text;
            if (Categorie == "Categorie de l'article") {
                $.growl("Erreur, vous devez choisir la catégorie de l'article", {
                    type: 'danger',
                    delay: 5000,
                });
                return false;
            }
            return true;
        }

        function DropData() {
            var Oldtbody = document.getElementById("QuantiteTableBody");
            var Newtbody = document.createElement("tbody");
            Newtbody.setAttribute("id", "QuantiteTableBody");
            Oldtbody.replaceWith(Newtbody);
            document.getElementById("SecondSection").hidden = true;
        }

        function ArticleEntrepot() {
            var entrepotsChoisie = document.getElementById("EntrepotChoisie");
            MakeTableData(entrepotsChoisie.options[entrepotsChoisie.selectedIndex].text);

        }
        var NavArticles = document.getElementById("ArticleNavHeader");
        var NavArticle = document.getElementById("NavArticles");
        var oldClassHeader = NavArticles.getAttribute("class");
        var oldClassNav = NavArticle.getAttribute("class");
        NavArticles.setAttribute("class", oldClassHeader + " active");
        NavArticle.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
