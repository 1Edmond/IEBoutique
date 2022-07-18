@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/client/css/wave/waves.min.css">
    <link rel="stylesheet" href="/client/css/wave/button.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
@endsection

@section('InfoLabel')
    Page des articles disponibles
@endsection



@section('InfoDescription')
    <p>
        La liste des articles disponibles s'affichera ici.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste des articles disponibles. </h2>
                            <p>La liste des articles s'afficheront en dessous, vous pouvez recherchez une articles en
                                particulier ou également trier la liste des articles obtenues.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="EntrepotDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Libelle</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Date d'ajout</th>
                                        <th class="text-center">Prix</th>
                                        <th class="text-center">Seuil</th>
                                        <th class="text-center">Catégorie</th>
                                        <th class="text-center">Entrepôt</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articles as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Libelle }}</td>
                                            <td class="text-center">{{ $item->Description }}</td>
                                            <td class="text-center">{{ $item->DateAjout }}</td>
                                            <td class="text-center">{{ $item->Prix }} fcfa</td>
                                            <td class="text-center">{{ $item->Seuil }}</td>
                                            <td class="text-center">{{ $item->Categorie }}</td>
                                            <td class="text-center">

                                                <input type="hidden" value="{{ $element = '' }}">
                                                @foreach ($entrepots as $en)
                                                    @if ($en->ArticleId == $item->id)
                                                        @if ($element == '')
                                                            <input type="hidden"
                                                                value="{{ $element .= $en->Description }}">
                                                        @else
                                                            <input type="hidden"
                                                                value="{{ $element .= ', ' . $en->Description }}">
                                                        @endif
                                                    @endif
                                                @endforeach
                                                {{ $element }}

                                            </td>
                                            <td class="text-center button-icon-btn button-icon-btn-cl sm-res-mg-t-30">
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
                                                <button
                                                    class="btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg"
                                                    data-toggle="modal" data-target="#detailsmodal{{ $item->id }}"
                                                    rel="tooltip" data-placement="top"
                                                    title="Détails sur {{ $item->Libelle }}"><i
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
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Libelle</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Date d'ajout</th>
                                        <th class="text-center">Prix</th>
                                        <th class="text-center">Seuil</th>
                                        <th class="text-center">Catégorie</th>
                                        <th class="text-center">Entrepôt</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            @foreach ($articles as $item)
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
                                                        {{ $item->Libelle }}
                                                    </a>
                                                    ?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <a type="button" class="btn btn-outline btn-primary"
                                                    data-dismiss="modal">Annuler</a>
                                                <a type="button"
                                                    href="{{ route('User.Article.Delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-outline">Confirmer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal animated rubberBand" id="detailsmodal{{ $item->id }}"
                                    tabindex="-1" role="dialog" aria-labelledby="detailsmodalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-sm-2" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center" id="detailsmodalLabel"> Détails sur
                                                    {{ $item->Libelle }} </h5>
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
                                                                            Informations élémentaires sur
                                                                            {{ $item->Libelle }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-one{{ $item->id }}"
                                                                    class="collapse animated flipInX in" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <li>
                                                                                Description de l'article :
                                                                                <strong>
                                                                                    {{ $item->Description }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Date d'ajout de l'article :
                                                                                <strong>
                                                                                    {{ $item->DateAjout }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Nom de ou des entrepôts où se trouve de
                                                                                l'article :
                                                                                <input type="hidden"
                                                                                    value="{{ $element1 = '' }}">
                                                                                @foreach ($entrepots as $en)
                                                                                    @if ($en->ArticleId == $item->id)
                                                                                        @if ($element1 == '')
                                                                                            <input type="hidden"
                                                                                                value="{{ $element1 .= $en->Description }}">
                                                                                        @else
                                                                                            <input type="hidden"
                                                                                                value="{{ $element1 .= ', ' . $en->Description }}">
                                                                                        @endif
                                                                                    @endif
                                                                                @endforeach
                                                                                <strong class="">
                                                                                    {{ $element1 }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Catégorie de l'article :
                                                                                <strong>
                                                                                    {{ $item->Categorie }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Seuil de l'article :
                                                                                <strong>
                                                                                    {{ $item->Seuil }}
                                                                                </strong>
                                                                            </li>
                                                                            <li>
                                                                                Prix de l'article :
                                                                                <strong>
                                                                                    {{ $item->Prix }}
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
                                                                            Informations sur l'entrepôt ou les entrepôts de
                                                                            {{ $item->Libelle }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-two{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        <table
                                                                            class="table table-responsive table-hover table-striped"
                                                                            id="ArticleEntrepotTable{{ $item->id }}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">Description
                                                                                    </th>
                                                                                    <th class="text-center">Addresse</td>
                                                                                    <th class="text-center">Date d'ajout
                                                                                    </th>
                                                                                    <th class="text-center">Nombre
                                                                                        d'article</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($entrepots as $entrepot)
                                                                                    @if ($entrepot->ArticleId == $item->id)
                                                                                        <tr>
                                                                                            <td class="text-center">
                                                                                                {{ $entrepot->Description }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $entrepot->Adresse }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $entrepot->DateAjout }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $entrepot->id }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th class="text-center">Description
                                                                                    </th>
                                                                                    <th class="text-center">Addresse</td>
                                                                                    <th class="text-center">Date d'ajout
                                                                                    </th>
                                                                                    <th class="text-center">Nombre
                                                                                        d'article</th>
                                                                                </tr>
                                                                            </tfoot>
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
                                                                            Informations sur la catégorie de
                                                                            {{ $item->Libelle }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="accordionBlue-Trie{{ $item->id }}"
                                                                    class="collapse animated zoomInLeft" role="tabpanel">
                                                                    <div class="panel-body">
                                                                        @foreach ($categories as $cat)
                                                                            @if ($cat->id == $item->CategorieId)
                                                                                <p>
                                                                                    <li>
                                                                                        Libelle de la catégorie :
                                                                                        <strong>
                                                                                            {{ $cat->Libelle }}
                                                                                        </strong>
                                                                                    </li>
                                                                                    <li>
                                                                                        Description de la catégorie :
                                                                                        <strong>
                                                                                            {{ $cat->Description }}
                                                                                        </strong>
                                                                                    </li>
                                                                                    <li>
                                                                                        Date d'ajout de la catégorie :
                                                                                        <strong>
                                                                                            {{ $cat->DateAjout }}
                                                                                        </strong>
                                                                                    </li>
                                                                                </p>
                                                                            @endif
                                                                        @endforeach
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
                                                    {{ $item->Libelle }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('User.Article.Update', ['id' => $item->id]) }}"
                                                method="post">
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="mb-3 col-lg-6" hidden>
                                                        <input type="hidden" class="form-control" name="Id"
                                                            id="Id{{ $item->id }}"
                                                            aria-describedby="helpId{{ $item->Id }}"
                                                            value="{{ $item->id }}">
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Libelle{{ $item->id }}"
                                                            class="form-label">Libelle</label>
                                                        <input type="text" class="form-control" name="Libelle"
                                                            id="Libelle{{ $item->id }}"
                                                            value="{{ $item->Libelle }}" max="150"
                                                            aria-describedby="helpLibelle{{ $item->id }}"
                                                            placeholder="Saisissez le libelle de l'article">
                                                        <small id="helpLibelle{{ $item->id }}"
                                                            class="form-text text-muted">Libelle Help text</small>
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Description{{ $item->id }}"
                                                            class="form-label">Description</label>
                                                        <input type="text" class="form-control" name="Description"
                                                            id="Description{{ $item->id }}"
                                                            aria-describedby="helpDescription{{ $item->id }}"
                                                            value="{{ $item->Description }}"
                                                            placeholder="Saisissez la description de l'article">
                                                        <small id="helpDescription{{ $item->id }}"
                                                            class="form-text text-muted">Description Help
                                                            text</small>
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Prix{{ $item->id }}"
                                                            class="form-label">Prix</label>
                                                        <input type="text" class="form-control" name="Prix"
                                                            id="Prix{{ $item->id }}"
                                                            aria-describedby="helpPrix{{ $item->id }}"
                                                            value="{{ $item->Prix }}"
                                                            placeholder="Saisissez le prix de l'article">
                                                        <small id="helpPrix{{ $item->id }}"
                                                            class="form-text text-muted">Prix Help
                                                            text</small>
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Seuil{{ $item->id }}"
                                                            class="form-label">Seuil</label>
                                                        <input type="text" class="form-control" name="Seuil"
                                                            id="Seuil{{ $item->id }}"
                                                            aria-describedby="helpSeuil{{ $item->id }}"
                                                            value="{{ $item->Seuil }}"
                                                            placeholder="Saisissez le seuil de l'article">
                                                        <small id="helpSeuil{{ $item->id }}"
                                                            class="form-text text-muted">Seuil Help
                                                            text</small>
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Categorie{{ $item->id }}"
                                                            class="form-label">Catégorie</label>
                                                        <div class="chosen-select-act fm-cmp-mg">
                                                            <select class="chosen" name="Categorie"
                                                                data-placeholder="Séléctionner la catégorie">
                                                                @foreach ($categories as $cate)
                                                                    @if ($cate->id == $item->CategorieId)
                                                                        <option value="{{ $cate->Libelle }}" selected>
                                                                            {{ $cate->Libelle }}</option>
                                                                    @else
                                                                        <option value="{{ $cate->Libelle }}">
                                                                            {{ $cate->Libelle }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <small id="helpCategorie{{ $item->id }}"
                                                            class="form-text text-muted">Catégorie Help
                                                            text</small>
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label class="form-label">Entrepôt</label>
                                                        <div class="chosen-select-act fm-cmp-mg">
                                                            <select class="chosen" multiple name="Entrepot[]"
                                                                data-placeholder="Séléctionner l'entrepôt...">
                                                                @foreach ($data as $da => $d)
                                                                    @if ($da == $item->id)
                                                                        @foreach ($AllEntrepots as $ent)
                                                                            @if (in_array($ent->id, $d))
                                                                                <option value="{{ $ent->Description }}"
                                                                                    selected>{{ $ent->Description }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $ent->Description }}">
                                                                                    {{ $ent->Description }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <small id="helpEntrepot{{ $item->id }}"
                                                            class="form-text text-muted">Catégorie Help
                                                            text</small>
                                                    </div>

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

    <script src="/client/js/chosen/chosen.jquery.js"></script>
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
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
                }
            });

        });
    </script>
    @if (Session::get('Success'))
        @if (count(Session::get('Success')) > 0)
            @foreach (Session::get('Success') as $item => $value)
                <script>
                    $.growl('{{ $value }}', {
                        type: 'success',
                        delay: 2000 + {{ $item }},
                    });
                </script>
            @endforeach
        @else
            <script>
                $.growl("{{ Session::get('Success') }}", {
                    type: 'success',
                    delay: 2000,
                });
            </script>
        @endif
    @endif
    <script>
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });
    </script>
    @foreach ($articles as $item)
        <script>
            $('#ArticleEntrepotTable{{ $item->id }}').DataTable({
                scrollY: '60px',
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
    @if (Session::get('fail'))
        <script>
            $.growl("{{ Session::get('fail') }}", {
                type: 'danger',
                delay: 7000,
            });
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $.growl("{{ $error }}", {
                    type: 'info',
                    delay: 5000,
                });
            </script>
        @endforeach
    @endif
@endsection
