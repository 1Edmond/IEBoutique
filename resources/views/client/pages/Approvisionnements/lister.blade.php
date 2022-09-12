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
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Modèle</th>
                                        <th class="text-center">Prix</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($approvisionnements as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->DateAppro }}</td>
                                            <td class="text-center">{{ $item->Quantite }}</td>
                                            @if ($item->ModeleId > 0)
                                                @foreach ($modeles as $itemModele)
                                                    @if ($itemModele->id == $item->ModeleId)
                                                        <td class="text-center">
                                                            {{ $itemModele->Description }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @else
                                                <td class="text-center">Pas de modèle</td>
                                            @endif
                                            <td class="text-center">{{ $item->Prix }} fcfa</td>
                                            @if ($item->CommandeId > 0)
                                                <td class="text-center">Commande</td>
                                            @else
                                                <td class="text-center">Ravitaillement</td>
                                            @endif
                                            <td class="text-center">
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer l'approvisionnement du {{ $item->DateAppro }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                                <button
                                                    class="btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#detailsmodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="top"
                                                    title="Détails sur l'approvisionnement du {{ $item->DateAppro }}"><i
                                                        class="notika-icon notika-right-arrow"></i></button>
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
                            @foreach ($approvisionnements as $item)
                                <div class="modal animated flash" id="detailsmodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="supprimermodalLabel">Détails sur
                                                    l'approvisionnement du {{ $item->DateAppro }} </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                <div class="col-lg-6">
                                                    <li> Date de l'approvisionnement :
                                                        <strong>
                                                            {{ $item->DateAppro }}
                                                        </strong>
                                                    </li>
                                                </div>
                                                <div class="col-lg-6">
                                                    <li> Quantité approvisionnée :
                                                        <strong>
                                                            {{ $item->Quantite }}
                                                        </strong>
                                                    </li>
                                                </div>
                                                <div class="col-lg-6">
                                                    <li> Modèle de l'approvisionnement :
                                                        <strong>
                                                            @if ($item->ModeleId > 0)
                                                                @foreach ($modeles as $itemMo)
                                                                    @if ($item->ModeleId == $itemMo->id)
                                                                        {{ $itemMo->Description }}
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                Pas de modèle
                                                            @endif
                                                        </strong>
                                                    </li>
                                                </div>
                                                <div class="col-lg-6">
                                                    <li> Type d'approvisionnement :
                                                        <strong>
                                                            @if ($item->CommandeId > 0)
                                                                Commande
                                                            @else
                                                                Ravitaillement
                                                            @endif
                                                        </strong>
                                                    </li>
                                                </div>
                                                <div class="col-lg-6">
                                                    <li> Article approvisionnéss :
                                                        <strong>
                                                            @if ($item->CommandeId > 0)
                                                                @foreach ($commandes as $itemCo)
                                                                    @if ($item->CommandeId == $itemCo->id)
                                                                        {{ $itemCo->Article }}
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach ($articles as $itemArticles)
                                                                    @if ($item->ArticleId == $itemArticles->id)
                                                                        {{ $itemArticles->Libelle }}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </strong>
                                                    </li>
                                                </div>
                                                <div class="col-lg-6">
                                                    <li> Prix de l'approvisionnement :
                                                        <strong>
                                                            {{ $item->Prix }} fcfa
                                                        </strong>
                                                    </li>
                                                </div>
                                                </p>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                @if ($item->CommandeId > 0)
                                                    @foreach ($commandes as $itemCommandes)
                                                        @if ($item->CommandeId == $itemCommandes->id)
                                                            <div class="panel panel-collapse col">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a class="collapsed" data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-Trie{{ $item->id }}"
                                                                            aria-expanded="false">
                                                                            Informations sur la commande du
                                                                            {{ $itemCommandes->DateCommande }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-Trie{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <div class="col-lg-6">
                                                                            <li> Date de la commande :
                                                                                <strong>
                                                                                    {{ $itemCommandes->DateCommande }}
                                                                                </strong>
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <li> Article commandé :
                                                                                <strong>
                                                                                    {{ $itemCommandes->Article }}
                                                                                </strong>
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <li> Fournisseur :
                                                                                <strong>
                                                                                    {{ $itemCommandes->Fournisseur }}
                                                                                </strong>
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <li> Quantité commandée :
                                                                                <strong>
                                                                                    {{ $itemCommandes->Quantite }}
                                                                                </strong>
                                                                            </li>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <li> Modèle de la commande :
                                                                                <strong>
                                                                                    @if ($itemCommandes->ModeleId > 0)
                                                                                        @foreach ($modeles as $itemCoMo)
                                                                                            @if ($itemCommandes->ModeleId == $itemCoMo->id)
                                                                                                {{ $itemCoMo->Description }}
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @else
                                                                                        Pas de modèle
                                                                                    @endif
                                                                                </strong>
                                                                            </li>
                                                                        </div>
                                                                        @foreach ($entrepots as $itemEnMo)
                                                                            @if ($itemEnMo->id == $itemCommandes->EntrepotId)
                                                                                <div class="col-lg-6">
                                                                                    <li> Entrepôt de la commande :
                                                                                        <strong>
                                                                                            {{ $itemEnMo->Description }}
                                                                                        </strong>

                                                                                    </li>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <li> Adresse de livraison de la commande
                                                                                        :
                                                                                        <strong>
                                                                                            {{ $itemEnMo->Adresse }}
                                                                                        </strong>
                                                                                    </li>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal animated flash" id="supprimermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
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
                                                    Voulez-vous vraiment supprimer l'approvisionnement du
                                                    <a href="#" class="text-dark" data-toggle="tooltip"
                                                        title="{{ $item->DateAppro }}">
                                                        {{ $item->DateAppro }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button"
                                                    href="{{ route('User.Approvisionnement.Delete', ['id' => $item->id]) }}"
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
        var ApprovisionnementNavHeader = document.getElementById("ApprovisonnementNavHeader");
        var Approvisionnements = document.getElementById("NavApprovisionnements");
        var oldClassHeader = ApprovisionnementNavHeader.getAttribute("class");
        var oldClassNav = Approvisionnements.getAttribute("class");
        ApprovisionnementNavHeader.setAttribute("class", oldClassHeader + " active");
        Approvisionnements.setAttribute("class", oldClassNav + " active");
        $('#CategorieDataTable').DataTable({
            "language": {
                "url": "/French.json"
            },
            order: [
                [0, 'desc']
            ],
        });
        $('[rel="tooltip"]').tooltip({
            trigger: "hover"
        });
    </script>
@endsection
