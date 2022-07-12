@extends('admin.layout.app')

@section('title')
    Liste des avantages
@endsection

@section('page')
    Historique
@endsection
@section('Information')
  Liste des historiques d'activités
@endsection


@section('styles')
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('content')
 
<div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Liste des Historique</h4>
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
                <table id="historiquesTable" class="table">
                  <thead>
                    <tr>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Libelle</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Description</th>
                        <th  class="text-center text-truncate" style="max-width: 150px;">Date</th>
                        {{--<th>Status</th>--}}
                        <th colspan="2"  class="text-center text-truncate" style="max-width: 150px;">Actions</th>
                        <th ></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($historiques as $key => $value)
                    <tr>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Libelle}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->Description}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">{{$value->DateOperation}}</td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">
                        <a class="btn btn-outline-danger" href=""  data-toggle="modal" data-target="#supprimermodal{{$value->id}}" >Supprimer</a>
                      </td>
                      <td  class="text-center text-truncate" style="max-width: 150px;">
                        <a class="btn btn-outline-primary" href=""  data-toggle="modal" data-target="#detailmodal{{$value->id}}" >Détails</a>
                      </td>
                      </tr>
                      <tr>
                        <div class="modal fade" id="detailmodal{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="detailmodalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-sm-2" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailmodalLabel">Détails sur l'historique</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                  <p>
                                   Libelle : {{$value->Libelle}}
                                  </p>
                                  <p> 
                                    Description : {{$value->Description}}
                                   </p>
                                  <p>
                                     Date : {{$value->DateOperation}} 
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Retour</button>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="modal fade" id="supprimermodal{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="supprimermodalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm-2" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="supprimermodalLabel">Confirmez la suppression</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                    Voulez-vous vraiment supprimer {{$value->Description}} ?
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                  <a type="button" href="{{route('Admin.Historique.Delete',['id'=> $value->id])}}" class="btn btn-danger">Confirmer</a>
                              </div>
                          </div>
                      </div>
                    </div>    
                    </tr>
                      @empty
                          <tr>
                            <td colspan="6"  class="text-center text-truncate" style="max-width: 150px;">Aucune donnée n'est disponible</td>
                          </tr>
                     
                      @endforelse
                  </tbody>
                  <tfoot>
                    <tr>
                      <form action="{{route('Admin.Historique.Search')}}" method="GET" class="form">
                        <td><input class="form-control" placeholder="Recherche par Libelle" type="text" name="Libelle" ></td>
                        <td><input class="form-control" placeholder="Recherche par Description" type="text" name="Description" ></td>
                        <td colspan="2" class="text-center">
                          <button class="btn btn-primary ml-5" type="submit"> <i class="fa fa-search"></i></button>
                        </td>
                      </form>
                    </tr>
                  </tfoot>
                </table>

              {{ $historiques->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
  
 