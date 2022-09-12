@extends('client.layout.app')

@section('InfoLabel')
    Information sur votre profil.
@endsection



@section('InfoDescription')
    <p>
        Les informations sur votre profil vous sont affichées ci dessous
    </p>
@endsection

@section('content')
    <div class="invoice-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="invoice-wrap">
                        <div class="invoice-img">
                            <img src="img/logo/logo.png" alt="" />
                        </div>
                        <div class="invoice-hds-pro">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="invoice-cmp-ds ivc-frm">
                                        <div class="invoice-frm">
                                            <span>Adresse de la boutique</span>
                                        </div>
                                        <div class="comp-tl">
                                            <h2>Nom de la boutique</h2>
                                            <p>Email</p>
                                        </div>
                                        <div class="cmp-ph-em">
                                            <span>Site</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="invoice-cmp-ds ivc-to">
                                        <div class="invoice-frm">
                                            <span>Invoice to</span>
                                        </div>
                                        <div class="comp-tl">
                                            <h2>Mallinda Hollaway</h2>
                                            <p>10098 ABC Towers Uttara Silicon Oasis, Dubai, Bangladesh.</p>
                                        </div>
                                        <div class="cmp-ph-em">
                                            <span>01955239099</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="invoice-hs">
                                    <span class="text-center">Nombre de clients</span>
                                    <h2 class="text-center">{{ $Nbrclient }}</h2>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="invoice-hs date-inv sm-res-mg-t-30 tb-res-mg-t-30 tb-res-mg-t-0">
                                    <span class="text-center">Date de fin de l'abonnement</span>
                                    <h2 class="text-center">20/09/2022</h2>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="invoice-hs wt-inv sm-res-mg-t-30 tb-res-mg-t-30 tb-res-mg-t-0">
                                    <span class="text-center">Nombre de collègues</span>
                                    <h2 class="text-center">{{ count($users) }}</h2>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="invoice-hs gdt-inv sm-res-mg-t-30 tb-res-mg-t-30 tb-res-mg-t-0">
                                    <span class="text-center">Nombre d'abonnement</span>
                                    <h2 class="text-center">2</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="invoice-sp">
                                    <h4>
                                        Liste de vos collègues
                                    </h4>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Nom</th>
                                                <th class="text-center">Prénom</th>
                                                <th class="text-center">Pseudo</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Adresse</th>
                                                <th class="text-center">Contact</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" name="{{ $count = 1 }}">
                                            @forelse ($users as $item)
                                                <tr>
                                                    <td class="text-center">{{ $count }}</td>
                                                    <td class="text-center">{{ $item->Nom }}</td>
                                                    <td class="text-center">{{ $item->Prenom }}</td>
                                                    <td class="text-center">{{ $item->Pseudo }}</td>
                                                    <td class="text-center">{{ $item->Email }}</td>
                                                    <td class="text-center">{{ $item->Adresse }}</td>
                                                    <td class="text-center">{{ $item->Contact }}</td>
                                                </tr>
                                                <input type="hidden" name="{{ $count += 1 }}">
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center"> Pas de collègues à part vous
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-example-wrap mg-t-30">
                                    <div class="cmp-tb-hd cmp-int-hd">
                                        <h2>Vos informations</h2>
                                    </div>
                                    <div class="form-example-int form-horizental">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Email Address</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="text" value="{{ $info->Email }}" name="Email"
                                                            class="form-control input-sm" placeholder="Enter Email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental mg-t-15">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Nom</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="text" value="{{ $info->Nom }}" name="Nom"
                                                            class="form-control input-sm" placeholder="Votre nom">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental mg-t-15">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Prénom</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="text" value="{{ $info->Prenom }}" name="Prenom"
                                                            class="form-control input-sm" placeholder="Votre prénom">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental mg-t-15">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Adresse</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="text" value="{{ $info->Adresse }}"
                                                            name="Adresse" class="form-control input-sm"
                                                            placeholder="Votre adresse">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental mg-t-15">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Contact</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="text" value="{{ $info->Contact }}"
                                                            name="Contact" class="form-control input-sm"
                                                            placeholder="Votre contact">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int form-horizental mg-t-15">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                                    <label class="hrzn-fm">Pseudo</label>
                                                </div>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="nk-int-st">
                                                        <input type="text" value="{{ $info->Pseudo }}" name="Pseudo"
                                                            class="form-control input-sm" placeholder="Votre pseudo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-example-int mg-t-15">
                                        <div class="row">
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
                                            </div>
                                            <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
                                                <button class="btn btn-success notika-btn-success">Modifier</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
