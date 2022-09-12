@extends('admin.layout.app')

@section('title')
    Liste des boutiques
@endsection

@section('page')
    Boutiques
@endsection
@section('Information')
    Liste des boutiques
@endsection


@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Liste des boutiques</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive-sm table-responsive">
                                <div class="container mb-2">
                                    <div class="row">
                                        <div class="col">
                                            <div class="text-center col-6 col-sm-3">
                                                Trier
                                            </div>
                                            <form action="{{ route('Admin.Boutique.Trie') }}" method="get">
                                                <div class="col-6 col-sm-3">
                                                    <select name="Trie" class="form-control">
                                                        <option value="Nom" class="text-center text-truncate"
                                                            style="max-width: 150px;">Nom</option>
                                                        <option value="Adresse" class="text-center text-truncate"
                                                            style="max-width: 150px;">Adresse</option>
                                                        <option value="Email" class="text-center text-truncate"
                                                            style="max-width: 150px;">Email</option>
                                                        <option value="Site" class="text-center text-truncate"
                                                            style="max-width: 150px;">Site Web</option>
                                                        <option value="Date" class="text-center text-truncate"
                                                            style="max-width: 150px;">Date</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 col-sm-3">
                                                    <select name="Order" class="form-control">
                                                        <option value="asc" class="text-center text-truncate"
                                                            style="max-width: 150px;">Croissant</option>
                                                        <option value="desc" class="text-center text-truncate"
                                                            style="max-width: 150px;">Décroissant</option>
                                                    </select>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Trier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <table id="order-listing" class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Nom</th>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Adresse</th>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Email</th>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Site web</th>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Date d'ajout
                                            </th>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Etat</th>
                                            <th class="text-center text-truncate" style="max-width: 150px;">Nbr utilisateurs
                                            </th>
                                            {{-- <th>Status</th> --}}
                                            <th class="text-center text-truncate" style="max-width: 150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($boutiques as $key => $value)
                                            <tr>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->Nom }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->Adresse }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->Email }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->Site }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->DateAjout }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->Etat }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    {{ $value->nbr }}</td>
                                                <td class="text-center text-truncate" style="max-width: 150px;">
                                                    <a class="btn btn-outline-primary" title="Detailler {{ $value->Nom }}"
                                                        href="{{ route('Admin.Boutique.Details', ['id' => $value->id]) }}">Voir</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-truncate"
                                                    style="max-width: 150px;">Aucune donnée n'est disponible</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <form action="{{ route('Admin.Boutique.Search') }}" method="GET"
                                                class="form">
                                                <td><input class="form-control" placeholder="Recherche par nom"
                                                        type="text" name="Nom"></td>
                                                <td><input class="form-control" placeholder="Recherche par Adresse"
                                                        type="text" name="Adresse"></td>
                                                <td><input class="form-control" placeholder="Recherche par email"
                                                        type="text" name="Email"></td>
                                                <td><input class="form-control" placeholder="Recherche par Site"
                                                        type="text" name="Site"></td>
                                                <td colspan="3" class="text-center">
                                                    <button class="btn btn-primary " title="Rechercher" type="submit">
                                                        <i class="fa fa-search"></i></button>
                                                </td>
                                            </form>
                                        </tr>
                                    </tfoot>

                                </table>
                                {{ $boutiques->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css" />

        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
        <script>
            $(document).ready(function() {
                var table = $('#order-listing').DataTable({
                    'processing' = true,
                    'serverSide' = true,
                    'ajax': "{{ route('Admin.Utilisateur.List') }}",
                    'columns': [{
                            'data': 'Nom'
                        },
                        {
                            'data': 'Prenom'
                        },
                        {
                            'data': 'Email'
                        },
                        {
                            'data': 'Adresse'
                        },
                        {
                            'data': 'Contact'
                        },
                    ],
                });
                $('.filter-input').keyup(function() {
                    alert("Cool")
                });

            })
        </script>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a
                        href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                        class="ti-heart text-danger ml-1"></i></span>
            </div>
        </footer>
        <!-- partial -->
    </div>
@endsection
