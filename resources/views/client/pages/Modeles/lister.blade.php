@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
@endsection
@section('InfoLabel')
    Page de la liste des modèles d'article.
@endsection



@section('InfoDescription')
    <p>
        Liste de vos différent modèle d'article.
    </p>
@endsection

@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste des catégories disponibles.</h2>
                            <p>La liste des catégories s'afficheront en dessous, vous pouvez recherchez une catégorie en
                                particulier ou également trier la liste des catégories obtenues.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="ModeleDataTable" class=" table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($modeles as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Description }}</td>
                                            <td class="text-center">{{ $item->Quantite }}</td>
                                            <td class="text-center button-icon-btn  button-icon-btn-cl sm-res-mg-t-30">
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer {{ $item->Libelle }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                                <button class="btn btn-cyan cyan-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#modifiermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="bottom"
                                                    title="Modifier {{ $item->Libelle }}"><i
                                                        class="notika-icon notika-menus"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="3">
                                                Aucun modèle de disponible
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                             
                            </table>
                            @foreach ($modeles as $item)
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
                                                        title="{{ $item->Description }}">
                                                        {{ $item->Description }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button" href="{{route('User.Modele.Delete',['id' => $item->id])}}"
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
                                                <h5 class="modal-title text-center" id="modifiermodalLabel">Modification de {{$item->Description}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('User.Modele.Update') }}" method="POST">
                                                <div class="modal-body">
                                                    <div class="form-element">
                                                        @csrf
                                                        <div class="mb-3 col-lg-6 hidden">
                                                            <input type="text" class="form-control" name="Id"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label for="Libelle{{ $item->id }}"
                                                                class="form-label">Description </label>
                                                            <input type="text" class="form-control" name="Description"
                                                                id="Libelle{{ $item->id }}"
                                                                value="{{ $item->Description }}" max="150"
                                                                aria-describedby="helpLibelle{{ $item->id }}"
                                                                placeholder="Saisissez le libelle du modèle.">
                                                            <small id="helpLibelle{{ $item->id }}"
                                                                class="form-text text-muted">Une description claire</small>
                                                        </div>
                                                        <div class="col-lg-6 mb-3">
                                                                <div class="form-group">
                                                                <label for="Quantite{{ $item->id }}"
                                                                    class="form-label">Quantité</label>
                                                                <input type="number" class="form-control"
                                                                    name="Quantite" id="Quantite{{ $item->Quantite }}"
                                                                    value="{{ $item->Quantite }}" min="1"
                                                                    aria-describedby="helpQuantite{{ $item->Quantite }}"
                                                                    placeholder="Saisissez le libelle du modèle.">
                                                                <small id="helpQuantite{{ $item->Quantite }}"
                                                                    class="form-text text-muted">Quantité Help text</small>
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
