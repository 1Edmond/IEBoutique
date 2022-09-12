@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
@endsection

@section('InfoLabel')
    Page de la liste des commandes de la boutique.
@endsection



@section('InfoDescription')
    <p>
        Les différentes commandes de votre boutique vous sont affichés sur cette page.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste de vos commandes.</h2>
                            <p>La liste des commandes s'afficheront en dessous, vous pouvez recherchez une
                                commande en
                                particulier ou également trier la liste des commandes obtenues.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="CategorieDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date de l'opération</th>
                                        <th class="text-center">Etat de la commande</th>
                                        <th class="text-center">Article</th>
                                        <th class="text-center">Fournisseur</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($commandes as $item)
                                        <tr @if ($item->Etat == 0) class="info"
                                        @else
                                            @if ($item->Etat == 2)
                                            class="success"    
                                            @else
                                            @if ($item->Etat == 3)
                                                class="danger" @endif
                                            @endif
                                    @endif
                                    >
                                    <td class="text-center">{{ $item->DateCommande }}</td>
                                    <td class="text-center">
                                        @if ($item->Etat == 0)
                                            En attente
                                        @else
                                            @if ($item->Etat == 2)
                                                Validée
                                            @else
                                                @if ($item->Etat == 3)
                                                    Annulée
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $item->Article }}</td>
                                    <td class="text-center">{{ $item->Fournisseur }}</td>
                                    <td class="text-center">
                                        {{ $item->Quantite }}
                                        @foreach ($commandeModele as $itemModele)
                                            @if ($itemModele->id == $item->id)
                                                @if (array_key_exists($itemModele->ModeleId, $modeles))
                                                    {{ $modeles[$itemModele->ModeleId] }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if ($item->Etat == 0)
                                            <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                data-toggle="modal" data-target="#cancelmodal{{ $item->id }}"
                                                rel="tooltip" data-placement="left"
                                                title="Annuler la commande de {{ $item->Article }}"><i
                                                    class="fa fa-remove"></i></button>
                                        @endif
                                        @if ($item->Etat == 3)
                                            <button class="btn btn-success danger-icon-notika btn-reco-mg btn-button-mg"
                                                data-toggle="modal" data-target="#restoremodal{{ $item->id }}"
                                                rel="tooltip" data-placement="left"
                                                title="Restaurer la commande de {{ $item->Article }}"><i
                                                    class="fa fa-undo"></i></button>
                                        @endif
                                        <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                            data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                            rel="tooltip" data-placement="left"
                                            title="Supprimer la commande de {{ $item->Article }}"><i
                                                class="notika-icon notika-close"></i></button>
                                        @if ($item->Etat != 2)

                                            <button class="btn btn-cyan cyan-icon-notika btn-reco-mg btn-button-mg"
                                                data-toggle="modal" data-target="#modifiermodal{{ $item->id }}"
                                                rel="tooltip" data-placement="bottom"
                                                title="Modifier la commande de {{ $item->Article }}"><i
                                                    class="notika-icon notika-menus"></i></button>
                                        @endif
                                        <button class="btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg"
                                            onclick="ModeleInfo({{ $item->id }})" data-toggle="modal"
                                            data-target="#detailsmodal{{ $item->id }}" rel="tooltip"
                                            data-placement="top" title="Détails sur la commande de {{ $item->Article }}"><i
                                                class="notika-icon notika-right-arrow"></i></button>
                                    </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                Aucune commande pour le moment
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @foreach ($commandes as $item)
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
                                                        @if ($item->Etat == 0)
                                                            <p class="text-center text-danger">
                                                                <strong>
                                                                    <i>
                                                                        La commande sera annulée puis supprimée.
                                                                    </i>
                                                                </strong>
                                                            </p>
                                                        @endif
                                                        Voulez-vous vraiment supprimer
                                                        la commande de
                                                        <a href="#" class="text-dark" data-toggle="tooltip"
                                                            title="{{ $item->Article }}">
                                                            {{ $item->Article }}
                                                        </a>
                                                        ?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-outline btn-primary"
                                                        data-dismiss="modal">Annuler</a>
                                                    <a type="button"
                                                        href="{{ route('User.Commande.Delete', ['id' => $item->id]) }}"
                                                        class="btn btn-danger btn-outline">Confirmer</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal animated flash" id="cancelmodal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="cancelmodalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg-2" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="cancelmodalLabel">Confirmez
                                                        l'annulation</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Voulez-vous vraiment annuler la commande de
                                                        <a href="#" class="text-dark" data-toggle="tooltip"
                                                            title="{{ $item->Article }}">
                                                            {{ $item->Article }}
                                                        </a>
                                                        ?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-outline btn-primary"
                                                        data-dismiss="modal">Annuler</a>
                                                    <a type="button"
                                                        href="{{ route('User.Commande.Cancel', ['id' => $item->id]) }}"
                                                        class="btn btn-danger btn-outline">Confirmer</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal animated flash" id="restoremodal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="restoremodalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg-2" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="restoremodalLabel">Confirmez
                                                        la restauration</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        Voulez-vous vraiment restaurer la commande de
                                                        <a href="#" class="text-dark" data-toggle="tooltip"
                                                            title="{{ $item->Article }}">
                                                            {{ $item->Article }}
                                                        </a>
                                                        ?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-outline btn-primary"
                                                        data-dismiss="modal">Annuler</a>
                                                    <a type="button"
                                                        href="{{ route('User.Commande.Restore', ['id' => $item->id]) }}"
                                                        class="btn btn-danger btn-outline">Confirmer</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal animated fade" id="modifiermodal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modifiermodalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg-2" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('User.Commande.Update') }}" method="post">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center" id="modifiermodalLabel">
                                                            Modification
                                                            de la commande de {{ $item->Article }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="mb-3 col-lg-6" hidden>
                                                            <input type="hidden" class="form-control" name="Id"
                                                                id="Id{{ $item->id }}"
                                                                aria-describedby="helpId{{ $item->Id }}"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label class="form-label">Article</label>
                                                            <div class="chosen-select-act fm-cmp-mg">
                                                                <select class="chosen" name="Article"
                                                                    data-placeholder="Séléctionner la catégorie">
                                                                    @foreach ($articles as $article)
                                                                        @if ($article->Id == $item->ArticleId)
                                                                            <option value="{{ $article->Id }}" selected>
                                                                                {{ $article->Libelle }}</option>
                                                                        @else
                                                                            <option value="{{ $article->Id }}">
                                                                                {{ $article->Libelle }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label class="form-label">Entrepôt</label>
                                                            <div class="chosen-select-act fm-cmp-mg">
                                                                <select class="chosen" name="Entrepot"
                                                                    data-placeholder="Séléctionner l'entrepôt'">
                                                                    @foreach ($entrepots as $entrepot)
                                                                        @if ($entrepot->id == $item->EntrepotId)
                                                                            <option value="{{ $entrepot->id }}" selected>
                                                                                {{ $entrepot->Description }}</option>
                                                                        @else
                                                                            <option value="{{ $entrepot->id }}">
                                                                                {{ $entrepot->Description }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label class="form-label">Quantité</label>
                                                            <input type="text" class="form-control" name="Quantite"
                                                                id="Libelle{{ $item->id }}"
                                                                value="{{ $item->Quantite }}" max="25"
                                                                aria-describedby="helpLibelle{{ $item->id }}"
                                                                placeholder="Saisissez le libelle de l'article">
                                                        </div>
                                                        <div class="mb-3 col-lg-6">
                                                            <label for="Libelle{{ $item->id }}" class="form-label">Modèle
                                                            </label>
                                                            <div class="chosen-select-act fm-cmp-mg">
                                                                <select class="chosen" name="Modele"
                                                                    data-placeholder="Séléctionner le modèle">
                                                                    <option value="0">
                                                                        Pas de modèle
                                                                    </option>
                                                                    @foreach ($temp as $mo)
                                                                        @if ($mo->id == $modData[$item->id])
                                                                            <option value="{{ $mo->id }}" selected>
                                                                                {{ $mo->Description }}
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $mo->id }}">
                                                                                {{ $mo->Description }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-lg-8">
                                                            <label class="form-label">Fournisseur
                                                            </label>
                                                            <div class="chosen-select-act fm-cmp-mg">
                                                                <select class="chosen" name="Fournisseur"
                                                                    data-placeholder="Séléctionner le founisseur">
                                                                    @foreach ($fournisseurs as $four)
                                                                        @if ($four->id == $item->FournisseurId)
                                                                            <option value="{{ $four->id }}" selected>
                                                                                {{ $four->Nom }}
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $four->id }}">
                                                                                {{ $four->Nom }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br><br>
                                                    <br><br>
                                                    <div class="modal-footer">
                                                        <button type="reset" class="btn btn-outline btn-primary"
                                                            data-dismiss="modal">Annuler</button>
                                                        <button type="submit"
                                                            class="btn btn-danger btn-outline">Confirmer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal animated rubberBand" id="detailsmodal{{ $item->id }}"
                                        tabindex="-1" role="dialog" aria-labelledby="supprimermodalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center" id="supprimermodalLabel">Détails sur
                                                        la commande du produit {{ $item->Article }} du fournisseur
                                                        {{ $item->Fournisseur }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                    <div class="col-lg-6">
                                                        <li> Date de la Commande :
                                                            <strong>
                                                                {{ $item->DateCommande }}
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li>
                                                            Etat :
                                                            <strong>
                                                                @if ($item->Etat == 0)
                                                                    En attente
                                                                @else
                                                                    @if ($item->Etat == 2)
                                                                        Validée
                                                                    @else
                                                                        @if ($item->Etat == 3)
                                                                            Annulée
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li> Article :
                                                            <strong>
                                                                {{ $item->Article }}
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li>
                                                            Entrepôt :
                                                            <strong>
                                                                @foreach ($entrepots as $itemEntre)
                                                                    @if ($item->EntrepotId == $itemEntre->id)
                                                                        {{ $itemEntre->Description }}
                                                                    @endif
                                                                @endforeach
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li>
                                                            Fournisseur :
                                                            <strong>
                                                                {{ $item->Fournisseur }}
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li>
                                                            Adresse de livraison :
                                                            <strong>
                                                                @foreach ($entrepots as $itemEntre)
                                                                    @if ($item->EntrepotId == $itemEntre->id)
                                                                        {{ $itemEntre->Adresse }}
                                                                    @endif
                                                                @endforeach
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li> Quantité :
                                                            <strong>
                                                                {{ $item->Quantite }}
                                                            </strong>
                                                        </li>
                                                    </div>
                                                    <div class="col-lg-6 hidden">
                                                        <input {{ $element = 'Pas de modèle' }}
                                                            @foreach ($temp as $mo) @if ($mo->id == $modData[$item->id])
                                                                        {{ $element = $mo->Description }}
                                                                    @break @endif
                                                            @endforeach>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <li>
                                                            Modèle :
                                                            <strong id="InfoModele{{ $item->id }}">
                                                                {{ $element }}
                                                            </strong>
                                                        </li>
                                                    </div>

                                                    </p>
                                                </div>
                                                <br><br>
                                                <br><br>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-outline btn-secondary"
                                                        data-dismiss="modal">Retour</a>
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
        <script src="/client/js/chosen/chosen.jquery.js"></script>

        <!-- Data Table JS
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ============================================ -->
        <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
        <script src="/client/js/data-table/data-table-act.js"></script>

        <script>
            function ModeleInfo(id) {
                if (!document.getElementById("InfoModele" + id).innerHTML.include("Pas de modèle"))
                    document.getElementById("InfoModele" + id).innerHTML = "Pas de modèle";
            }

            $('#CategorieDataTable').DataTable({
                "language": {
                    "url": "/French.json"
                },
                order: [
                    [0, 'desc']
                ],
            });
            $(".chosen").chosen({
                disable_search_threshold: 5,
                no_results_text: "Oops, aucune donnée de disponible!",
                width: "95%"
            });
            $('[rel="tooltip"]').tooltip({
                trigger: "hover"
            });
        </script>
    @endsection
