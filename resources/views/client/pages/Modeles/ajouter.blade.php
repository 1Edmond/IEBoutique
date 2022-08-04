@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
@endsection
@section('InfoLabel')
    Page de modèle d'article
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour pouvoir ajouter le votre modèle. Exemple pour un cartion d'un article donné
        avec une quantité de 25.
    </p>
@endsection


@section('content')
    <div class="form-element-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="form-element-list">
                        <div class="basic-tb-hd">
                            <h2 class="text-center">Formulaire d'ajout de modèle d'article</h2>
                        </div>

                        <form action="{{ route('User.Modele.Add') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="ModeleLibelle">Description du modèle</label>
                                        <div class="nk-int-st">
                                            <input type="text" name="Description" id="ModeleLibelle" class="form-control"
                                                required placeholder="Carton de 25">
                                        </div>
                                        <small class="form-text text-muted">Une description claire</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="ModeleLibelle" class="text-center">Quantité</label>
                                        <div class="nk-int-st">
                                            <input type="number" name="Quantite" id="ModeleQuantite" class="form-control"
                                                required min="1" placeholder="25">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline btn-success ">Ajouter</button>
                                        <button type="reset" class="btn btn-outline btn-danger ">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/client/js/chosen/chosen.jquery.js"></script>

    <script>
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%",
            height: "10%"
        });
        var ModelsNavHeader = document.getElementById("ModelsNavHeader");
        var NavModels = document.getElementById("NavModels");
        var oldClassHeader = ModelsNavHeader.getAttribute("class");
        var oldClassNav = NavModels.getAttribute("class");
        ModelsNavHeader.setAttribute("class", oldClassHeader + " active");
        NavModels.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
