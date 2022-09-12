@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
@endsection

@section('InfoLabel')
    Page de la liste des fournisseurs
@endsection



@section('InfoDescription')
    <p>
        La liste de vos fournisseurs s'affichera ici.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste des fournisseurs disponibles.</h2>
                            <p>La liste des fournisseurs s'afficheront en dessous, vous pouvez recherchez une catégorie en
                                particulier ou également trier la liste des fournisseurs obtenues.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="FournisseursDataTable" class="table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nom</th>
                                        <th class="text-center">Prénom</th>
                                        <th class="text-center">Adresse</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Site web</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($fournisseurs as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Nom }}</td>
                                            <td class="text-center">{{ $item->Prenom }}</td>
                                            <td class="text-center">{{ $item->Adresse }}</td>
                                            <td class="text-center">{{ $item->Contact }}</td>
                                            <td class="text-center">{{ $item->Email }}</td>
                                            <td class="text-center">
                                                @if ($item->Site != 'Pas de site web')
                                                    <a href="https://{{ $item->Site }}" rel="tooltip"
                                                        data-placement="left" title="Visiter {{ $item->Site }}">
                                                        {{ $item->Site }}
                                                    </a>
                                                @else
                                                    {{ $item->Site }}
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer {{ $item->Nom }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                                <button class="btn btn-cyan cyan-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#modifiermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="bottom"
                                                    title="Modifier {{ $item->Nom }}"><i
                                                        class="notika-icon notika-menus"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="7">
                                                Aucun fournisseur n'est disponible
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                               
                            </table>
                            @foreach ($fournisseurs as $item)
                                <div class="modal animated flash" id="supprimermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="supprimermodalLabel">Confirmez la
                                                    suppression</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Voulez-vous vraiment supprimer
                                                    <a href="#" class="text-dark" data-toggle="tooltip"
                                                        title="{{ $item->Nom }}">
                                                        {{ $item->Nom }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button"
                                                    href="{{ route('User.Fournisseur.Delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-outline">Confirmer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal animated rubberBand" id="modifiermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modifiermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="modifiermodalLabel">Modification de
                                                    {{ $item->Nom }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('User.Fournisseur.Update') }}" method="POST">
                                                <div class="modal-body">
                                                    <div class="form-element">
                                                        @csrf
                                                        <div class="mb-3 col-lg-6 hidden">
                                                            <input type="text" class="form-control" name="Id"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label for="Nom" class="form-label">Nom</label>
                                                            <input type="text" class="form-control" name="Nom"
                                                                id="Nom" aria-describedby="helpLibelle"
                                                                value="{{ $item->Nom }}" required
                                                                placeholder="Saisissez le nom du fournisseur">
                                                            <small id="helpNom" class="form-text text-muted">Nom Help
                                                                text</small>
                                                            @error('Nom')
                                                                <div class="alert alert-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Prenom" class="form-label">Prénom</label>
                                                                <input type="text" class="form-control" name="Prenom"
                                                                    id="Prenom" value="{{ $item->Prenom }}"
                                                                    aria-describedby="Prenom" required
                                                                    placeholder="Saisissez la prénom du fournisseur">
                                                                <small id="Prenom" class="form-text text-muted">Prénom
                                                                    Help text</small>
                                                                @error('Prenom')
                                                                    <div class="alert alert-danger" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label for="Email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="Email"
                                                                id="Email" aria-describedby="helpEmail"
                                                                value="{{ $item->Email }}" required
                                                                placeholder="Saisissez le mail du fournisseur">
                                                            <small id="helpEmail" class="form-text text-muted">Email Help
                                                                text</small>
                                                            @error('Email')
                                                                <div class="alert alert-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Adresse" class="form-label">Adresse</label>
                                                                <input type="text" class="form-control" name="Adresse"
                                                                    id="Adresse" value="{{ $item->Adresse }}"
                                                                    aria-describedby="helpAdresse" required
                                                                    placeholder="Saisissez l'adresse du fournisseur">
                                                                <small id="helpAdresse"
                                                                    class="form-text text-muted">Adresse Help text</small>
                                                                @error('Adresse')
                                                                    <div class="alert alert-danger" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label for="Contact" class="form-label">Contact</label>
                                                            <input type="text" class="form-control" name="Contact"
                                                                id="Contact" aria-describedby="helpContact"
                                                                value="{{ $item->Contact }}" required
                                                                placeholder="Saisissez le contact du fournisseur">
                                                            <small id="helpContact" class="form-text text-muted">Contact
                                                                Help text</small>
                                                            @error('Contact')
                                                                <div class="alert alert-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Site" class="form-label">Site web</label>
                                                                <input type="text" class="form-control" name="Site"
                                                                    id="Site" value="{{ $item->Site }}"
                                                                    aria-describedby="helpSite"
                                                                    placeholder="Saisissez le site web du fournisseur">
                                                                <small id="helpSite" class="form-text text-muted">Site
                                                                    web Help text</small>
                                                                @error('Site')
                                                                    <div class="alert alert-danger" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-lg-12">
                                                        <a type="button" class="btn btn-outline btn-primary"
                                                            data-dismiss="modal">Annuler</a>
                                                        <button type="submit" href=""
                                                            class="btn btn-danger btn-outline">Confirmer</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/client/js/icheck/icheck.min.js"></script>
    <script src="/client/js/icheck/icheck-active.js"></script>
    <!-- Data Table JS
                                                                                                                                                                                                                                                                                              ============================================ -->
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>

    <script>
        $('[rel="tooltip"]').tooltip({
            trigger: "hover"
        });
        $('#FournisseursDataTable').DataTable({
            "language": {
                "url": "/French.json"
            }
        });

        var FournisseurNavHeader = document.getElementById("FournisseursNavHeader");
        var NavFournisseurs = document.getElementById("NavFournisseurs");
        var oldClassHeader = FournisseurNavHeader.getAttribute("class");
        var oldClassNav = NavFournisseurs.getAttribute("class");
        FournisseurNavHeader.setAttribute("class", oldClassHeader + " active");
        NavFournisseurs.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
