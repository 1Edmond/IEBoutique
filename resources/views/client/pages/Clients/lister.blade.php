@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
@endsection
@section('InfoLabel')
    Page de la liste des clients de votre boutique.
@endsection



@section('InfoDescription')
    <p>
        Liste de vos différents clients.
    </p>
@endsection

@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste de vos différents clients.</h2>
                            <p>La liste des clients s'affichera en dessous, vous pouvez recherchez un client en
                                particulier ou également trier la liste des clients obtenues.</p>
                        </div>
                        <div class="table">
                            <table id="ModeleDataTable" class="table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nom</th>
                                        <th class="text-center">Prénom</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Contact</th>
                                        <th class="text-center">Adresse</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($clients as $item)
                                        <tr>
                                            <td class="text-center text-truncate" style="max-width: 150px;">
                                                {{ $item->Nom }}</td>
                                            <td class="text-center text-truncate" style="max-width: 150px;">
                                                {{ $item->Prenom }}</td>
                                            <td class="text-center text-truncate" style="max-width: 150px;">
                                                {{ $item->Email }}</td>
                                            <td class="text-center text-truncate" style="max-width: 150px;">
                                                {{ $item->Contact }}</td>
                                            <td class="text-center text-truncate" style="max-width: 100px;">
                                                {{ $item->Adresse }}</td>
                                            <td class="text-center button-icon-btn  button-icon-btn-cl sm-res-mg-t-30">
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer {{ $item->Nom . ' ' . $item->Prenom }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                                <button class="btn btn-cyan cyan-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#modifiermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="bottom"
                                                    title="Modifier {{ $item->Nom . ' ' . $item->Prenom }}"><i
                                                        class="notika-icon notika-menus"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                Aucun client de disponible pour le moment
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @foreach ($clients as $item)
                                <div class="modal animated flash" id="supprimermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="supprimermodalLabel">Confirmez la
                                                    suppression le client</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    <strong class="text-danger text-center">
                                                        <i> EN SUPPRIMANT LE CLIENT, TOUTES LES VENTES DU CLIENT SERONT
                                                            EGALEMENT SUPPRIME.
                                                        </i>
                                                    </strong>
                                                    <br>
                                                    Voulez-vous vraiment supprimer
                                                    <a href="#" class="text-dark" data-toggle="tooltip"
                                                        title="{{ $item->Nom . ' ' . $item->Prenom }}">
                                                        {{ $item->Nom . ' ' . $item->Prenom }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button"
                                                    href="{{ route('User.Client.Delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-outline">Confirmer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal animated flash" id="modifiermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modifiermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="modifiermodalLabel">Modification du
                                                    client
                                                    {{ $item->Nom . ' ' . $item->Prenom }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('User.Client.Update') }}" method="POST">
                                                <div class="modal-body">
                                                    <div class="form-element">
                                                        @csrf
                                                        <div class="mb-3 col-lg-6 hidden">
                                                            <input type="text" class="form-control" name="Id"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label for="Libelle{{ $item->id }}"
                                                                class="form-label">Nom </label>
                                                            <input type="text" class="form-control" name="Nom"
                                                                id="Libelle{{ $item->id }}"
                                                                value="{{ $item->Nom }}" max="150"
                                                                aria-describedby="helpNom{{ $item->id }}"
                                                                placeholder="Saisissez le nom du client.">
                                                            <small id="helpNom{{ $item->id }}"
                                                                class="form-text text-muted">Le nom du client</small>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Prenom{{ $item->id }}"
                                                                    class="form-label">Prénom</label>
                                                                <input type="text" class="form-control" name="Prenom"
                                                                    id="Prenom{{ $item->Prenom }}"
                                                                    value="{{ $item->Prenom }}" min="1"
                                                                    aria-describedby="helpPrenom{{ $item->Prenom }}"
                                                                    placeholder="Saisissez le prénom du client.">
                                                                <small id="helpPrenom{{ $item->Prenom }}"
                                                                    class="form-text text-muted">Le prénom du
                                                                    client</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Adresse{{ $item->id }}"
                                                                    class="form-label">Adresse</label>
                                                                <input type="text" class="form-control" name="Adresse"
                                                                    id="Adresse{{ $item->Adresse }}"
                                                                    value="{{ $item->Adresse }}" min="1"
                                                                    aria-describedby="helpAdresse{{ $item->Adresse }}"
                                                                    placeholder="Saisissez l'adresse du client.">
                                                                <small id="helpAdresse{{ $item->Prenom }}"
                                                                    class="form-text text-muted">l'adresse du
                                                                    client</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Contact{{ $item->id }}"
                                                                    class="form-label">Contact</label>
                                                                <input type="text" class="form-control" name="Contact"
                                                                    id="Contact{{ $item->Contact }}"
                                                                    value="{{ $item->Contact }}" min="1"
                                                                    aria-describedby="helpContact{{ $item->Contact }}"
                                                                    placeholder="Saisissez le contact du client.">
                                                                <small id="helpContact{{ $item->Contact }}"
                                                                    class="form-text text-muted">Le contact du
                                                                    client</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                            <div class="form-group">
                                                                <label for="Email{{ $item->id }}"
                                                                    class="form-label">Email</label>
                                                                <input type="text" class="form-control" name="Email"
                                                                    id="Email{{ $item->Email }}"
                                                                    value="{{ $item->Email }}" min="1"
                                                                    aria-describedby="helpEmail{{ $item->Email }}"
                                                                    placeholder="Saisissez l'email du client.">
                                                                <small id="helpEmail{{ $item->Email }}"
                                                                    class="form-text text-muted"> L'email du client</small>
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
    <script src="/client/js/chosen/chosen.jquery.js"></script>
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>

    <script>
        $('[rel="tooltip"]').tooltip({
            trigger: "hover"
        });
        $('#ModeleDataTable').DataTable({
            "language": {
                "url": "/French.json"
            }
        });
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });
        var ModelsNavHeader = document.getElementById("ModelsNavHeader");
        var NavModels = document.getElementById("NavModels");
        var oldClassHeader = ModelsNavHeader.getAttribute("class");
        var oldClassNav = NavModels.getAttribute("class");
        ModelsNavHeader.setAttribute("class", oldClassHeader + " active");
        NavModels.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
