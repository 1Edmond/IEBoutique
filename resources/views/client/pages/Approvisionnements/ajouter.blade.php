@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
    <link rel="stylesheet" href="/client/css/bootstrap-select/bootstrap-select.css">
@endsection

@section('InfoLabel')
    Page d'approvisionnement
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour ajouter un Approvisionnement
    </p>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="form-example-wrap mg-t-30">
                    <div class="cmp-tb-hd cmp-int-hd">
                        <h2>Renseignement concernant l'approvisionnement</h2>
                    </div>
                    <div class="widget-tabs-list">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#ravitaillement">Ravitaillement</a></li>
                            <li><a data-toggle="tab" href="#commande">Commande</a></li>
                        </ul>
                        <div class="tab-content tab-custom-st">
                            <div id="ravitaillement" class="tab-pane fade in active">
                                <div class="tab-ctn">
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
                                                            <option disabled selected>Séléctionnez l'article </option>
                                                            @forelse ($articles as $item)
                                                                <option title="Prix {{ $item->Prix }} fcfa"
                                                                    value="{{ $item->id }}">{{ $item->Libelle }}
                                                                </option>
                                                            @empty
                                                                <option disabled value="">Aucun article de
                                                                    disponible</option>
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
                                                    <label class="hrzn-fm">Entrepôt</label>
                                                </div>
                                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="chosen-select-act fm-cmp-mg">
                                                        <select class="chosen" id="EntrepotSelect" required
                                                            data-placeholder="Séléctionnez l'entrepôt'">
                                                            <option disabled selected>Séléctionnez l'entrepôt</option>
                                                            @forelse ($entrepots as $item)
                                                                <option title="Adresse: {{ $item->Adresse }}"
                                                                    value="{{ $item->id }}">{{ $item->Description }}
                                                                </option>
                                                            @empty
                                                                <option disabled value="">Aucun entrepôt de
                                                                    disponible
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
                                                    <label class="hrzn-fm text-center">Quantité</label>
                                                </div>
                                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="number" required id="ApproQuantiteRavi" min="1"
                                                            onchange="QTEInfo(this)" class="form-control input-sm"
                                                            placeholder="Ajouter une durée personnalisée">
                                                    </div>
                                                    <small class="text-center">Saisissez la quantité à vendre</small>
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
                                                        <select class="chosen" id="ModeleSelectRavi" required
                                                            data-placeholder="Séléctionnez l'article">
                                                            <option disabled selected>Séléctionnez le modèle</option>
                                                            <option value="0" selected>Pas de modèle</option>
                                                            @forelse ($modeles as $item)
                                                                <option title="Quantité : {{ $item->Quantite }}"
                                                                    value="{{ $item->id }}">{{ $item->Description }}
                                                                </option>
                                                            @empty
                                                                <option disabled value="">Aucun modèle de
                                                                    disponible
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
                                                    <label class="hrzn-fm text-center">Prix</label>
                                                </div>
                                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="number" required id="ApproPrixRavi" min="0"
                                                            class="form-control input-sm"
                                                            placeholder="Le prix total de l'approvisionnement 😊">
                                                    </div>
                                                    <small class="text-center">Prix total</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <button class="btn btn-outline btn-success" id="ValiderRavitaillement"> Ajouter</button>
                            </div>
                            <div id="commande" class="tab-pane fade">
                                <div class="tab-ctn">

                                    <div class="form-example-int form-horizental">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Commande</label>
                                                </div>
                                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="chosen-select-act fm-cmp-mg">
                                                        <select class="chosen" id="CommandeSelect" rel="tooltip"
                                                            data-placement="left"
                                                            data-placeholder="Séléctionnez la commande">
                                                            <option disabled selected>Séléctionnez la commande</option>
                                                            @forelse ($commandes as $item)
                                                                <option title="Du fournisseur: {{ $item->Fournisseur }}"
                                                                    value="{{ $item->id }}">{{ $item->Article }}
                                                                </option>
                                                            @empty
                                                                <option disabled value="">Aucune commande de
                                                                    disponible
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    <small class="text-center">Peut être vide</small>
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
                                                        <input type="number" required id="ApproQuantiteCommande"
                                                            min="1" onchange="QTEInfo(this)"
                                                            class="form-control input-sm"
                                                            placeholder="Ajouter une durée personnalisée">
                                                    </div>
                                                    <small class="text-center">Saisissez la quantité à vendre</small>
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
                                                        <select class="chosen" id="ModeleSelectCommande" required
                                                            data-placeholder="Séléctionnez l'article">
                                                            <option disabled selected>Séléctionnez le modèle</option>
                                                            <option value="0" selected>Pas de modèle</option>
                                                            @forelse ($modeles as $item)
                                                                <option title="Quantité : {{ $item->Quantite }}"
                                                                    value="{{ $item->id }}">
                                                                    {{ $item->Description }}
                                                                </option>
                                                            @empty
                                                                <option disabled value="">Aucun modèle de
                                                                    disponible
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
                                                    <label class="hrzn-fm text-center">Prix</label>
                                                </div>
                                                <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="number" required id="ApproPrixCommande"
                                                            min="0" class="form-control input-sm"
                                                            placeholder="Le prix total de l'approvisionnement 😊">
                                                    </div>
                                                    <small class="text-center">Prix total</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <button class="btn btn-outline btn-success" id="ValiderCommande"> Ajouter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 animation-action" hidden id="ApprovisionnementDiv">
                <div class="form-example-wrap mg-t-30">
                    <div class="card" id="Approvisionnement" hidden>
                        <div class="card-body">
                            <h4 class="card-title" id="ApprovisionnementInfoHeader">Approvisionnement</h4>
                            <p class="card-text">Informations sur l'approvisionnement</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <div class="list-group-item hidden">
                                <h1-6>Article Id
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementArticleIdDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item hidden">
                                <h1-6>Modele Id
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementModeleIdDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item hidden">
                                <h1-6>Entrepôt Id
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementEntrepotIdDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item" id="ArticleDiv">
                                <h1-6> Article
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementArticleDiv">

                                    </span>
                                </h1-6>
                            </div>

                            <div class="list-group-item">
                                <h1-6>
                                    Quantité
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementQuantiteDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item">
                                <h1-6>
                                    Modèle
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementModeleDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item" id="EntrepotDiv">
                                <h1-6>
                                    Entrepôt
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementEntrepotDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item hidden">
                                <h1-6>Commande Id
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementCommandeIdDiv">

                                    </span>
                                </h1-6>
                            </div>
                            <div class="list-group-item" id="CommandeInfoDiv">
                                <h1-6>
                                    Commande
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementCommandeDiv">

                                    </span>
                                    <div class="panel panel-collapse notika-accrodion-cus">
                                        <div class="panel-heading" role="tab">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordionBlue"
                                                    href="#commandeInfo" aria-expanded="true">
                                                    Détails
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="commandeInfo" class="collapse" role="tabpanel">
                                            <div class="panel-body">

                                                <div class="list-group-item ">
                                                    <h1-6> Date de la commande :
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoDate">

                                                        </span>
                                                    </h1-6>
                                                </div>
                                                <div class="list-group-item ">
                                                    <h1-6> Libelle de l'article
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoArticle">

                                                        </span>
                                                    </h1-6>
                                                </div>
                                                <div class="list-group-item ">
                                                    <h1-6> Nom du fournisseur
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoFournisseur">

                                                        </span>
                                                    </h1-6>
                                                </div>
                                                <div class="list-group-item ">
                                                    <h1-6> Quantité commandée
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoQuantite">

                                                        </span>
                                                    </h1-6>
                                                </div>
                                                <div class="list-group-item ">
                                                    <h1-6> Modele
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoModele">

                                                        </span>
                                                    </h1-6>
                                                </div>
                                                <div class="list-group-item ">
                                                    <h1-6> Entrepôt
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoEntrepot">

                                                        </span>
                                                    </h1-6>
                                                </div>
                                                <div class="list-group-item ">
                                                    <h1-6> Adresse de livraison
                                                        <span class="badge bg-primary ml-5 text-center"
                                                            id="commandeInfoLivraison">

                                                        </span>
                                                    </h1-6>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </h1-6>
                            </div>
                            <div class="list-group-item">
                                <h1-6>
                                    Prix Total
                                    <span class="badge bg-primary ml-5 text-center" id="ApprovisionnementPrixDiv">

                                    </span>
                                </h1-6>
                            </div>
                        </ul>
                        <form action="{{ route('User.Approvisionnement.Add') }}" method="POST"
                            id="FormApprovisionnement">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-success">Valider</button>
                        </form>
                    </div>

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
          var ApprovisionnementNavHeader = document.getElementById("ApprovisonnementNavHeader");
        var Approvisionnements = document.getElementById("NavApprovisionnements");
        var oldClassHeader = ApprovisionnementNavHeader.getAttribute("class");
        var oldClassNav = Approvisionnements.getAttribute("class");
        ApprovisionnementNavHeader.setAttribute("class", oldClassHeader + " active");
        Approvisionnements.setAttribute("class", oldClassNav + " active");
        $('.chosen').chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucun modèle disponible !",
            width: "95%",

        });
        $('[rel="tooltip"]').tooltip({
            trigger: "hover"
        });
        var form = document.getElementById("FormApprovisionnement");
        var article = document.getElementById("ArticleSelect");
        var commande = document.getElementById("CommandeSelect");
        var entrepot = document.getElementById("EntrepotSelect");
        var infoDiv = document.getElementById("ApprovisionnementDiv");
        var Approvisionnement = document.getElementById("Approvisionnement");
        document.getElementById('ValiderCommande').addEventListener('click', function() {
            CreateApproInformationCommande();
        });
        document.getElementById('ValiderRavitaillement').addEventListener('click', function() {
            CreateApproInformationRavi();
        });
        var type = "";

        function ControlRavi() {
            var modele = document.getElementById("ModeleSelectRavi");
            if (article.options[article.selectedIndex].text == "Séléctionnez l'article" || entrepot.options[entrepot
                    .selectedIndex].text == "Séléctionnez l'entrepôt" || modele.options[modele.selectedIndex].text ==
                "Séléctionnez le modèle" || document.getElementById("ApproQuantiteRavi").value < 1 || document
                .getElementById("ApproPrixRavi").value < 1)
                return false;
            return true;
        }

        function CreateApproInformationRavi() {
            if (ControlRavi()) {
                type = "Ravitaillement";
                document.getElementById("CommandeInfoDiv").hidden = true;
                var quantite = document.getElementById("ApproQuantiteRavi");
                var modele = document.getElementById("ModeleSelectRavi");
                var prix = document.getElementById("ApproPrixRavi");
                infoDiv.hidden = false;
                Approvisionnement.hidden = false;
                document.getElementById("ApprovisionnementArticleIdDiv").innerHTML = article.options[article.selectedIndex]
                    .value;
                document.getElementById("ApprovisionnementArticleDiv").innerHTML = article.options[article.selectedIndex]
                    .text;
                document.getElementById("ApprovisionnementEntrepotDiv").innerHTML = entrepot.options[entrepot.selectedIndex]
                    .text;
                document.getElementById("ApprovisionnementEntrepotIdDiv").innerHTML = entrepot.options[entrepot
                        .selectedIndex]
                    .value;
                document.getElementById("ApprovisionnementPrixDiv").innerHTML = prix.value;
                document.getElementById("ApprovisionnementQuantiteDiv").innerHTML = quantite.value;
                document.getElementById("ApprovisionnementModeleIdDiv").innerHTML = modele.options[modele.selectedIndex]
                    .value;
                document.getElementById("ApprovisionnementModeleDiv").innerHTML = modele.options[modele.selectedIndex]
                    .text;
                CreateFormData();
            } else {
                $.growl('Erreur, vérifiez les entrées du ravitaillement.', {
                    type: 'danger',
                    delay: 5000,
                });
            }
        }

        function MakeCommandeDetails() {
            var commandes = {!! json_encode($commandes) !!};
            var commandeId = document.getElementById("ApprovisionnementCommandeIdDiv").innerHTML;
            for (var index = 0; index < commandes.length; index++) {
                const element = commandes[index];

                if (element["id"] == commandeId) {
                    document.getElementById("commandeInfoDate").innerHTML = element[
                        'DateCommande'];
                    document.getElementById("commandeInfoArticle").innerHTML = element['Article'];
                    document.getElementById("commandeInfoQuantite").innerHTML = element['Quantite'];

                    var entrepots = {!! json_encode($entrepots) !!};
                    for (var indexEntrepot = 0; indexEntrepot < entrepots.length; indexEntrepot++) {
                        const elementEntrepot = entrepots[indexEntrepot];
                        if (element['EntrepotId'] == elementEntrepot['id']) {
                            document.getElementById("commandeInfoEntrepot").innerHTML = elementEntrepot[
                                'Description'];
                            document.getElementById("commandeInfoLivraison").innerHTML =
                                elementEntrepot['Adresse'];
                            break;
                        }
                    }
                    document.getElementById("commandeInfoFournisseur").innerHTML = element[
                        'Fournisseur'];
                    var modeles = {!! json_encode($modeles) !!};
                    for (var indexModele = 0; indexModele < modeles.length; indexModele++) {
                        const elementModele = modeles[indexModele];
                        if (element['ModeleId'] == elementModele['id']) {
                            document.getElementById("commandeInfoModele").innerHTML = elementModele[
                                'Description'];
                            break;
                        }
                    }
                }
            }
        }

        function ControlCommande() {
            var modele = document.getElementById("ModeleSelectCommande");
            if (commande.options[commande.selectedIndex].text == "Séléctionnez l'entrepôt" || modele.options[modele
                    .selectedIndex].text == "Séléctionnez le modèle" || document.getElementById("ApproQuantiteCommande")
                .value < 1 || document.getElementById("ApproPrixCommande").value < 1)
                return false;
            return true;
        }

        function CreateApproInformationCommande() {
            if (ControlCommande()) {
                type = "Commande";
                document.getElementById("ArticleDiv").hidden = true;
                document.getElementById("EntrepotDiv").hidden = true;
                infoDiv.hidden = false;
                Approvisionnement.hidden = false;
                var quantite = document.getElementById("ApproQuantiteCommande");
                var modele = document.getElementById("ModeleSelectCommande");
                var prix = document.getElementById("ApproPrixCommande");
                infoDiv.hidden = false;
                Approvisionnement.hidden = false;
                document.getElementById("ApprovisionnementCommandeIdDiv").innerHTML = commande.options[commande
                        .selectedIndex]
                    .value;
                document.getElementById("ApprovisionnementCommandeDiv").innerHTML = commande.options[commande.selectedIndex]
                    .text;
                document.getElementById("ApprovisionnementPrixDiv").innerHTML = prix.value;
                document.getElementById("ApprovisionnementQuantiteDiv").innerHTML = quantite.value;
                document.getElementById("ApprovisionnementModeleIdDiv").innerHTML = modele.options[modele.selectedIndex]
                    .value;
                document.getElementById("ApprovisionnementModeleDiv").innerHTML = modele.options[modele.selectedIndex]
                    .text;
                MakeCommandeDetails();
                CreateFormData()
            } else {
                $.growl('Erreur, vérifiez les entrées de la commande.', {
                    type: 'danger',
                    delay: 5000,
                });
            }

        }

        function CreateFormData() {
            var data = {};
            if (type == "Commande") {
                var Approvisionnement = {
                    "Quantite": document.getElementById("ApprovisionnementQuantiteDiv").innerHTML,
                    "Modele": document.getElementById("ApprovisionnementModeleIdDiv").innerHTML,
                    "Commande": document.getElementById("ApprovisionnementCommandeIdDiv").innerHTML,
                    "Prix": document.getElementById("ApprovisionnementPrixDiv").innerHTML,
                };
                data = Approvisionnement;
            } else {
                var Approvisionnement = {
                    "Quantite": document.getElementById("ApprovisionnementQuantiteDiv").innerHTML,
                    "Modele": document.getElementById("ApprovisionnementModeleIdDiv").innerHTML,
                    "Article": document.getElementById("ApprovisionnementArticleIdDiv").innerHTML,
                    "Entrepot": document.getElementById("ApprovisionnementEntrepotIdDiv").innerHTML,
                    "Prix": document.getElementById("ApprovisionnementPrixDiv").innerHTML,
                };
                data = Approvisionnement;
            }
            for (var key in data)
                MakeInputCache(key, data[key]);
            MakeInputCache("type", type);
        }

        function MakeInputCache(name, value) {
            var inputCache = document.createElement("input");
            inputCache.setAttribute("name", name);
            inputCache.setAttribute("value", value);
            inputCache.setAttribute("class", "hidden");
            form.appendChild(inputCache)
        }
    </script>
@endsection
