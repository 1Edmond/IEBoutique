@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
@endsection

@section('InfoLabel')
    Page d'ajout de fournisseur
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour ajouter un fournisseur.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Formulaire d'ajout de fournisseur.</h2>
                            <p>
                                Tous les champs ci dessous sauf le site web sont nécessaires pour ajouter le fournisseur.
                            </p>
                        </div>
                        <form action="{{ route('User.Fournisseur.Add') }}" method="post">
                            @csrf
                            <div class="mb-3 col-lg-4">
                                <label for="Nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" name="Nom" id="Nom"
                                    aria-describedby="helpLibelle" value="{{ old('Nom') }}" required
                                    placeholder="Saisissez le nom du fournisseur">
                                <small id="helpNom" class="form-text text-muted">Nom Help text</small>
                                @error('Nom')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="Prenom" class="form-label">Prénom</label>
                                <input type="text" class="form-control" name="Prenom" id="Prenom"
                                    value="{{ old('Prenom') }}" aria-describedby="Prenom" required
                                    placeholder="Saisissez la prénom du fournisseur">
                                <small id="Prenom" class="form-text text-muted">Prénom Help text</small>
                                @error('Prenom')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="Email" id="Email"
                                    aria-describedby="helpEmail" value="{{ old('Email') }}" required
                                    placeholder="Saisissez le mail du fournisseur">
                                <small id="helpEmail" class="form-text text-muted">Email Help text</small>
                                @error('Email')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="Adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" name="Adresse" id="Adresse"
                                    value="{{ old('Adresse') }}" aria-describedby="helpAdresse" required
                                    placeholder="Saisissez l'adresse du fournisseur">
                                <small id="helpAdresse" class="form-text text-muted">Adresse Help text</small>
                                @error('Adresse')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="Contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" name="Contact" id="Contact"
                                    aria-describedby="helpContact" value="{{ old('Contact') }}" required
                                    placeholder="Saisissez le contact du fournisseur">
                                <small id="helpContact" class="form-text text-muted">Contact Help text</small>
                                @error('Contact')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="Site" class="form-label">Site web</label>
                                <input type="text" class="form-control" name="Site" id="Site"
                                    value="Pas de site web" aria-describedby="helpSite"
                                    placeholder="Saisissez le site web du fournisseur">
                                <small id="helpSite" class="form-text text-muted">Site web Help text</small>
                                @error('Site')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-outline btn-primary ">
                                Ajouter
                            </button>
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
    <!-- Data Table JS
                                                                                                                                                                                                                                                                                                                                                                                                  ============================================ -->
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>
    <script>
        var FournisseurNavHeader = document.getElementById("FournisseursNavHeader");
        var NavFournisseurs = document.getElementById("NavFournisseurs");
        var oldClassHeader = FournisseurNavHeader.getAttribute("class");
        var oldClassNav = NavFournisseurs.getAttribute("class");
        FournisseurNavHeader.setAttribute("class", oldClassHeader + " active");
        NavFournisseurs.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
