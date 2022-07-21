@extends('client.layout.app')

@section('InfoLabel')
    Page d'approvisonnement entre entrepôt
@endsection

@section('style')
    <link rel="stylesheet" href="/client/css/chosen/chosen.css">
    <link rel="stylesheet" href="/client/css/animation/animation-custom.css">
@endsection


@section('InfoDescription')
    <p>
        La liste des entrepôts disponibles s'affichera ici.
    </p>
     
@endsection

@section('content')
    <div class="normal-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="normal-table-list">
                        <div class="basic-tb-hd">
                            <h2>Basic Table</h2>
                            <div class="col-lg-3 mb-5">
                                <div class="chosen-select-act fm-cmp-mg">
                                    <select class="chosen" id="EntrepotSelected" onchange="ShowEntrepotArticleTable();"
                                        data-placeholder="Séléctionner l'entrepot">
                                        @forelse ($entrepots as $item)
                                            <option value="{{ $item->Description }}" selected>{{ $item->Description }}</option>
                                        @empty
                                            <option value="">Auncun entrepot disponible</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="bsc-tbl-st">
                                @foreach ($entrepots as $item)
                                    <table id="EntrepotApproDataTable{{ $item->id }}"
                                        class="collapse table table-striped table-inbox table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Libelle</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Date d'ajout</th>
                                                <th class="text-center">Prix</th>
                                                <th class="text-center">Seuil</th>
                                                <th class="text-center">Catégorie</th>
                                                <th class="text-center">Quantité</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">Libelle</th>
                                                <th class="text-center">Description</th>
                                                <th class="text-center">Date d'ajout</th>
                                                <th class="text-center">Prix</th>
                                                <th class="text-center">Seuil</th>
                                                <th class="text-center">Catégorie</th>
                                                <th class="text-center">Quantité</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @endforeach
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/client/js/chosen/chosen.jquery.js"></script>
    <script src="/client/js/animation/animation-active.js"></script>
    <script src="/client/js/dropzone/dropzone.js"></script>
    <script src="/client/js/bootstrap-select/bootstrap-select.js"></script>
    <script>
        tem = {!! json_encode($entrepots) !!};

        function ShowEntrepotArticleTable() {
            var selected = document.getElementById('EntrepotSelected').value;
            tem.forEach(element => {
                $('.collapse').collapse('hide');
                if (element['Description'] == selected) {
                    $('#EntrepotApproDataTable' + element['id']).collapse('show');
                }
            });

        }
    </script>
    <script>
        $(".chosen").chosen({
            disable_search_threshold: 5,
            no_results_text: "Oops, aucune donnée de disponible!",
            width: "95%"
        });
        var EntrepotsNavHeader = document.getElementById("EntrepotsNavHeader");
        var NavEntrepots = document.getElementById("NavEntrepots");
        var oldClassHeader = EntrepotsNavHeader.getAttribute("class");
        var oldClassNav = NavEntrepots.getAttribute("class");
        EntrepotsNavHeader.setAttribute("class", oldClassHeader + " active");
        NavEntrepots.setAttribute("class", oldClassNav + " active");
    </script>
@endsection
