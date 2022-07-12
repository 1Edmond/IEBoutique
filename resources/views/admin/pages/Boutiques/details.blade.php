@extends('admin.layout.app')

@section('page')
    Boutiques
@endsection
@section('Information')
  Boutique {{$boutique->Nom}}
@endsection

@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4>Information sur la formule <strong>{{ $boutique->Nom }}</strong> </h4>
            </div>
            <div class="card-body">
                <div class="custom-tab">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="custom-nav-info-tab" data-toggle="tab"
                                href="#custom-nav-info" role="tab" aria-controls="custom-nav-info"
                                aria-selected="true">Information</a>
                            <a class="nav-item nav-link" id="custom-nav-utilisateur-tab" data-toggle="tab"
                                href="#custom-nav-utilisateur" role="tab" aria-controls="custom-nav-utilisateur"
                                aria-selected="false">Liste des utilisateurs de la boutique</a>
                            <a class="nav-item nav-link" id="custom-nav-abonnement-tab" data-toggle="tab"
                                href="#custom-nav-abonnement" role="tab" aria-controls="custom-nav-abonnement"
                                aria-selected="false">Liste des abonnements de la boutique</a>
                        </div>
                    </nav>
                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="custom-nav-info" role="tabpanel"
                            aria-labelledby="custom-nav-info-tab">
                            <div class="container">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header"><strong>Description des informations</strong></div>
                                        <div class="card-body card-block">
                                            <div class="form-group"><label for="Nom"
                                                    class=" form-control-label">Nom</label> <input type="text"
                                                    disabled id="Nom" value="{{ $boutique->Nom }}"
                                                    class="form-control bg-light text-dark"></div>
                                            <div class="form-group"><label for="Site"
                                                    class=" form-control-label">Site Web</label><input type="text"
                                                    id="Site" value="{{ $boutique->Site }}" disabled
                                                    class="form-control bg-light text-dark"></div>
                                            <div class="form-group"><label for="Adresse"
                                                    class=" form-control-label">Prix</label><input type="text"
                                                    id="Adresse" disabled value="{{ $boutique->Adresse }}"
                                                    class="form-control bg-light text-dark"></div>
                                            <div class="row form-group">
                                                <div class="col-8">
                                                    <div class="form-group"><label for="Date"
                                                            class=" form-control-label">Date d'ajout de la boutique</label><input type="text"
                                                            id="Date" disabled value="{{$boutique->DateAjout}}"
                                                            class="form-control bg-light text-dark"></div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group"><label for="Email"
                                                            class=" form-control-label">Email</label><input
                                                            type="text" id="Email" disabled value="{{$boutique->Email}}"
                                                            class="form-control bg-light text-dark"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-nav-utilisateur" role="tabpanel"
                        aria-labelledby="custom-nav-utilisateur-tab">
                        <div class="container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Nom</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Prénom</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Contact</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Date d'ajout</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Adresse</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Email</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Pseudo</th>
                                        <th class="text-center text-truncate" style="max-width: 150px;">Rôle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                    <tr>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Nom}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Prenom}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Contact}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->DateAjout}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Adresse}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Email}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Pseudo}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Role}}</td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-nav-abonnement" role="tabpanel"
                    aria-labelledby="custom-nav-utilisateur-tab">
                    <div class="container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center text-truncate" style="max-width: 150px;">Formule d'abonnement</th>
                                    <th class="text-center text-truncate" style="max-width: 150px;">Date abonnement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($abonnements as $item)
                                    <tr>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->Libelle}}</td>
                                        <td  class="text-center text-truncate" style="max-width: 150px;">{{$item->DateAbonnement}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-truncate" style="max-width: 150px;">
                                           La boutique n'a fait aucun abonnement pour le moment
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $abonnements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection


