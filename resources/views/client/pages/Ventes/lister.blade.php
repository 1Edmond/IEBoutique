@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
@endsection

@section('InfoLabel')
    Page des catégories disponibles
@endsection



@section('InfoDescription')
    <p>
        La liste des catégories disponibles s'affichera ici.
        @if ($user->Role == 'Gérant')
            <p>
                Si aucune catégorie ne correspond à votre attente, vous pouvez en ajouter.
            </p>
        @else
            <p>
                Si aucune catégorie ne correspond à votre attente, référencez-vous à votre gérant pour la création de la
                catégorie que vous souhaitez.
            </p>
        @endif
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
                            <table id="VenteDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date de la vente</th>
                                        <th class="text-center">Nombre d'articles vendus</th>
                                        <th class="text-center">Quantité total d'articles vendus</th>
                                        <th class="text-center">Prix total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ventes as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->DateVente }}</td>
                                            <td class="text-center">{{ $item->NbrVente }}</td>
                                            <td class="text-center">{{ $item->TotalVente }}</td>
                                            <td class="text-center">{{ $item->PrixTotalVente }}</td>
                                            <td class="text-center button-icon-btn  button-icon-btn-cl sm-res-mg-t-30">
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer la vente du {{ $item->DateVente }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                                <button
                                                    class="btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#detailsmodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="top"
                                                    title="Détails sur la vente du {{ $item->DateVente }}"><i
                                                        class="notika-icon notika-right-arrow"></i></button>
                                                <button data-toggle="tooltip" style="background-color: #00c292"
                                                    data-placement="left"
                                                    title="Imprimer cette vente : {{ $item->DateVente }}" class="btn"><i
                                                        class="notika-icon notika-sent"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center">
                                                Aucune vente pour le moment
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @foreach ($ventes as $item)
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
                                                    <a href="#" class="text-dark" data-toggle="tooltip"
                                                        title="{{ $item->DateVente }}">
                                                        {{ $item->DateVente }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button"
                                                    href="{{ route('User.Vente.Delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-outline">Confirmer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal animated rubberBand" id="detailsmodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="detailsmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="detailsmodalLabel"> Détails sur la
                                                    vente du
                                                    {{ $item->DateVente }} </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-24">
                                                    <div class="accordion-stn sm-res-mg-t-30">
                                                        <div class="panel-group" data-collapse-color="nk-blue"
                                                            id="accordionBlue{{ $item->id }}" role="tablist"
                                                            aria-multiselectable="true">
                                                            <div class="panel panel-collapse col">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-one{{ $item->id }}"
                                                                            aria-expanded="true">
                                                                            Informations élémentaires sur la vente du
                                                                            {{ $item->DateVente }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-one{{ $item->id }}"
                                                                    class="collapse animated flipInX in" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <li>
                                                                                Nombre d'articles vendus :
                                                                                <strong>
                                                                                    {{ $item->NbrVente }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Quantité totale d'articles vendus :
                                                                                <strong>
                                                                                    {{ $item->TotalVente }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Prix de la vente :
                                                                                <strong>
                                                                                    {{ $item->PrixTotalVente }}
                                                                                </strong>
                                                                            </li>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-collapse col">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a class="collapsed" data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-two{{ $item->id }}"
                                                                            aria-expanded="false">
                                                                            Informations supplémentaire sur la vente du
                                                                            {{ $item->DateVente }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-two{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <table class="table table-hover table-striped"
                                                                            id="ArticleEntrepotTable{{ $item->id }}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Article
                                                                                    </th>
                                                                                    <th class="text-center">Prix</td>
                                                                                    <th class="text-center">Quantité vendu
                                                                                    </th>
                                                                                    <th class="text-center">Réudction</th>
                                                                                    <th class="text-center">Prix total</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($ventesInfo as $itemVenteInfo)
                                                                                    @if ($item->id == $itemVenteInfo->VenteId)
                                                                                        @foreach ($articles as $itemArticle)
                                                                                            @if ($itemArticle->id == $itemVenteInfo->ArticleId)
                                                                                                <tr>
                                                                                                    <td
                                                                                                        class="text-center">
                                                                                                        {{ $itemArticle->Libelle }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class="text-center">
                                                                                                        {{ $itemArticle->Prix }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class="text-center">
                                                                                                        {{ $itemVenteInfo->Quantite }}
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class="text-center">
                                                                                                        {{ $itemVenteInfo->Reduction }}
                                                                                                        %
                                                                                                    </td>
                                                                                                    <td
                                                                                                        class="text-center">
                                                                                                        {{ $itemVenteInfo->PrixVente }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-collapse col">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a class="collapsed" data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-Trie{{ $item->id }}"
                                                                            aria-expanded="false">
                                                                            Informations sur le client de la vente du
                                                                            {{ $item->DateVente }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-Trie{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        @if ($item->ClientId > 0)
                                                                            @forelse ($clients as $itemClient)
                                                                                @if ($itemClient->id == $item->ClientId)
                                                                                    <li>
                                                                                        Nom du client :
                                                                                        <strong>
                                                                                            {{ $itemClient->Nom }}
                                                                                        </strong>
                                                                                    </li>
                                                                                    <li>
                                                                                        Email du client :
                                                                                        <strong>
                                                                                            {{ $itemClient->Email }}
                                                                                        </strong>
                                                                                    </li>
                                                                                    <li>
                                                                                        Prénom du client :
                                                                                        <strong>
                                                                                            {{ $itemClient->Prenom }}
                                                                                        </strong>
                                                                                    </li>
                                                                                    <li>
                                                                                        Adresse du client :
                                                                                        <strong>
                                                                                            {{ $itemClient->Adresse }}
                                                                                        </strong>
                                                                                    </li>
                                                                                    <li>
                                                                                        Contact du client :
                                                                                        <strong>
                                                                                            {{ $itemClient->Contact }}
                                                                                        </strong>
                                                                                    </li>
                                                                                @endif
                                                                            @empty
                                                                            @endforelse
                                                                        @else
                                                                            Pas de client pour cette vente
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer mt-5">
                                                <button type="button" class="btn btn-info btn-outline"
                                                    data-dismiss="modal">Retour</button>
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
        $('#VenteDataTable').DataTable({
            "language": {
                "url": "/French.json"
            }
        });
        $('[rel="tooltip"]').tooltip({
            trigger: "hover"
        });
        var VenteNavHeader = document.getElementById("VentesNavHeader");
        var NavVentes = document.getElementById("NavVentes");
        var oldClassHeader = VenteNavHeader.getAttribute("class");
        var oldClassNav = NavVentes.getAttribute("class");
        VenteNavHeader.setAttribute("class", oldClassHeader + " active");
        NavVentes.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
