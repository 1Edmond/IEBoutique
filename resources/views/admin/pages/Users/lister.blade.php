@extends('admin.layout.app')

@section('title')
    Liste des utilisateurs
@endsection

@section('page')
    Utilisateurs
@endsection
@section('Information')
  Liste des utilisateurs
@endsection


@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste des utilisateurs</h4>
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
                        <option value="Pseudo"  class="text-center text-truncate" style="max-width: 150px;">Pseudo</option>
                        <option value="Boutique"  class="text-center text-truncate" style="max-width: 150px;">Boutique</option>
                      </select>
                    </div>
                  </div>
                </div>
                <table id="order-listing" class="table table-hover">
                  <thead>
                    <tr>  
                        <th  class="text-center text-truncate" style="max-width: 150px;">Nom</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Prénom</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Email</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Pseudo</th>
                        <th colspan="2" class="text-center text-truncate" style="max-width: 150px;">Boutique</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($users as $key => $value)
                    <tr>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Nom}} </td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Prenom}} </td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Email}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Pseudo}}</td>
                      <td colspan="2" class="text-center text-truncate" style="max-width: 150px;">{{$value->boutique}}</td>
                      </tr>
                      @empty
                          <tr>
                            <td colspan="6"  class="text-center text-truncate" style="max-width: 150px;">Aucun utilisateur disponible</td>
                          </tr>
                     
                      @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <form action="{{route('Admin.Utilisateur.Search')}}" method="GET" class="form">
                        <td><input class="form-control" title="Recherche par nom" placeholder="Recherche par nom" type="text" name="Nom" ></td>
                        <td><input class="form-control" title="Recherche par prénom" placeholder="Recherche par prénom" type="text" name="Prenom" ></td>
                        <td><input class="form-control" placeholder="Recherche par email" type="text" name="Email" ></td>
                        <td><input class="form-control" placeholder="Recherche par pseudo" type="text" name="Pseudo" ></td>
                        <td><input class="form-control" placeholder="Recherche par boutique" type="text" name="Boutique" ></td>
                        <td colspan="2" class="text-center">
                          <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i></button>
                        </td>
                      </form>
                    </tr>
                  </tfoot>
                  
                </table>
                {{ $users->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.12.1/datatables.min.js"></script>
    <script>
      $(document).ready(function(){
        var table = $('#order-listing').DataTable({
          'processing' = true,
          'serverSide' = true,
          'ajax': "{{route('Admin.Utilisateur.List')}}",
          'columns' : [
            {'data' : 'Nom'},
            {'data' : 'Prenom'},
            {'data' : 'Email'},
            {'data' : 'Adresse'},
            {'data' : 'Contact'},
          ],
        });
        $('.filter-input').keyup(function(){
          alert("Cool")
        });

      })


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
