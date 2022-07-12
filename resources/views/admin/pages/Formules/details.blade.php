@extends('admin.layout.app')

@section('page')
    Formules
@endsection
@section('Information')
  Formule {{$data->Libelle}}
@endsection


@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4>Information sur la formule <strong>{{ $data->Libelle }}</strong> </h4>
            </div>
            <div class="card-body">
                <div class="custom-tab">

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="custom-nav-info-tab" data-toggle="tab"
                                href="#custom-nav-info" role="tab" aria-controls="custom-nav-info"
                                aria-selected="true">Information</a>
                            <a class="nav-item nav-link" id="custom-nav-avantage-tab" data-toggle="tab"
                                href="#custom-nav-avantage" role="tab" aria-controls="custom-nav-avantage"
                                aria-selected="false">Les avantages de la formule</a>
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
                                            <div class="form-group"><label for="Libelle"
                                                    class=" form-control-label">Libelle</label> <input type="text"
                                                    disabled id="Libelle" value="{{ $data->Libelle }}"
                                                    class="form-control bg-light text-dark"></div>
                                            <div class="form-group"><label for="Description"
                                                    class=" form-control-label">Description</label><input type="text"
                                                    id="Description" value="{{ $data->Description }}" disabled
                                                    class="form-control bg-light text-dark"></div>
                                            <div class="form-group"><label for="Prix"
                                                    class=" form-control-label">Prix</label><input type="text"
                                                    id="Prix" disabled value="{{ $data->Prix }}"
                                                    class="form-control bg-light text-dark"></div>
                                            <div class="row form-group">
                                                <div class="col-8">
                                                    <div class="form-group"><label for="Duree"
                                                            class=" form-control-label">Durée de la formule</label><input type="text"
                                                            id="Duree" disabled value="{{$data->DureeTarif}}"
                                                            class="form-control bg-light text-dark"></div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group"><label for="Date"
                                                            class=" form-control-label">Date de l'ajout</label><input
                                                            type="text" id="Date" disabled value="{{$data->DateAjout}}"
                                                            class="form-control bg-light text-dark"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-nav-avantage" role="tabpanel"
                            aria-labelledby="custom-nav-avantage-tab">
                            <div class="container">
                                <ul>
                                  @foreach ($avantages as $item => $value)
                                      <li>
                                        {{$value->Description}}
                                      </li>
                                  @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                        <a href="{{route('Admin.Formule.UpdatePage',['id'=>$data->id])}}" class="btn btn-outline-primary">Modifier </a>
                        <a href=""  data-toggle="modal" data-target="#smallmodal" class="btn btn-outline-danger ml-5">Supprimer </a>
                        
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm-10" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Voulez-vous vraiment supprimer la formule {{$data->Libelle}}?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <a type="button" href="{{route('Admin.Formule.Delete',['id' => $data->id])}}" class="btn btn-danger">Confirmer</a>
                </div>
            </div>
        </div>
    </div>
    @endsection


