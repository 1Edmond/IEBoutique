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
                    <form action="" id="FakeForm" method="post">
                        <div class="form-example-int form-horizental">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm">Article</label>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                        <div class="chosen-select-act fm-cmp-mg">
                                            <select class="chosen" id="ArticleSelect" onchange="QuantiteVerifcation()"
                                                required data-placeholder="Séléctionnez l'article">
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
                      
                        <div class="form-example-int form-horizental mg-t-15">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                        <label class="hrzn-fm text-center">Quantité</label>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                        <div class="nk-int-st">
                                            <input type="number" required id="VenteQuantite" min="1"
                                                onchange="QTEInfo(this)" class="form-control input-sm"
                                                placeholder="Ajouter une durée personnalisée">
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
                                            <input type="number" required id="VenteReduction" min="0"
                                                class="form-control input-sm" max="100"
                                                onchange="CalculateRediction();"
                                                placeholder="Ajouter une durée personnalisée">
                                        </div>
                                        <small class="text-center">Réudction en pourcentage</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-example-int mg-t-15">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <button class="btn btn-success" type="submit" id="AddPanier">Ajouter au
                                            panier</button>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <button class="btn btn-success" type="submit" id="BtnEffectuer">Effectuer</button>
                                    </div>
                                    <div class="col-lg-4 text-center" id="VentePrix">
                                        Prix total ?
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 animation-action" hidden id="VenteInfoDiv">
                <div class="form-example-wrap mg-t-30">
                    <div class="cmp-tb-hd cmp-int-hd ">
                        <h2 id="VenteLabel" class="text-center">Article séléctionné</h2>
                    </div>
                    <div class="modal animated flash" id="ClientSimpleModal" tabindex="-1" role="dialog"
                        aria-labelledby="ClientSimpleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm-2" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="ClientSimpleModalLabel">Renseignez des
                                        informations
                                        sur le client</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                    <div class="col-lg-12 col-md-7 col-sm-7 col-xs-12">
                                        <div class="chosen-select-act fm-cmp-mg">
                                            <select class="chosen" onchange="SimpleClientSelect()"
                                                id="SimpleClientSelect">
                                                <option disabled selected>Choisissez un client</option>
                                                @forelse ($clients as $item)
                                                    <option title="Email : {{ $item->Email }}."
                                                        value="{{ $item->id }}">{{ $item->Nom }} {{ $item->Prenom }}
                                                    </option>
                                                @empty
                                                    <option disabled value="">Aucun client de disponible</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <form action="" class="form">
                                        <div class="mb-3 col-lg-6">
                                            <label for="SimpleNom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" name="SimpleNom" id="SimpleNom"
                                                max="20" onchange="ClientInfo()" aria-describedby="helpSimpleNom"
                                                placeholder="Saisissez le nom du client">
                                            <small id="helpSimpleNom" class="form-text text-muted">Nom Help text</small>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label for="SimplePrenom" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" name="SimplePrenom"
                                                id="SimplePrenom" max="20" onchange="ClientInfo()"
                                                aria-describedby="helpSimplePrenom"
                                                placeholder="Saisissez le prénom du client">
                                            <small id="helpSimplePrenom" class="form-text text-muted">Prénom Help
                                                text</small>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label for="SimpleAdresse" class="form-label">Adresse</label>
                                            <input type="text" class="form-control" name="SimpleAdresse"
                                                id="SimpleAdresse" max="50" onchange="ClientInfo()"
                                                aria-describedby="helpSimpleAdresse"
                                                placeholder="Saisissez l'adresse du client">
                                            <small id="helpSimpleAdresse" class="form-text text-muted">Adresse Help
                                                text</small>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label for="SimpleContact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" name="SimpleContact"
                                                id="SimpleContact" max="20" onchange="ClientInfo()"
                                                aria-describedby="helpSimpleContact"
                                                placeholder="Saisissez le contact du client">
                                            <small id="helpSimpleContact" class="form-text text-muted">Contact Help
                                                text</small>
                                        </div>
                                        <div class="mb-3 col-lg-8">
                                            <label for="SimpleEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="SimpleEmail"
                                                id="SimpleEmail" max="50" onchange="ClientInfo()"
                                                aria-describedby="helpSimpleEmail"
                                                placeholder="Saisissez l'email du client">
                                            <small id="helpSimpleEmail" class="form-text text-muted">Email Help
                                                text</small>
                                        </div>
                                    </form>
                                    </p>
                                </div>
                                <br>
                                <div class="col-lg-4">
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="SubmitFormWithoutClient()"
                                        data-dismiss="modal">Pas
                                        besoin</button>
                                    <button type="button" href="" onclick="SubmitFormWithClient()"
                                        class="btn btn-success">Valider</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="SimpleVente" hidden>
                        <div class="card-body">
                            <h4 class="card-title" id="VenteInformationHeader">Vente de ...</h4>
                            <p class="card-text">Informations sur la vente</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <div class="list-group-item hidden">
                                <h1-6> Id
                                    <span class="badge bg-primary ml-5 text-center" id="SimpleVenteArticleIdDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item">
                                <h1-6> Article
                                    <span class="badge bg-primary ml-5 text-center" id="SimpleVenteArticleDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item">
                                <h1-6> Prix de l'article
                                    <span class="badge bg-primary ml-5 text-center" id="SimpleVenteArticlePrixDiv">

                                    </span>
                                </h1-6>
                            </div>

                            <div class="list-group-item">
                                <h1-6>
                                    Quantité à vendre
                                    <span class="badge bg-primary ml-5 text-center" id="SimpleVenteQuantiteDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item">
                                <h1-6>
                                    Réduction
                                    <span class="badge bg-primary ml-5 text-center" id="SimpleVenteReductionDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item">
                                <h1-6>
                                    Prix Total
                                    <span class="badge bg-primary ml-5 text-center" id="SimpleVenteTotalDiv">

                                    </span>
                                </h1-6>
                            </div>
                        </ul>
                        <form action="" method="POST" id="RealFormSimpleVente">
                            @csrf
                        </form>
                    </div>
                    <div class="modal animated flash" id="ClientPanierModal" tabindex="-1" role="dialog"
                        aria-labelledby="ClientPanierModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm-2" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="ClientPanierModalLabel">Renseignez des
                                        informations
                                        sur le client</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                    <div class="col-lg-12 col-md-7 col-sm-7 col-xs-12">
                                        <div class="chosen-select-act fm-cmp-mg">
                                            <select class="chosen" onchange="PanierClientSelect()"
                                                id="PanierClientSelect">
                                                <option disabled selected>Choisissez un client</option>
                                                @forelse ($clients as $item)
                                                    <option title="Email : {{ $item->Email }}."
                                                        value="{{ $item->id }}">{{ $item->Nom }}
                                                        {{ $item->Prenom }}
                                                    </option>
                                                @empty
                                                    <option disabled value="">Aucun client de disponible</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <form action="" class="form">
                                        <div class="mb-3 col-lg-6">
                                            <label for="PanierNom" class="form-label">Nom</label>
                                            <input type="text" class="form-control" name="PanierNom" id="PanierNom"
                                                max="20" onchange="ClientInfo()" aria-describedby="helpPanierNom"
                                                placeholder="Saisissez le nom du client">
                                            <small id="helpPanierNom" class="form-text text-muted">Nom Help text</small>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label for="PanierPrenom" class="form-label">Prénom</label>
                                            <input type="text" class="form-control" name="PanierPrenom"
                                                id="PanierPrenom" max="20" onchange="ClientInfo()"
                                                aria-describedby="helpPanierPrenom"
                                                placeholder="Saisissez le prénom du client">
                                            <small id="helpPanierPrenom" class="form-text text-muted">Prénom Help
                                                text</small>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label for="PanierAdresse" class="form-label">Adresse</label>
                                            <input type="text" class="form-control" name="PanierAdresse"
                                                id="PanierAdresse" max="50 " onchange="ClientInfo()"
                                                aria-describedby="helpPanierAdresse"
                                                placeholder="Saisissez l'adresse du client">
                                            <small id="helpPanierAdresse" class="form-text text-muted">Adresse Help
                                                text</small>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label for="PanierContact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" name="PanierContact"
                                                id="PanierContact" max="20" onchange="ClientInfo()"
                                                aria-describedby="helpPanierContact"
                                                placeholder="Saisissez le contact du client">
                                            <small id="helpPanierContact" class="form-text text-muted">Contact Help
                                                text</small>
                                        </div>
                                        <div class="mb-3 col-lg-8">
                                            <label for="PanierEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="PanierEmail"
                                                id="PanierEmail" max="50" onchange="ClientInfo()"
                                                aria-describedby="helpPanierEmail"
                                                placeholder="Saisissez l'email du client">
                                            <small id="helpPanierEmail" class="form-text text-muted">Email Help
                                                text</small>
                                        </div>
                                    </form>
                                    </p>
                                </div>
                                <br>
                                <div class="col-lg-4">
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="SubmitFormWithoutClient()"
                                        data-dismiss="modal">Pas
                                        besoin</button>
                                    <button type="button" href="" onclick="SubmitFormWithClient()"
                                        class="btn btn-success">Valider</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-responsive table-hover table-stiped" hidden id="PanierTable">
                        <thead>
                            <tr>
                                <th class="text-center">Article</th>
                                <th class="text-center">Prix</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">Réduction</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Retirer</th>
                            </tr>
                        </thead>
                        <tbody id="TableTbody">

                        </tbody>
                    </table>
                    <div class="d-inline">
                        <button class="btn btn-success" style="display: none" id="Valider" hidden>Valider</button>
                        <button class="btn btn-danger" onclick="DropData()" type="reset" style="display: none"
                            id="PanierReset" hidden>Annuler</button>
                    </div>
                    <form action="{{ route('User.Vente.Add') }}" method="POST" id="RealFormPanier">
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
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>



    <script>
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });
        var Whoami = "";
        var QTERestant = [];

        function RestoreQTE() {
            var temp = {!! json_encode($ArticleData) !!}
            for (var element in temp)
                QTERestant[element] = temp[element];

        }
        window.onload = function() {
            RestoreQTE();
        };

        function RetraitQTE(index, valeur) {
            QTERestant[index] = QTERestant[index] - valeur;
            document.getElementById("VenteQuantite").setAttribute("max", QTERestant[index])
        }

        function AjoutQTE(index, valeur) {
            QTERestant[index] = QTERestant[index] + valeur;
            document.getElementById("VenteQuantite").setAttribute("max", QTERestant[index])
        }

        //var entrepotSelect = document.getElementById("EntrepotSelect");
        var Articleselect = document.getElementById("ArticleSelect");
        document.getElementById("Valider").addEventListener('click', function(e) {
            if (Whoami == "Panier")
                $("#ClientPanierModal").modal("show");
            else
                $("#ClientSimpleModal").modal("show");
        });

        function SubmitFormWithClient() {
            //MakePanierFormData();
            if (Whoami == "Panier") {
                MakePanierFormData();
                MakeClientFormData("Panier");
                myform.submit();
            } else {
                MakeClientFormData("Simple");
                MakeSimpleFormData();
                mySimpleform.submit();
            }
        }

        function ClientInfo() {
            Info = "New";
        }

        function SubmitFormWithoutClient() {
            //MakePanierFormData();
            if (Whoami == "Panier") {
                MakePanierFormData();
                myform.submit();
            } else {
                MakeSimpleFormData();
                mySimpleform.submit();
            }
        }

        function MakeClientFormData(type) {
            var data = {
                "Nom": document.getElementById(type + 'Nom').value,
                "Prenom": document.getElementById(type + 'Prenom').value,
                "Adresse": document.getElementById(type + 'Adresse').value,
                "Contact": document.getElementById(type + 'Contact').value,
                "Email": document.getElementById(type + 'Email').value,
            };
            for (var element in data) {
                var inputCache = document.createElement('input');
                inputCache.setAttribute("name", element);
                inputCache.setAttribute("class", "hidden");
                inputCache.setAttribute("value", data[element]);
                if (type == "Panier")
                    myform.appendChild(inputCache);
                else
                    mySimpleform.appendChild(inputCache);
            }
            var infoInput = document.createElement("input");
            infoInput.setAttribute("name", "Info");
            infoInput.setAttribute("class", "hidden");
            infoInput.setAttribute("value", Info);
            if (type == "Panier")
                myform.appendChild(infoInput);
            else
                mySimpleform.appendChild(infoInput);

        }

        function MakeSimpleFormData() {
            var data = {
                "FormArticle": parseInt(document.getElementById("SimpleVenteArticleIdDiv").innerHTML),
                "FormQuantite": parseInt(document.getElementById("SimpleVenteQuantiteDiv").innerHTML),
                "FormReduction": parseInt(document.getElementById("SimpleVenteReductionDiv").innerHTML.replace("%",
                    "")),
            };
            for (var element in data) {
                var inputCache = document.createElement('input');
                inputCache.setAttribute("name", element);
                inputCache.setAttribute("class", "hidden");
                inputCache.setAttribute("value", data[element]);
                mySimpleform.appendChild(inputCache);
            }
        }

        var Info = "";

        function PanierClientSelect() {
            var clients = {!! json_encode($clients) !!}
            var ClientSelect = document.getElementById("PanierClientSelect");
            Info = "Select";
            clients.forEach(client => {
                if (client["id"] == parseInt(ClientSelect.options[ClientSelect.selectedIndex].value)) {
                    var Nom = document.getElementById("PanierNom");
                    var Prenom = document.getElementById("PanierPrenom");
                    var Adresse = document.getElementById("PanierAdresse");
                    var Contact = document.getElementById("PanierContact");
                    var Email = document.getElementById("PanierEmail");
                    Nom.value = client['Nom'];
                    Prenom.value = client['Prenom'];
                    Contact.value = client['Contact'];
                    Adresse.value = client['Adresse'];
                    Email.value = client['Email'];
                    Nom.setAttribute('disabled', 'true');
                    Prenom.setAttribute('disabled', 'true');
                    Contact.setAttribute('disabled', 'true');
                    Adresse.setAttribute('disabled', 'true');
                    Email.setAttribute('disabled', 'true');
                }
            });
        }

        function SimpleClientSelect() {
            var clients = {!! json_encode($clients) !!}
            var ClientSelect = document.getElementById("SimpleClientSelect");
            Info = "Select";
            clients.forEach(client => {
                if (client["id"] == parseInt(ClientSelect.options[ClientSelect.selectedIndex].value)) {
                    var Nom = document.getElementById("SimpleNom");
                    var Prenom = document.getElementById("SimplePrenom");
                    var Adresse = document.getElementById("SimpleAdresse");
                    var Contact = document.getElementById("SimpleContact");
                    var Email = document.getElementById("SimpleEmail");
                    Nom.value = client['Nom'];
                    Prenom.value = client['Prenom'];
                    Contact.value = client['Contact'];
                    Adresse.value = client['Adresse'];
                    Email.value = client['Email'];
                    Nom.setAttribute('disabled', 'true');
                    Prenom.setAttribute('disabled', 'true');
                    Contact.setAttribute('disabled', 'true');
                    Adresse.setAttribute('disabled', 'true');
                    Email.setAttribute('disabled', 'true');
                }
            });
        }


        function MakePanierFormData() {
            var EntrepotForm = [];
            // let formData = new FormData();
            var tableBody = document.getElementById("TableTbody");
            for (let index = 0; index < tableBody.rows.length; index++) {
                EntrepotForm[index] = {
                    "FormArticle": tableBody.rows[index].cells[0].innerHTML,
                    "FormQuantite": tableBody.rows[index].cells[3].innerHTML,
                    "FormReduction": tableBody.rows[index].cells[4].innerHTML.replace("%", ""),
                }

            }
            EntrepotForm.forEach(element => {
                MakeFormInput("FormArticle", element["FormArticle"]);
                MakeFormInput("FormQuantite", element["FormQuantite"]);
                MakeFormInput("FormReduction", element["FormReduction"]);
            });

        }
        var myform = document.getElementById("RealFormPanier");
        var mySimpleform = document.getElementById("RealFormSimpleVente");

        function MakeFormInput(name, value) {
            var inputCache = document.createElement("input");
            inputCache.setAttribute("name", name + "[]");
            inputCache.setAttribute("value", value);
            inputCache.setAttribute("class", "hidden");
            myform.appendChild(inputCache);
        }

        function QTEInfo(qte) {
            if (qte.value == qte.getAttribute("max")) {
                $.growl("La quantité maximale en locale a été atteinte.", {
                    type: 'info',
                    delay: 5000,
                });
                Articleselect.options[Articleselect.selectedIndex].setAttribute("disabled", "true");
            } else {
                Articleselect.options[Articleselect.selectedIndex].removeAttribute("disabled");

            }
            $("#ArticleSelect").trigger("chosen:updated");
        }

        function QuantiteVerifcation() {
            //var entrepot = {!! json_encode($ArticleData) !!}
            var articleChoisi = Articleselect.options[Articleselect.selectedIndex].value;
            if (Object.keys(QTERestant).indexOf(articleChoisi) < 0) {
                $.growl("L'article choisi n'est pas disponible en local.", {
                    type: 'info',
                    delay: 5000,
                });
                Articleselect.options[Articleselect.selectedIndex].setAttribute("disabled", "true");
                document.getElementById("AddPanier").disabled = true;
                document.getElementById("BtnEffectuer").disabled = true;
                return false;
            } else {
                var Qte = document.getElementById("VenteQuantite");

                Qte.setAttribute("max", QTERestant[articleChoisi]);
                document.getElementById("AddPanier").disabled = false;
                Articleselect.options[Articleselect.selectedIndex].disabled = false;
                document.getElementById("BtnEffectuer").disabled = false;
                return true;
            }
            return false;
        }

        function CalculateRediction() {
            var temp = parseInt(Articleselect.options[Articleselect.selectedIndex].title.replace("Prix ", "").replace(
                "fcfa", ""));
            var reduction = document.getElementById("VenteReduction").value;
            var Prix = document.getElementById("VentePrix");
            var red = temp * (reduction / 100);
            Prix.innerHTML = "Prix total : " + (temp - red);
            return (temp - red);
        }

        var AjouterPanier = document.getElementById("AddPanier");
        var BtnEffectuer = document.getElementById("BtnEffectuer");
        document.getElementById("FakeForm").addEventListener('submit', function(e) {
            var form = document.getElementById("FakeForm");
            if (QuantiteVerifcation()) {
                if (AddPanierClicked) {
                    e.preventDefault()
                    AddPanier()
                    Articleselect.options[0].setAttribute("selected", "true");
                    form.reset();
                    $("#ArticleSelect").trigger("chosen:updated");
                } else {
                    if (VenteClicked) {
                        Vente()
                        form.reset();
                        Articleselect.options[0].setAttribute("selected", "true");
                        e.preventDefault()
                        $("#ArticleSelect").trigger("chosen:updated");
                    }
                }
            }
            e.preventDefault();
            e.reset();

        });

        var AddPanierClicked = false;
        document.getElementById("AddPanier").addEventListener('click', function(e) {
            AddPanierClicked = true;
            VenteClicked = false;
        });
        var VenteClicked = false;
        document.getElementById("BtnEffectuer").addEventListener('click', function(e) {
            var tbody = document.getElementById("TableTbody");
            VenteClicked = true;
            AddPanierClicked = false;
            DeleteRows(tbody);

        });

        function Vente() {
            Whoami = "Vente";
            VenteInformation();
            document.getElementById("VenteLabel").innerHTML = "Vente";
            document.getElementById("AddPanier").disabled = true;
            document.getElementById("SimpleVente").hidden = false;
            document.getElementById("VenteInfoDiv").hidden = false;
            document.getElementById("Valider").style.display = "inline";
            document.getElementById("PanierReset").style.display = "inline";
            document.getElementById("BtnEffectuer").innerHTML = "Modifier";
        }

        function CreateVenteElement() {
            var SimpleVenteArticleIdSpan = document.getElementById("SimpleVenteArticleIdDiv");
            var SimpleVenteArticleSpan = document.getElementById("SimpleVenteArticleDiv");
            var SimpleVenteArticlePrixDiv = document.getElementById("SimpleVenteArticlePrixDiv");
            var SimpleVenteQuantiteSpan = document.getElementById("SimpleVenteQuantiteDiv");
            var SimpleVenteReductionSpan = document.getElementById("SimpleVenteReductionDiv");
            SimpleVenteArticleSpan.innerHTML = Articleselect.options[Articleselect.selectedIndex].text;
            SimpleVenteArticleIdSpan.innerHTML = Articleselect.options[Articleselect.selectedIndex].value;
            SimpleVenteArticlePrixDiv.innerHTML = Articleselect.options[Articleselect.selectedIndex].title;
            //var SimpleVenteEntrepotSpan = document.getElementById("SimpleVenteEntrepotDiv");
            //SimpleVenteEntrepotSpan.innerHTML = entrepotSelect.options[entrepotSelect.selectedIndex].text;
            SimpleVenteQuantiteSpan.innerHTML = document.getElementById("VenteQuantite").value;
            document.getElementById("SimpleVenteTotalDiv").innerHTML = CalculateRediction() + " fcfa";
            SimpleVenteReductionSpan.innerHTML = document.getElementById("VenteReduction").value + "%";
        }

        function VenteInformation() {
            document.getElementById("VenteInformationHeader").innerHTML = "Vente de " + Articleselect.options[Articleselect
                .selectedIndex].text;
            CreateVenteElement();
        }

        function CreateTableElement() {
            var tbody = document.getElementById("TableTbody");
            var tr = document.createElement("tr");
            // Création des éléments du tableau
            var tdArticle = document.createElement("td");
            var tdArticleIdCache = document.createElement("td");
            var tdTotal = document.createElement("td");
            var tdArticlePrix = document.createElement("td");
            var tdQuantite = document.createElement("td");
            var tdReduction = document.createElement("td");
            var tdRetirer = document.createElement("td");
            tdArticleIdCache.style.display = "none";
            tdArticleIdCache.innerHTML = Articleselect.options[Articleselect.selectedIndex].value;
            tdArticle.setAttribute("class", "text-center");
            tdTotal.setAttribute("class", "text-center");
            tdArticlePrix.setAttribute("class", "text-center");
            tdQuantite.setAttribute("class", "text-center");
            tdReduction.setAttribute("class", "text-center");
            tdRetirer.setAttribute("class", "text-center");
            // Fin création des éléments du tableau
            // Attribution des valeurs aux éléments du tableau
            tdArticlePrix.innerHTML = Articleselect.options[Articleselect.selectedIndex].title.replace("Prix ", "");
            tdArticle.innerHTML = Articleselect.options[Articleselect.selectedIndex].text;
            tdQuantite.innerHTML = document.getElementById("VenteQuantite").value;
            tdReduction.innerHTML = document.getElementById("VenteReduction").value + "%";
            tdTotal.innerHTML = CalculateRediction();
            // Fin attribution des valeurs aux éléments du tableau
            // Code pour suprimer une ligne dans le tableau
            var a = document.createElement("a");
            var i = document.createElement("i");
            i.setAttribute("class", "notika-icon notika-sent");
            a.setAttribute("class", "btn");
            a.appendChild(i);
            tdRetirer.appendChild(a);
            a.addEventListener("click", function() {
                SupprimerLigne(tdArticle.innerHTML)
            });
            // Fin du code de suppression
            // Ajout des td au tr
            tr.setAttribute("id", "TableElement " + tdArticle.innerHTML);
            tr.appendChild(tdArticleIdCache);
            tr.appendChild(tdArticle);
            tr.appendChild(tdArticlePrix);
            tr.appendChild(tdQuantite);
            tr.appendChild(tdReduction);
            tr.appendChild(tdTotal);
            tr.appendChild(tdRetirer);
            // Fin ajout des td au tr
            // Ajout du tr au tbody
            tbody.appendChild(tr);
            // Fin ajout du tr au tbody

        }

        function SupprimerLigne(test) {
            AjoutQTE(
                parseInt(document.getElementById("TableElement " + test).getElementsByTagName('td')[0]
                    .innerHTML), parseInt(document.getElementById("TableElement " + test).getElementsByTagName('td')[3]
                    .innerHTML)
            );
            var tbody = document.getElementById("TableTbody");
            tbody.removeChild(document.getElementById("TableElement " + test));
            $.growl('Suppression de ' + test, {
                type: 'success',
                delay: 5000,
            });
            if (tbody.rows.length == 0) {
                document.getElementById("VenteInfoDiv").hidden = true;
                document.getElementById("BtnEffectuer").disabled = false;
                DropData();
            }
        }

        function DeleteRows(tableBody) {
            var rowCount = tableBody.rows.length;
            for (var i = 0; i < rowCount; i++) {
                tableBody.deleteRow(i);
            }
            if (tableBody.rows.length == 0)
                document.getElementById("PanierTable").hidden = true;
            RestoreQTE();
        }

        function DropData() {
            var Oldtbody = document.getElementById("TableTbody");
            var Newtbody = document.createElement("tbody");
            Newtbody.setAttribute("id", "TableTbody");
            Oldtbody.replaceWith(Newtbody);
            document.getElementById("VenteInfoDiv").hidden = true;
            $.growl('Annulation de la vente.', {
                type: 'success',
                delay: 5000,
            })
            for (var index = 1; index < Articleselect.options.length; index++)
                Articleselect.options[index].disabled = false;
            $("#ArticleSelect").trigger("chosen:updated");
            RestoreQTE();
            document.getElementById("BtnEffectuer").disabled = false;
            document.getElementById("VentePrix").innerHTML = "Prix total ?";
            document.getElementById("BtnEffectuer").innerHTML = "Effectuer";
            document.getElementById("AddPanier").disabled = false;
        }

        function AddPanier() {
            Whoami = "Panier";
            var label = document.getElementById("VenteLabel");
            label.innerHTML = "Panier";
            CreateTableElement();
            document.getElementById("Valider").style.display = "inline";
            document.getElementById("PanierReset").style.display = "inline";
            document.getElementById("BtnEffectuer").disabled = true;
            document.getElementById("SimpleVente").hidden = true;
            document.getElementById("PanierTable").hidden = false;
            document.getElementById("VenteInfoDiv").hidden = false;
            document.getElementById("AddPanier").hidden = false;
            RetraitQTE(
                Articleselect.options[Articleselect.selectedIndex].value,
                document.getElementById("VenteQuantite").value
            );
            if(QTERestant[Articleselect.options[Articleselect.selectedIndex].value] == 0 ){
                Articleselect.options[Articleselect.selectedIndex].setAttribute("disabled","true");
                 $.growl("L'article " +Articleselect.options[Articleselect.selectedIndex].text +" n'est plus disponible en local.", {
                type: 'info',
                delay: 5000,
            });
            }

        }
        var VentesNavHeader = document.getElementById("VentesNavHeader");
        var NavVentes = document.getElementById("NavVentes");
        var oldClassHeader = VentesNavHeader.getAttribute("class");
        var oldClassNav = NavVentes.getAttribute("class");
        VentesNavHeader.setAttribute("class", oldClassHeader + " active");
        NavVentes.setAttribute("class", oldClassNav + " active");

    </script>
@endsection
