@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
@endsection

@section('InfoLabel')
    Page des historiques de d'activités de la boutique.
@endsection



@section('InfoDescription')
    <p>
        Les différentes opérations de votre boutique vous sont affichés sur cette page.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste de votre historique d'activités.</h2>
                            <p>La liste des historiques d'activités s'afficheront en dessous, vous pouvez recherchez un
                                historique en
                                particulier ou également trier la liste des historiques obtenues.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="CategorieDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Libelle</th>
                                        <th class="text-center">Decsription</th>
                                        <th class="text-center">Date de l'opération</th>
                                        <th class="text-center">Mené par</th>
                                        <th class="text-center">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($historiques as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Libelle }}</td>
                                            <td class="text-center">{{ $item->Description }}</td>
                                            <td class="text-center">{{ $item->DateOperation }}</td>
                                            @foreach ($personnes as $itemUser)
                                                @if ($item->CommanditaireId == $itemUser->id)
                                                    <td class="text-center">

                                                        {{ $itemUser->Nom . ' ' . $itemUser->Prenom }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td>
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer l'historique {{ $item->Libelle }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">
                                                Aucun historique pour le moment
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @foreach ($historiques as $item)
                                <div class="modal animated flash" id="supprimermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg-2" role="document">
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
                                                    l'historique du
                                                    <a href="#" class="text-dark" data-toggle="tooltip"
                                                        title="{{ $item->Libelle }}">
                                                        {{ $item->Libelle }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button"
                                                    href="{{ route('User.Historique.Delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-outline">Confirmer</a>
                                            </div>
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
        $('#CategorieDataTable').DataTable({
            "language": {
                "url": "/French.json"
            },
            order: [
                [2, 'desc']
            ],
        });
        $('[rel="tooltip"]').tooltip({
            trigger: "hover"
        });
    </script>
@endsection
