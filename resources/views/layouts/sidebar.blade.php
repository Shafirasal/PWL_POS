<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu-->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            {{-- <li class="nav-item">
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Update Profil</p>
                </a>
            </li> --}}
   
            {{-- <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle" alt="User Avatar" style="width: 30px; height: 30px;">
                    <span class="ml-2">{{ auth()->user()->nama }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Update Profile
                    </a>
                </div>
            </li> --}}
            
            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 30px;" class="rounded-circle">
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('profile.show') }}">Update Biodata</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateAvatarModal">Update Avatar</a>
                </div>
            </li>
             --}}
{{--             
             <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 30px;" class="rounded-circle">
                  <p>
                    {{ Auth::user()->name }}
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link">
                      <i class="fas fa-user-edit mr-2"></i> Update Biodata
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#updateAvatarModal">
                      <i class="fas fa-camera mr-2"></i> Update Avatar
                    </a>
                  </li>
                </ul>
              </li> --}}
              
            

            
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/supplier') }}" class="nav-link {{ $activeMenu == 'supplier' ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data Supplier</p>
                </a>
            </li>
            <li class="nav-header">Data Barang</li>
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }} ">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Kategori Barang</p>
                </a>
                </11>
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ $activeMenu == 'barang' ? 'active' : '' }}">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Data Barang</p>
                </a>
            </li>
            <li class="nav-header">Data Transaksi</li>
            <li class="nav-item">
                <a href="{{ url('/stok') }}" class="nav-link {{ $activeMenu == 'stok' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Stok Barang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/penjualan') }}" class="nav-link {{ $activeMenu == 'penjualan' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Transaksi Penjualan</p>
                </a>
            </li>

            <!-- Menambahkan Menu Logout -->
            <li class="nav-header">Logout</li>
            <li class="nav-item">
                <a href="{{ url('logout') }}" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                 <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </nav>
</div>