@extends('client.layout.app')

@section('style')
    <link rel="stylesheet" href="/client/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/client/css/notification/notification.css">
@endsection

@section('InfoLabel')
    Page d'ajout de catégorie
@endsection



@section('InfoDescription')
    <p>
        Remplissez les champs du formulaire pour ajouter une nouvelle catégorie.
    </p>
@endsection


@section('content')
    <div class="data-table-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="data-table-list">
                        <div class="basic-tb-hd">
                            <h2>Formulaire d'ajout de catégorie.</h2>
                            <p>
                                Tous les champs ci dessous sont nécessaires pour ajouter une nouvele catégorie.
                            </p>
                        </div>
                        <form action="{{ route('User.Categorie.Add') }}" method="post">
                            @csrf
                            <div class="mb-3 col-lg-6">
                                <label for="Libelle" class="form-label">Libelle</label>
                                <input type="text" class="form-control" name="Libelle" id="Libelle"
                                    aria-describedby="helpLibelle" value="{{ old('Libelle') }}"
                                    placeholder="Saisissez le libelle de la catégorie">
                                <small id="helpLibelle" class="form-text text-muted">Libelle Help text</small>
                                @error('Libelle')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-6">
                                <label for="Description" class="form-label">Description</label>
                                <input type="text" class="form-control" name="Description" id="Description"
                                    value="{{ old('Description') }}" aria-describedby="helpDescription"
                                    placeholder="Saisissez la description de la catégorie">
                                <small id="helpDescription" class="form-text text-muted">Description Help text</small>
                                @error('Description')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-outline btn-primary ">
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/client/js/icheck/icheck.min.js"></script>
    <script src="/client/js/icheck/icheck-active.js"></script>
    <script src="/client/js/notification/bootstrap-growl.min.js"></script>
    <!-- Data Table JS
                                                                                                                                                                                                                                                                                      ============================================ -->
    <script src="/client/js/data-table/jquery.dataTables.min.js"></script>
    <script src="/client/js/data-table/data-table-act.js"></script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $.growl("{{ $error }}", {
                    type: 'info',
                    delay: 5000,
                });
            </script>
        @endforeach
    @endif
    @if (Session::get('success'))
        <script>
            $.growl("{{ Session::get('success') }}", {
                type: 'success',
                delay: 5000,
            });
        </script>
    @endif
    <script>
        $('#CategorieNavHeader').class = "active"
        $('#NavCategorie').class = "active"
    </script>
@endsection
