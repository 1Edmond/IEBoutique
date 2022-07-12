@extends('admin.layout.app')

@section('title')
    Liste des formules d'abonnement
@endsection

@section('page')
    Formules
@endsection
@section('Information')
  Liste des Formules
@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
      @endif
        <div class="card-body">
          <h4 class="card-title">Liste des formules d'abonnement</h4>
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
                        <option value="Libelle"  class="text-center text-truncate" style="max-width: 150px;">Libelle</option>
                        <option value="Description"  class="text-center text-truncate" style="max-width: 150px;">Description</option>
                        <option value="Duree"  class="text-center text-truncate" style="max-width: 150px;">Durée</option>
                        <option value="Prix"  class="text-center text-truncate" style="max-width: 150px;">Prix</option>
                      </select>
                    </div>
                  </div>
                </div>
                <table id="order-listing" class="table table-hover">
                  <thead>
                    <tr>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Libelle</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Description</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Durée</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Prix</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Nombre d'avantages</th>
                        {{--<th>Status</th>--}}
                        <th  class="text-center text-truncate" style="max-width: 150px;">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($formules as $key => $value)
                    <tr>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Libelle}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Description}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->DureeTarif}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Prix}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->nbr}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">
                        <a class="btn   btn-outline-primary" title="Detailler la formule {{$value->Libelle}}" href="{{route('Admin.Formule.Details',['id' => $value->id])}}">Voir</a>
                      </td>
                      </tr>
                      @empty
                          <tr>
                            <td colspan="6"  class="text-center text-truncate" style="max-width: 150px;">Aucune donnée n'est disponible</td>
                          </tr>
                      @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <form action="{{route('Admin.Formule.Search')}}" method="GET" class="form">
                        <td><input class="form-control" placeholder="Recherche par libelle" type="text" name="Libelle" ></td>
                        <td><input class="form-control" placeholder="Recherche par Description" type="text" name="Description" "></td>
                        <td colspan="3" class="text-center">
                          <button class="btn btn-primary text-center" title="Rechercher" type="submit"> <i class="fa fa-search"></i></button>
                        </td>
                      </form>
                    </tr>
                  </tfoot>
                  
                </table>
                {{ $formules->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
 
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
