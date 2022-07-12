@extends('admin.layout.app')

@section('title')
    Liste des avantages
@endsection

@section('page')
    Avantages
@endsection
@section('Information')
  Liste des avantages
@endsection


@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste des avantages</h4>
          <div class="row">
            @if (Session::has('success'))
            <div class="col-12">
              <div class="alert alert-success">
                    {{Session::get('success')}}
                  </div>
                </div>
            @endif
            <div class="col-12">
              <div class="table-responsive-sm table-responsive">
                <table id="order-listing" class="table table-hover">
                  <thead>
                    <tr>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Description</th>
                        {{--<th>Status</th>--}}
                        <th colspan="3"  class="text-center text-truncate" style="max-width: 150px;">Actions</th>
                        <th ></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($avantages as $key => $value)
                    <tr>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Description}}</td>
                      
                      @if($value->Etat != 0)
                      <td  class="text-center text-truncate" colspan="3" style="max-width: 150px;">
                        <a class="btn btn-outline-success"  data-toggle="modal" data-target="#restaurermodal{{$value->id}}"  href="">Restaurer</a>
                      </td>
                      @else
                      <td  class="text-center text-truncate" style="max-width: 150px;">
                        <a class="btn btn-outline-primary" href="{{route('Admin.Avantage.UpdatePage',['id' => $value->id])}}">Modifier</a>
                      </td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">
                        <a class="btn btn-outline-danger"  data-toggle="modal" data-target="#supprimermodal{{$value->id}}"  href="">Supprimer</a>
                      </td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">
                        <a class="btn btn-outline-primary"  data-toggle="modal" data-target="#masquermodal{{$value->id}}" href="">Masquer</a>
                      </td>
                      @endif
                      </tr>
                      @empty
                          <tr>
                            <td colspan="6"  class="text-center text-truncate" style="max-width: 150px;">Aucune donnée n'est disponible</td>
                          </tr>
                     
                      @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <form action="{{route('Admin.Avantage.Search')}}" method="GET" class="form">
                        <td><input class="form-control" placeholder="Recherche par Description" type="text" name="Description" ></td>
                        <td colspan="3" class="text-center">
                          <button class="btn btn-primary" type="submit">Rechercher</button>
                        </td>
                      </form>
                    </tr>
                  </tfoot>
                </table>
                {{ $avantages->links() }}
                @foreach ($avantages as $item)
                <div class="modal fade" id="masquermodal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="masquermodalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm-2" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="masquermodalLabel">Confirmez votre action</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <p>
                                Voulez-vous vraiment masquer {{$item->Description}}?
                              </p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                              <a type="button"  href="{{route('Admin.Avantage.Masquer',['id'=> $item->id])}}" class="btn btn-primary">Confirmer</a>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="modal fade" id="supprimermodal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm-2" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="supprimermodalLabel">Confirmez la suppression</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              <p>
                                Voulez-vous vraiment supprimer {{$item->Description}}?
                              </p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                              <a type="button"  href="{{route('Admin.Avantage.Delete',['id'=> $item->id])}}" class="btn btn-danger">Confirmer</a>
                          </div>
                      </div>
                  </div>
                </div>
                @if ($item->Etat != 0)
                <div class="modal fade" id="restaurermodal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="restaurermodalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-sm-2" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="restaurermodalLabel">Confirmez la restauration</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                                @if ($item->Etat == 1)
                                <p>
                                 {{$item->Description}} a été suprimé.
                                </p>
                                 @else
                                    @if ($item->Etat == 2)
                                     <p>
                                     {{$item->Description}} a été masqué
                                    </p>
                                     @endif
                                @endif
                                Voulez-vous vraiment la restaurer ?
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                              <a type="button" href="{{route('Admin.Avantage.Restore',['id'=> $item->id])}}" class="btn btn-success">Confirmer</a>
                          </div>
                      </div>
                  </div>
                </div>              
                @endif
                @endforeach
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
