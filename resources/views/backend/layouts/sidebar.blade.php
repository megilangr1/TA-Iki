<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-header">NAVIGASI PROGRAM</li>
    <li class="nav-item">
      <a href="{{ route('backend.main') }}" class="nav-link {{ (request()->is('backend')) ? 'active':'' }}">
        <i class="nav-icon fa fa-home text-info"></i>
        <p>
          Halaman Utama
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-cogs text-secondary"></i>
        <p>
          Master Data
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('master-data.toko') }}" class="nav-link">
            <i class="fas fa-store text-sm nav-icon"></i>
            <p>Daftar Toko</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('master-data.kategori') }}" class="nav-link">
            <i class="fas fa-tags text-sm nav-icon"></i>
            <p>Daftar Kategori</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('master-data.barang') }}" class="nav-link">
            <i class="fas fa-boxes text-sm nav-icon"></i>
            <p>Daftar Barang</p>
          </a>
        </li>
      </ul>
    </li>

    {{-- <li class="nav-item {{ (request()->is('akun*')) || (request()->is('roles*')) ? 'menu-open' : '' }}">
      <a href="#" class="nav-link {{ (request()->is('akun*')) || (request()->is('roles*')) ? 'active' : '' }}">
        <i class="nav-icon fas fa-users text-secondary"></i>
        <p>
          Master Akun
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('roles.index') }}" class="nav-link {{ (request()->routeIs('roles*')) ? 'active':'' }}">
            <i class="fas fa-user-shield nav-icon"></i>
            <p>Hak Akses Akun</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('akun.index') }}" class="nav-link {{ (request()->routeIs('akun*')) ? 'active':'' }}">
            <i class="fas fa-users-cog nav-icon"></i>
            <p>Akun Pegawai</p>
          </a>
        </li>
      </ul>
    </li> --}}
  </ul>
</nav>