@extends('admin.layout.app')

@section('title')
    Liste des Abonnements
@endsection

@section('page')
    Abonnement
@endsection
@section('Information')
  @if (isset($Info))
  {{$Info}}      
  @endif
@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste des Abonnements</h4>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive-sm table-responsive">
                <div class="container mb-2">
                  <div class="row" >
                    <div class="text-center col-6 col-sm-3">
                      Trier
                    </div>
                    <div class="col-6 col-sm-3">
                      <select name="" id="" class="form-control">
                        <option value="Nom"  class="text-center text-truncate" style="max-width: 150px;">Nom</option>
                        <option value="Prenom"  class="text-center text-truncate" style="max-width: 150px;">Prénom</option>
                        <option value="Adresse"  class="text-center text-truncate" style="max-width: 150px;">Adresse</option>
                        <option value="Email"  class="text-center text-truncate" style="max-width: 150px;">Email</option>
                      </select>
                    </div>
                  </div>
                </div>
                <table id="order-listing" class="table table-hover">
                  <thead>
                    <tr>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Date de l'abonnement</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Formule</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Fait par</th>
                        <th colspan="2" class="text-center text-truncate" style="max-width: 150px;">Pour la boutique</th>
                        {{--<th>Status</th>--}}
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($abonnements as $key => $value)
                    <tr>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->DateAbonnement}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Tarif}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Nom}} {{$value->Prenom}}</td>
                      <td  class="text-center text-truncate" colspan="2" style="max-width: 150px;">{{$value->Boutique}}</td>
                      </tr>
                      @empty
                          <tr>
                            <td colspan="6" class="text-center text-truncate" style="max-width: 150px;">Aucun abonnement n'a été fait pour le moment</td>
                          </tr>
                      @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <form action="{{route('Admin.Abonnement.Search')}}" method="GET" class="form">
                        <td><input class="form-control" placeholder="Recherche par date" type="date" name="Date" ></td>
                        <td><input class="form-control" placeholder="Recherche par formule" type="text" name="Formule" ></td>
                        <td colspan="5" class="text-center">
                          <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i></button>
                        </td>
                      </form>
                    </tr>
                  </tfoot>
                  
                </table>
                {{ $abonnements->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
    <script>
     
    </script>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
      </div>
    </footer>
    <!-- partial -->
  </div>


@endsection
