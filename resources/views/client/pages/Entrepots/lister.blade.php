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
    <div class="notification-demo">
        <div id="NotifMessageHeader"> Entête du message </div>
        <div id="NotifMessageContent"> Le message </div>
    </div>
    <button id="TestALertBtn">
        sss
    </button>
    <a href="" class="btn btn-info" message="Test" data-type="inverse" data-from="bottom" data-align="center">Bottom
        Center</a>
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
                        <div class="table-responsive">
                            <table id="EntrepotDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Decsription</th>
                                        <th class="text-center">Addresse</th>
                                        <th class="text-center">Date d'ajout</th>
                                        <th class="text-center">Nombre d'article</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($entrepots as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Description }}</td>
                                            <td class="text-center">{{ $item->Adresse }}</td>
                                            <td class="text-center">{{ $item->DateAjout }}</td>
                                            <td class="text-center">{{ $item->id }}</td>
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
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Decsription</th>
                                        <th class="text-center">Addresse</th>
                                        <th class="text-center">Date d'ajout</th>
                                        <th class="text-center">Nombre d'article</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
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
                                <div class="modal animated rubberBand" id="detailsmodal{{ $item->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="detailsmodalLabel" aria-hidden="true">
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
                                                                                <strong>
                                                                                    {{ $item->id }}
                                                                                </strong>
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
                                                                        <p>
                                                                            Liste des articles de l'entrepot à mettre ici.
                                                                        </p>
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
                                                        <label for="Description{{ $item->Adresse }}"
                                                            class="form-label">Description</label>
                                                        <input type="text" class="form-control" name="Description"
                                                            id="Description{{ $item->Adresse }}"
                                                            aria-describedby="helpDescription{{ $item->Adresse }}"
                                                            value="{{ $item->Description }}"
                                                            placeholder="Saisissez la description de l'entrepôt">
                                                        <small id="helpDescription{{ $item->Adresse }}"
                                                            class="form-text text-muted">Description Help
                                                            text</small>
                                                        @error('Description')
                                                            <div class="alert alert-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3 col-lg-6">
                                                        <label for="Addresse{{ $item->Adresse }}"
                                                            class="form-label">Addresse</label>
                                                        <input type="text" class="form-control" name="Adresse"
                                                            id="Addresse{{ $item->Adresse }}"
                                                            value="{{ $item->Adresse }}"
                                                            aria-describedby="helpAddresse{{ $item->id }}"
                                                            placeholder="Saisissez l'addresse de l'entrepôt">
                                                        <small id="helpAddresse{{ $item->id }}"
                                                            class="form-text text-muted">Addresse Help text</small>
                                                        @error('Adresse')
                                                            <div class="alert alert-danger" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
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
                }
            });
        });
    </script>
    @if (Session::get('Success'))
        <script>
            //notify4("bottom", "center", nIcons, "inverse", nAnimIn, nAnimOut);
            $.growl("{{ Session::get('Success') }}", {
                type: 'success',
                delay: 5000,
            });
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                //notify4("bottom", "center", nIcons, "inverse", nAnimIn, nAnimOut);

                $.growl("{{ $error }}", {
                    type: 'info',
                    delay: 5000,
                });
            </script>
        @endforeach
    @endif
@endsection
