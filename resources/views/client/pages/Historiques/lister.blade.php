@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
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
                            <p>La liste des historiques d'activités s'afficheront en dessous, vous pouvez recherchez une
                                catégorie en
                                particulier ou également trier la liste des historiques obtenues.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="CategorieDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Libelle</th>
                                        <th class="text-center">Decsription</th>
                                        <th class="text-center">Date de l'opération</th>
                                        <th class="text-center">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($historiques as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Libelle }}</td>
                                            <td class="text-center">{{ $item->Description }}</td>
                                            <td class="text-center">{{ $item->DateOperation }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center">
                                                Aucun historique pour le moment
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Libelle</th>
                                        <th class="text-center">Description</th>
                                    </tr>
                                </tfoot>
                            </table>
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
            }
        });
    </script>
@endsection
