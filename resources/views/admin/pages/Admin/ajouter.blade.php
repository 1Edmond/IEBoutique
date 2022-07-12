@extends('admin.layout.app')

@section('page')
    Administrateur
@endsection
@section('Information')
  Ajout d'un nouvel administrateur
@endsection


@section('content')
    <div class="card">
        @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card-header">
            Formulaire d'ajout d'<strong>un administrateur</strong>
        </div>
        <form action="{{ route('Admin.AddAdmin') }}" method="post" class="form">
            @csrf
            <div class="sufee-login d-flex align-content-center flex-wrap">
                <div class="container">
                    <div class="login-content">
                        <div class="login-form">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" class="form-control" value="{{old('Nom')}}" name="Nom" required placeholder="Saissez le nom">
                                @error('Nom')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" class="form-control" value="{{old('Prenom')}}" name="Prenom" required placeholder="Saissez le prénom">
                                @error('Prenom')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{old('Email')}}" name="Email" required placeholder="Saissez l'email">
                                @error('Email')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Adresse</label>
                                <input type="text" class="form-control" value="{{old('Adresse')}}" name="Adresse" required placeholder="Saissez l'adresse">
                                @error('Adresse')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Contact</label>
                                <input type="text" class="form-control" value="{{old('Contact')}}" name="Contact" required placeholder="Saissez le contact">
                                @error('Contact')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Pseudo</label>
                                <input type="text" class="form-control" value="{{old('Pseudo')}}" name="Pseudo" required placeholder="Saissez le pseudo">
                                @error('Pseudo')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Mot de passe</label>
                                <input type="password" class="form-control" name="Password"  required placeholder="Saisissez le mot de passe">
                                @error('Password')
                                <div class="alert alert-danger text-center" style="height: 45px">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
