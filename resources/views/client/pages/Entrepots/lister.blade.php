@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
@endsection

@section('InfoLabel')
    Page des entrepôts disponibles
@endsection



@section('InfoDescription')
    <p>
        La liste des entrepôts disponibles s'affichera ici.
        @if ($user->Role == 'Gérant')
            <p>
                Si aucune entrepôts ne correspond à votre attente, vous pouvez en ajouter.
            </p>
        @else
            <p>
                Si aucune entrepôts ne correspond à votre attente, référencez-vous à votre gérant pour la création de la
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
                            <h2>Liste des entrepôts disponibles. </h2>
                            <p>La liste des entrepôts s'afficheront en dessous, vous pouvez recherchez une entrepôts en
                                particulier ou également trier la liste des entrepôts obtenues.</p>
                        </div>
                        <div class="table-responsive bsc-tbl-cds">
                            <table id="EntrepotDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Decsription</th>
                                        <th class="text-center">Addresse</th>
                                        <th class="text-center">Date d'ajout</th>
                                        <th class="text-center">Nombre d'articles</th>
                                        <th class="text-center">Quantité total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($entrepots as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Description }}</td>
                                            <td class="text-center">{{ $item->Adresse }}</td>
                                            <td class="text-center">{{ $item->DateAjout }}</td>
                                            <td class="text-center">
                                                @if (array_key_exists($item->id, $Total))
                                                    {{ $Total[$item->id] }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (array_key_exists($item->id, $Quantite))
                                                    {{ $Quantite[$item->id] }}
                                                @else
                                                    0
                                                @endif
                                            </td>
                                            <td class="text-center button-icon-btn button-icon-btn-cl sm-res-mg-t-30">
                                                <button class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#supprimermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="left"
                                                    title="Supprimer {{ $item->Description }}"><i
                                                        class="notika-icon notika-close"></i></button>
                                                <button class="btn btn-cyan cyan-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#modifiermodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="bottom"
                                                    title="Modifier {{ $item->Description }}"><i
                                                        class="notika-icon notika-menus"></i></button>
                                                <button
                                                    class="btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#detailsmodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="top"
                                                    title="Détails sur {{ $item->Description }}"><i
                                                        class="notika-icon notika-right-arrow"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center">
                                                Aucun entrepôt de disponlibel disponible
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                               
                            </table>
                            @foreach ($entrepots as $item)
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
                                                <a type="button"
                                                    href="{{ route('User.Entrepot.Delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-outline">Confirmer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal modal animated rubberBand" id="detailsmodal{{ $item->id }}"
                                    tabindex="-1" role="dialog" aria-labelledby="detailsmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="detailsmodalLabel"> Détails sur
                                                    {{ $item->Description }} </h5>
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
                                                            <div class="panel panel-collapse notika-accrodion-cus">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-one{{ $item->id }}"
                                                                            aria-expanded="true">
                                                                            Informations élémentaires sur
                                                                            {{ $item->Description }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-one{{ $item->id }}"
                                                                    class="collapse animated flipInX in" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <li>
                                                                                Date d'ajout de l'entrepôt :
                                                                                <strong>
                                                                                    {{ $item->DateAjout }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Addresse de l'entrepôt :
                                                                                <strong>
                                                                                    {{ $item->Adresse }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Nombre total d'articles :
                                                                                @if (array_key_exists($item->id, $Total))
                                                                                    {{ $Total[$item->id] }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </li>
                                                                            <li>
                                                                                Quantité total des articles :
                                                                                @if (array_key_exists($item->id, $Quantite))
                                                                                    {{ $Quantite[$item->id] }}
                                                                                @else
                                                                                    0
                                                                                @endif
                                                                            </li>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-collapse notika-accrodion-cus">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a class="collapsed" data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-two{{ $item->id }}"
                                                                            aria-expanded="false">
                                                                            Liste des articles de l'entrepôt
                                                                            {{ $item->Description }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-two{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <table
                                                                            class="table table-responsive table-hover table-striped"
                                                                            id="EntrepotArticleTable{{ $item->id }}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Libelle</th>
                                                                                    <th class="text-center">Description
                                                                                    </th>
                                                                                    <th class="text-center">Prix</th>
                                                                                    <th class="text-center">Seuil</th>
                                                                                    <th class="text-center">Quantité</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @forelse ($entrepotArticle as $dt)
                                                                                    @if ($dt->entrepot == $item->id)
                                                                                        <tr>
                                                                                            <td>{{ $dt->Libelle }}</td>
                                                                                            <td>{{ $dt->Description }}
                                                                                            </td>
                                                                                            <td>{{ $dt->Prix }}</td>
                                                                                            <td>{{ $dt->Seuil }}</td>
                                                                                            <td>{{ $dt->Quantite }}</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @empty
                                                                                @endforelse
                                                                            </tbody>
                                                                           
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-collapse notika-accrodion-cus">
                                                                <div class="panel-heading" role="tab">
                                                                    <h4 class="panel-title">
                                                                        <a class="collapsed" data-toggle="collapse"
                                                                            data-parent="#accordionBlue{{ $item->id }}"
                                                                            href="#accordionBlue-three{{ $item->id }}"
                                                                            aria-expanded="false">
                                                                            Liste des articles en dessous du seuil de
                                                                            l'entrepôt
                                                                            {{ $item->Description }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-three{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <table
                                                                            class="table table-responsive table-hover table-striped"
                                                                            id="EntrepotArticleTableSeuil{{ $item->id }}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Libelle</th>
                                                                                    <th class="text-center">Description
                                                                                    </th>
                                                                                    <th class="text-center">Prix</th>
                                                                                    <th class="text-center">Seuil</th>
                                                                                    <th class="text-center">Quantité</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @forelse ($entrepotArticleSeuil as $dt)
                                                                                    @if ($dt->entrepot == $item->id)
                                                                                        <tr>
                                                                                            <td>{{ $dt->Libelle }}</td>
                                                                                            <td>{{ $dt->Description }}
                                                                                            </td>
                                                                                            <td>{{ $dt->Prix }}</td>
                                                                                            <td>{{ $dt->Seuil }}</td>
                                                                                            <td>{{ $dt->Quantite }}</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @empty
                                                                                    <td colspan="5"
                                                                                        class="text-center">Aucun article
                                                                                        en dessous du seuil dans l'entrepot
                                                                                        {{ $item->Description }}</td>
                                                                                @endforelse
                                                                            </tbody>
                                                                          
                                                                        </table>
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
                                <div class="modal fade" id="modifiermodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="modifiermodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="modifiermodalLabel">Modification
                                                    de
                                                    {{ $item->Description }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('User.Entrepot.Update', ['id' => $item->id]) }}"
                                                method="post">
                                                <div class="modal-body">
                                                    <p>
                                                        @csrf
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Description{{ $item->id }}"
                                                            class="form-label">Description</label>
                                                        <input type="text" class="form-control" name="Description"
                                                            id="Description{{ $item->id }}"
                                                            aria-describedby="helpDescription{{ $item->id }}"
                                                            value="{{ $item->Description }}"
                                                            placeholder="Saisissez la description de l'entrepôt">
                                                        <small id="helpDescription{{ $item->id }}"
                                                            class="form-text text-muted">Description Help
                                                            text</small>
                                                    </div>
                                                    <div class="mb-3 col-lg-6" hidden>
                                                        <input type="hidden" class="form-control" name="Id"
                                                            id="Id{{ $item->id }}"
                                                            aria-describedby="helpId{{ $item->Id }}"
                                                            value="{{ $item->id }}">
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Addresse{{ $item->id }}"
                                                            class="form-label">Addresse</label>
                                                        <input type="text" class="form-control" name="Adresse"
                                                            id="Addresse{{ $item->id }}"
                                                            value="{{ $item->Adresse }}" max="150"
                                                            aria-describedby="helpAddresse{{ $item->id }}"
                                                            placeholder="Saisissez l'addresse de l'entrepôt">
                                                        <small id="helpAddresse{{ $item->id }}"
                                                            class="form-text text-muted">Addresse Help text</small>
                                                    </div>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-dismiss="modal">Annuler</button>
                                                    <button type="submit"
                                                        class="btn btn-outline btn-primary">Confirmer</button>
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
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>
    <script src="/client/js/animation/animation-active.js"></script>
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>

    <script>
        $(document).ready(function() {
            $('[rel="tooltip"]').tooltip({
                trigger: "hover"
            });
            $('#EntrepotDataTable').DataTable({
                "language": {
                    "url": "/French.json"
                },
                order: [
                    [2, 'desc']
                ],
            });
        });
        var EntrepotsNavHeader = document.getElementById("EntrepotsNavHeader");
        var NavEntrepots = document.getElementById("NavEntrepots");
        var oldClassHeader = EntrepotsNavHeader.getAttribute("class");
        var oldClassNav = NavEntrepots.getAttribute("class");
        EntrepotsNavHeader.setAttribute("class", oldClassHeader + " active");
        NavEntrepots.setAttribute("class", oldClassNav + " active");
    </script>
    @foreach ($entrepots as $item)
        <script>
            $('#EntrepotArticleTable{{ $item->id }}').DataTable({
                scrollY: '100px',
                select: true,
                stateSave: true,
                scrollCollapse: true,
                paging: true,
                "language": {
                    "url": "/French.json"
                }
            });
            $('#EntrepotArticleTableSeuil{{ $item->id }}').DataTable({
                scrollY: '100px',
                select: true,
                stateSave: true,
                scrollCollapse: true,
                paging: true,
                "language": {
                    "url": "/French.json"
                }
            });
        </script>
    @endforeach
@endsection
