@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
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
                            <table id="CategorieDataTable" class="table table-striped table-inbox table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Libelle</th>
                                        <th class="text-center">Decsription</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->Libelle }}</td>
                                            <td class="text-center">{{ $item->Description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center">
                                                Aucune catégorie n'est disponible
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

        var CategorieNavHeader = document.getElementById("CategorieNavHeader");
        var NavCategories = document.getElementById("NavCategories");
        var oldClassHeader = CategorieNavHeader.getAttribute("class");
        var oldClassNav = NavCategories.getAttribute("class");
        CategorieNavHeader.setAttribute("class", oldClassHeader + " active");
        NavCategories.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
