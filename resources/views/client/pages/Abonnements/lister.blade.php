@extends('client.layout.app')
@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Liste des abonnements de votre boutique</h2>
                            <p>La liste des abonnements s'afficheront en dessous, vous recherchez un abonnement en particulier ou également trier la liste des abonnements obtenue.</p>
                        </div>
                        <div class="table-responsive">
                            <table id="data-table-basic" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Formule</th>
                                        <th class="text-center">Fait par</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($abonnements as $item)
                                        <tr>
                                            <td class="text-center">{{$item->DateAbonnement}}</td>
                                            <td class="text-center">{{$item->Tarif}}</td>
                                            <td class="text-center">{{$item->Nom}} {{$item->Prenom}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                Aucun abonnement n'a été faite
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Formule</th>
                                        <th class="text-center">Fait par</th>
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
    <!-- Data Table JS
      ============================================ -->
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>
@endsection
