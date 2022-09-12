 <div class="breadcomb-area">
     <div class="container">
         <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                 <div class="breadcomb-list">
                     <div class="row">
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                             <div class="breadcomb-wp">
                                 <div class="breadcomb-icon">
                                     @yield('InfoIcone')
                                     {{-- <i class="notika-icon notika-form"></i> --}}
                                 </div>
                                 <div class="breadcomb-ctn">
                                     <h2>
                                         @yield('InfoLabel')
                                     </h2>
                                     <p>
                                         @yield('InfoDescription')
                                     </p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
                             <div class="breadcomb-report">
                                 <a data-toggle="tooltip" href="{{ route('User.AddUserPage') }}" data-placement="left"
                                     title="Ajouter un utilisateur" class="btn"><i
                                         class="fa fa-plus"></i></a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
