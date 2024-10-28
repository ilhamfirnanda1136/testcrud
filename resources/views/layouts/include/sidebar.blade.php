 <!-- Sidebar -->
 <style>
    
 </style>
 <div class="sidebar ">
     <!-- Sidebar user (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex"> 
         <div class="image">
             <img src="{{asset('')}}/img/avatar.png" class="img-circle elevation-2" alt="User Image">
         </div>
         <div class="info">
             <a href="#" class="d-block">SILA BAZNAS</a>
         </div>
     </div>

     <!-- Sidebar Menu -->
     <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
             <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
             <li class="nav-header">Modul Kategori</li>
             <li class="nav-item">
                <a href="{{asset('kategori')}}" class="nav-link {{request()->segment(1)=='kategori'? 'active' :''}}">
                    <i class="nav-icon fas fa-envelope-open"></i>
                    <p>
                       Kategori
                    </p>
                </a>
            </li>

         </ul>
     </nav>
     <!-- /.sidebar-menu -->
 </div>
